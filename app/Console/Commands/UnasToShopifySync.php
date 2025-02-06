<?php

namespace App\Console\Commands;

use App\Models\ChildProduct;
use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\UnasApiService;
use App\Services\ShopifyApiService;
use GuzzleHttp\Client;

class UnasToShopifySync extends Command
{
    protected $signature = 'sync:unas-shopify';
    protected $description = 'Sync products from UNAS to Shopify through Laravel';

    private $skippedProducts = [];
    private $client;

    public function handle(UnasApiService $unasService, ShopifyApiService $shopifyService)
    {
        try {
            // 1. Получение товаров из UNAS
            $unasProducts = $unasService->getAllProducts();

            // $this->info(json_encode($unasProducts, JSON_PRETTY_PRINT)); 

            foreach ($unasProducts as $product) {

                $this->info("------------------------------------");

                // 3. Проверка на родительский/дочерний товар
                if ($this->isParentProduct($product)) {
                    // 4. Создание родительского товара
                    $this->createParentProduct($product);
                } else {
                    // 5. Обработка дочернего товара
                    $this->handleChildProduct($product);
                }
            }

            // Повторная попытка создания пропущенных дочерних товаров
            $this->retrySkippedChildren();

            // 6. Синхронизация с Shopify
            $this->syncToShopify();

            // Затем создаем в Shopify
            $shopifyService->createProduct($product);
        } catch (\Exception $e) {
            $this->error("Error during sync: " . $e->getMessage());
        }
    }

    private function isParentProduct($product)
    {
        // Если у товара нет типа "child", значит, он родитель
        if (empty($product['types'])) {
            $this->info($product['name'] . " — Parent");
            return true;
        }

        foreach ($product['types'] as $type) {
            if ($type['type'] === 'child') {
                $this->info($product['name'] . " — Child");
                return false;
            }
        }

        // Если поле types есть, но нет типа "child", считаем товар родителем
        $this->info($product['name'] . " — Parent");
        return true;
    }


    private function createParentProduct($product)
    {
        $existingProduct = Product::where('unas_id', $product['unas_id'])->first();

        if ($existingProduct) {
            if ($existingProduct->last_mod_time == $product['last_mod_time']) {
                $this->info("Пропущен: {$product['name']} (без изменений)");
                return;
            }

            // Обновляем товар, если last_mod_time изменился
            $existingProduct->update([
                'sku' => $product['sku'],
                'state' => $product['state'],
                'name' => $product['name'],
                'price' => $product['price'],
                'unit' => $product['unit'],
                'url' => $product['url'],
                'qty' => $product['qty'],
                'category' => $product['category'],
                'description' => $product['description'],
                'images' => json_encode($product['images']),
                'params' => json_encode($product['params']),
                'statuses' => json_encode($product['statuses']),
                'last_mod_time' => $product['last_mod_time'], // Обновляем время изменения
            ]);

            $this->info("Обновлен: {$product['name']} (unas_id: {$product['unas_id']})");
        } else {
            // Создаем новый товар
            Product::create([
                'sku' => $product['sku'],
                'unas_id' => $product['unas_id'],
                'state' => $product['state'],
                'name' => $product['name'],
                'price' => $product['price'],
                'unit' => $product['unit'],
                'url' => $product['url'],
                'qty' => $product['qty'],
                'category' => $product['category'],
                'description' => $product['description'],
                'images' => json_encode($product['images']),
                'params' => json_encode($product['params']),
                'statuses' => json_encode($product['statuses']),
                'history' => json_encode([]),
                'types' => json_encode($product['types']),
                'datas' => json_encode([]),
                'create_time' => $product['create_time'],
                'last_mod_time' => $product['last_mod_time'],
            ]);

            $this->info("Добавлен новый: {$product['name']} (unas_id: {$product['unas_id']})");
        }
    }

    private function handleChildProduct($product)
    {
        $this->info("Обрабатываем продукт (SKU: {$product['sku']})");

        // 7. Проверка существования и обновления
        if ($this->productExists($product)) {
            $this->info("Продукт уже существует в БД (SKU: {$product['sku']})");

            if ($this->needsUpdate($product)) {
                $this->info("Обновляем продукт (SKU: {$product['sku']})");
                $this->updateProduct($product);
                $this->updateShopifyProduct($product);
            }
            return;
        }

        // Проверка наличия родителя
        if (!$this->parentExists($product)) {
            $this->addToSkippedProducts($product);
            $this->warn("Родительский товар не найден (SKU: {$product['sku']}), добавляем в пропущенные");
            $this->addToSkippedProducts($product);
            return;
        }

        $this->info("Создаём дочерний продукт (SKU: {$product['sku']})");
        $this->createChildProduct($product);
    }


    private function productExists($product)
    {
        // TODO: Проверка существования товара
    }

    private function needsUpdate($product)
    {
        // TODO: Сравнение дат обновления
    }

    private function updateProduct($product)
    {
        // TODO: Обновление товара в Laravel
    }

    private function updateShopifyProduct($product)
    {
        // TODO: Обновление товара в Shopify
    }

    private function parentExists($product)
    {
        $parentSku = $this->getParentSku($product);
        $parent = Product::where('sku', $parentSku)->first();

        if ($parent) {
            // $this->info("Родительский товар найден: {$parent->name} (ID: {$parent->id})");
            return true;
        }

        // $this->warn("Родительский товар НЕ найден (SKU: {$parentSku})");
        return false;
    }

    private function getParentSku($product)
    {
        // Проверяем, есть ли информация о родителе в массиве types
        if (isset($product['types']) && is_array($product['types'])) {
            foreach ($product['types'] as $type) {
                if ($type['type'] === 'child' && isset($type['parent'])) {
                    $parentSku = $type['parent'];
                    // $this->info("SKU родителя для {$product['sku']}: {$parentSku}");
                    return $parentSku;
                }
            }
        }

        // Если не нашли родителя, можно вернуть оригинальный SKU
        $this->info("Родитель не найден для {$product['sku']}, возвращаем оригинальный SKU.");
        return $product['sku'];
    }



    private function addToSkippedProducts($product)
    {
        // TODO: Добавление в список пропущенных товаров
    }

    private function createChildProduct($product)
    {
        // $this->info("Обрабатываем дочерний товар: {$product['name']} (SKU: {$product['sku']})");

        // Получаем SKU родителя
        $parentSku = $this->getParentSku($product);
        // $this->info("Ищем родительский товар по SKU: {$parentSku}");

        // Ищем родительский товар в базе
        $parentProduct = Product::where('sku', $parentSku)->first();

        if (!$parentProduct) {
            $this->warn("Родительский товар ({$parentSku}) не найден, пропускаем: {$product['name']}");
            return;
        }

        $this->info("Родитель найден: {$parentProduct->name} (ID: {$parentProduct->id})");

        // Проверяем, существует ли уже этот дочерний продукт
        $existingChild = ChildProduct::where('sku', $product['sku'])->first();

        if ($existingChild) {
            $this->warn("Дочерний товар уже существует: {$existingChild->name} (SKU: {$existingChild->sku})");
            return;
        }

        // Создаем дочерний товар
        $childProduct = ChildProduct::create([
            'sku' => $product['sku'],
            'unas_id' => $product['unas_id'],
            'parent_product_id' => $parentProduct->id,
            'state' => $product['state'],
            'name' => $product['name'],
        ]);

        if ($childProduct) {
            $this->info("Добавлен дочерний товар: {$childProduct->name} (ID: {$childProduct->id})");
        } else {
            $this->error("Ошибка при добавлении дочернего товара: {$product['name']}");
        }
    }

    private function retrySkippedChildren() {}




    private function syncToShopify()
    {
        // Получаем все родительские продукты
        $parentProducts = Product::has('childProducts')->get();
    
        if ($parentProducts->isEmpty()) {
            $this->warn("Нет товаров для синхронизации");
            return;
        }
    
        $baseUrl = 'https://' . env('SHOPIFY_SHOP_DOMAIN');
        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN'),
                'Content-Type' => 'application/json',
            ],
        ]);
    
        foreach ($parentProducts as $parentProduct) {
            try {
                // Получаем дочерние продукты
                $childProducts = $parentProduct->childProducts;
    
                // Создаем основной продукт
                $shopifyProduct = [
                    'product' => [
                        'title' => $parentProduct->name,
                        'body_html' => $parentProduct->description,
                        'vendor' => 'Your Store',
                        'product_type' => $parentProduct->category ?? '',
                        'variants' => [],
                    ]
                ];
    
                // Добавляем варианты из дочерних продуктов
                foreach ($childProducts as $childProduct) {
                    $shopifyProduct['product']['variants'][] = [
                        'sku' => $childProduct->sku,
                        'price' => $childProduct->price,
                        'inventory_quantity' => $childProduct->qty,
                        'inventory_management' => 'shopify',
                        'title' => $childProduct->name,
                        'option1' => $childProduct->name, // Или другое значение, которое определяет вариант
                    ];
                }
    
                // Добавляем опции для вариантов
                $shopifyProduct['product']['options'] = [
                    [
                        'name' => 'Type',
                        'values' => $childProducts->pluck('name')->toArray()
                    ]
                ];
    
                // Добавляем изображения
                $images = json_decode($parentProduct->images, true) ?? [];
                if (!empty($images)) {
                    $shopifyProduct['product']['images'] = array_map(function ($image) {
                        return [
                            'src' => $image['url'],
                            'alt' => $image['alt'] ?? ''
                        ];
                    }, $images);
                }
    
                // Отправляем запрос в Shopify
                $response = $this->client->post('/admin/api/2024-01/products.json', [
                    'json' => $shopifyProduct
                ]);
    
                $responseData = json_decode($response->getBody(), true);
                
                // Сохраняем ID из Shopify
                $parentProduct->shopify_id = $responseData['product']['id'];
                $parentProduct->save();
    
                $this->info("Успешно добавлен товар: {$parentProduct->name}");
    
            } catch (\Exception $e) {
                $this->error("Ошибка при добавлении товара {$parentProduct->name}: " . $e->getMessage());
            }
        }
    }
}
