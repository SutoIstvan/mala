<?php

namespace App\Services;

class UnasApiService
{
    private $apiKey;
    private $token;
    private $curl;

    public function __construct()
    {
        $this->apiKey = config('unas.api_key', 'c9fee685261d00f137f44f4d203ed5ed67fca717');
        $this->initCurl();
    }

    private function initCurl()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function login()
    {
        $loginRequest = sprintf(
            '<?xml version="1.0" encoding="UTF-8"?><Params><ApiKey>%s</ApiKey><WebshopInfo>true</WebshopInfo></Params>',
            $this->apiKey
        );

        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/login");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $loginRequest);

        $response = curl_exec($this->curl);
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($this->curl));
        }

        $loginXml = simplexml_load_string($response);
        $this->token = (string)$loginXml->Token;

        if (!$this->token) {
            throw new \Exception('Failed to get token: ' . $response);
        }

        return $this->token;
    }

    public function getAllProducts($categoryId = '901601', $limit = 3)
    {
        if (!$this->token) {
            $this->login();
        }

        $headers = [
            "Authorization: Bearer " . $this->token,
            "Content-Type: application/xml"
        ];

        $productRequest = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <Params>
            <StatusBase>1</StatusBase>
            <CategoryId>{$categoryId}</CategoryId>
            <ContentType>full</ContentType>
            <LimitNum>{$limit}</LimitNum>
        </Params>
        XML;

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/getProduct");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $productRequest);



        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($this->curl);
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($this->curl));
        }

        $productsXml = simplexml_load_string($response);
        if (!$productsXml) {
            throw new \Exception('XML parsing error: ' . $response);
        }

        // XML convert
        $products = [];
        foreach ($productsXml->Product as $product) {
            $productData = [
                'sku' => (string)$product->Sku,
                'unas_id' => (string)$product->Id,
                'state' => (string)$product->State,
                'name' => (string)$product->Name,
                'price' => (string)$product->Prices->Price->Gross,
                'unit' => (string)$product->Unit,
                'create_time' => (string)$product->CreateTime,
                'last_mod_time' => (string)$product->LastModTime,
                'category' => (string)$product->Categories->Category->Name,
                'description' => (string)$product->Description->Long,
                'url' => (string)$product->Url,
                'qty' => (string)$product->Stocks->Stock->Qty,
            ];

            if (isset($product->Images->Image)) {
                $images = [];
                foreach ($product->Images->Image as $image) {
                    $images[] = [
                        'url' => (string)$image->Url->Medium,
                        'alt' => (string)$image->Alt,
                    ];
                }
                $productData['images'] = $images;
            }

            if (isset($product->Params->Param)) {
                $params = [];
                foreach ($product->Params->Param as $category) {
                    $params[] = [
                        'type' => (string)$category->Type,
                        'id' => (string)$category->Id,
                        'name' => (string)$category->Name,
                        'value' => (string)$category->Value
                    ];
                }
                $productData['params'] = $params;
            }

            if (isset($product->Variants->Variant)) {
                $variants = [];
                foreach ($product->Variants->Variant as $variant) {
                    $variantData = [
                        'name' => (string)$variant->Name,
                        'values' => [],
                    ];

                    if (isset($variant->Values->Value)) {
                        foreach ($variant->Values->Value as $value) {
                            $valueData = [
                                'name' => (string)$value->Name,
                            ];

                            if (isset($value->ExtraPrice)) {
                                $valueData['extra_price'] = (string)$value->ExtraPrice;
                            }

                            $variantData['values'][] = $valueData;
                        }
                    }

                    $variants[] = $variantData;
                }

                $productData['variants'] = $variants;
            }

            if (isset($product->Statuses->Status)) {
                $statuses = [];
                foreach ($product->Statuses->Status as $status) {
                    $statusData = [
                        'type' => (string)$status->Type,
                        'value' => (string)$status->Value,
                    ];

                    if (isset($status->Id)) {
                        $statusData['id'] = (string)$status->Id;
                    }
                    if (isset($status->Name)) {
                        $statusData['name'] = (string)$status->Name;
                    }

                    $statuses[] = $statusData;
                }

                $productData['statuses'] = $statuses;
            }

            if (isset($product->History->Event)) {
                $history = [];
                foreach ($product->History->Event as $event) {
                    $eventData = [
                        'action' => (string)$event->Action, // Действие (например, "add" или "modify")
                        'time' => (string)$event->Time, // Время события
                        'sku' => (string)$event->Sku, // Текущий SKU
                    ];

                    // Если есть старый SKU, добавляем его
                    if (isset($event->SkuOld)) {
                        $eventData['sku_old'] = (string)$event->SkuOld;
                    }

                    $history[] = $eventData;
                }

                $productData['history'] = $history;
            }

            if (isset($product->Datas->Data)) {
                $datas = [];
                foreach ($product->Datas->Data as $data) {
                    $dataItem = [
                        'id' => (string)$data->Id, // ID данных
                        'name' => (string)$data->Name, // Название данных
                        'value' => (string)$data->Value, // Значение данных
                    ];
            
                    $datas[] = $dataItem;
                }
            
                $productData['datas'] = $datas;
            }


            $products[] = $productData;
        }

        return $products;

        // curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        // $response = curl_exec($this->curl);

        // return $products; // Возвращаем сырой ответ

        // $response = curl_exec($this->curl);
        // if ($response === false) {
        //     throw new \Exception('Curl error: ' . curl_error($this->curl));
        // }

        // $productsXml = simplexml_load_string($response);
        // if (!$productsXml) {
        //     throw new \Exception('XML parsing error: ' . $response);
        // }

        // return $productsXml->Product;
    }

    public function __destruct()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }
}
