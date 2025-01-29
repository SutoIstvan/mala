<?php

namespace App\Services;

class UnasApiService
{
    private $apiKey;
    private $token;
    private $curl;

    public function __construct()
    {
        $this->apiKey = env('UNAS_API_KEY');
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

    public function getAllProducts($categoryId = '901601', $limit = 10)
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


        // Вывод полученных сырых данны 
        // $products = $response;
        // return $products;



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

            // if (isset($product->Types)) {
            //     $types = [];
            //     $types[] = [
            //         'type' => (string)$product->Types->Type ?? null, // Значение тега <Type>
            //         'parent' => isset($product->Types->Parent) ? (string)$product->Types->Parent : null, // Значение <Parent>
            //         'display' => isset($product->Types->Display) ? (int)$product->Types->Display : null, // Значение <Display>
            //         'order' => isset($product->Types->Order) ? (int)$product->Types->Order : null, // Значение <Order>
            //     ];
            //     $productData['types'] = $types;
            // }
            
            if (isset($product->Types)) {
                $types = [];
            
                // Преобразуем в массив, если `<Types>` встречается несколько раз
                $typesList = is_array($product->Types) ? $product->Types : [$product->Types];
            
                foreach ($typesList as $typeNode) {
                    // Получаем значение <Type>
                    $type = isset($typeNode->Type) ? (string)$typeNode->Type : null;
            
                    // Определяем, это parent или child
                    if ($type === 'child') {
                        $types[] = [
                            'type' => $type,
                            'parent' => isset($typeNode->Parent) ? (string)$typeNode->Parent : null,
                            'display' => isset($typeNode->Display) ? (int)$typeNode->Display : null,
                            'order' => isset($typeNode->Order) ? (int)$typeNode->Order : null,
                        ];
                    } elseif ($type === 'parent') {
                        // $children = [];
                        // if (isset($typeNode->Children->Child)) {
                        //     // Преобразуем в массив, если `<Child>` встречается несколько раз
                        //     $childrenList = is_array($typeNode->Children->Child) ? $typeNode->Children->Child : [$typeNode->Children->Child];
            
                        //     foreach ($childrenList as $child) {
                        //         $children[] = (string)$child;
                        //     }
                        // }

                        $children = [];
                        if (isset($typeNode->Children->Child)) {
                            foreach ($typeNode->Children->Child as $child) {
                                $children[] = (string)$child;
                            }
                        }
                        

            
                        $types[] = [
                            'type' => $type,
                            'children' => $children,
                            'order' => isset($typeNode->Order) ? (int)$typeNode->Order : null,
                        ];
                    }
                }
            
                $productData['types'] = $types;
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
    }

    public function __destruct()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }
}

