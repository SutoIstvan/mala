<?php

namespace App\Services;

use GuzzleHttp\Client;

class ShopifyApiService
{

    private $client;
    private $collectionId;

    public function __construct()
    {

        $baseUrl = 'https://' . env('SHOPIFY_SHOP_DOMAIN');
        $this->collectionId = 642703360346;

        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createProduct($unasProduct)
    {
        // $params = json_decode($unasProduct->params, true);
        // $metaArray = [];

        // // Подготовка метаданных
        // foreach ($params as $param) {
        //     if (!empty($param['Id']) && !empty($param['Name']) && !empty($param['Value'])) {
        //         $metaArray[] = trim($param['Name']) . ': ' . trim($param['Value']);
        //     }
        // }

        $shopifyProduct = [
            'product' => [
                'title' => $unasProduct['name'],
                'body_html' => $unasProduct['description'],

                'variants' => [
                    [
                        'price' => $unasProduct['price'],
                        'sku' => $unasProduct['sku'],
                    ],
                ],

                // 'metafields' => [
                //     [
                //         'namespace' => 'custom',
                //         'key' => 'meta',
                //         'value' => $metaString,
                //         'type' => 'list.single_line_text_field'
                //     ],
                // ],
                
            ],
        ];


        // Проверяем существование и тип поля images
        $images = isset($unasProduct['images']) ? (is_string($unasProduct['images']) ? json_decode($unasProduct['images'], true) : $unasProduct['images']) : [];

        // Проверяем, что $images — массив и не пустой
        if (is_array($images) && !empty($images)) {
            // Преобразуем массив изображений для Shopify
            $shopifyProduct['product']['images'] = array_map(function ($image) {
                if (isset($image['url'])) {
                    return ['src' => $image['url'], 'alt' => $image['alt'] ?? ''];
                }
                return null; // Если url отсутствует
            }, $images);

            // Убираем пустые элементы, если какие-то изображения некорректны
            $shopifyProduct['product']['images'] = array_filter($shopifyProduct['product']['images']);
        }


        try {
            // Создание продукта
            $response = $this->client->post('/admin/api/2024-01/products.json', [
                'json' => $shopifyProduct
            ]);

            $responseData = json_decode($response->getBody(), true);

            // Добавление в коллекцию
            if (isset($responseData['product']['id'])) {
                $this->addToCollection($responseData['product']['id']);
                return $responseData['product']['id'];
            }
        } catch (\Exception $e) {
            throw new \Exception("Error creating Shopify product: " . $e->getMessage());
        }
    }

    public function updateProduct($productId, $productData)
    {
        return $this->makeRequest('PUT', "/admin/api/products/{$productId}.json", [
            'product' => $this->formatProductData($productData)
        ]);
    }

    public function deleteProduct($productId)
    {
        try {
            $response = $this->client->delete("/admin/api/2023-01/products/{$productId}.json");
    
            if ($response->getStatusCode() === 200) {
                return [
                    'success' => true,
                    'message' => "Product with ID {$productId} has been successfully deleted.",
                ];
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return [
                'success' => false,
                'message' => "Error deleting product: " . $e->getMessage(),
            ];
        }
        
        return $this->makeRequest('DELETE', "/admin/api/products/{$productId}.json");
    }

    private function formatProductData($data)
    {
        return [
            'title' => $data['name'],
            'sku' => $data['sku'],
            'price' => $data['price'],
            // Другие поля
        ];
    }

    private function makeRequest($method, $endpoint, $data = [])
    {
        // Реализация HTTP запроса к Shopify API
        // Возвращает декодированный JSON ответ
    }

    private function addToCollection($productId)
    {
        try {
            $this->client->post('/admin/api/2024-01/collects.json', [
                'json' => [
                    'collect' => [
                        'collection_id' => $this->collectionId,
                        'product_id' => $productId
                    ]
                ]
            ]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Error adding product to collection: " . $e->getMessage());
        }
    }
}
