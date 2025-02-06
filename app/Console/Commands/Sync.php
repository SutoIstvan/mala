<?php

namespace App\Console\Commands;

use App\Models\ChildProduct;
use Illuminate\Console\Command;
use App\Services\UnasApiService;
use App\Services\ShopifyApiService;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class Sync extends Command
{
    protected $signature = 'app:sync';
    protected $description = 'Sync products between Unas and Shopify';

    public function handle(UnasApiService $unasService, ShopifyApiService $shopifyService)
    {
        // Получаем список товаров из Unas
        $unasProducts = $unasService->getAllProducts();

        // $this->info($unasProducts); 

        $this->info(json_encode($unasProducts, JSON_PRETTY_PRINT)); 


        // Создаем массив для хранения всех unas_id из текущей синхронизации
        $currentUnasIds = [];

        foreach ($unasProducts as $unasProduct) {
            try {
                $currentUnasIds[] = $unasProduct['unas_id'];
    
                // Добавим отладочную информацию о типе товара
                $this->info('Processing product: ' . $unasProduct['name']);
                $this->info('Product type data: ' . json_encode($unasProduct['types'] ?? []));
    
                if (!$this->isParentProduct($unasProduct)) {
                    $this->info('This is a child product');
                    $this->handleChildProduct($unasProduct, $shopifyService);
                    continue;
                }
    
                $this->info('This is a parent product');
                // ... остальной код для родительских товаров ...
            } catch (\Exception $e) {
                $this->error('Error processing product: ' . $unasProduct['name']);
                $this->error($e->getMessage());
                // Можно добавить continue здесь, если хотим продолжить обработку остальных товаров
                throw $e;
            }
        }

        // Удаление товаров, которых больше нет в Unas
        // Используем массив текущих unas_id для проверки
        $this->removeDeletedProducts($currentUnasIds, $shopifyService);
    }

    private function isParentProduct($unasProduct)
{
    // Если в данных товара нет типа "child", считаем его родительским
    return !isset($unasProduct['types']) || 
           !collect($unasProduct['types'])->contains('type', 'child');
}


private function updateParentProductVariants($parentProduct, $unasProduct, $shopifyService)
{

    $this->error("❌ updateParentProductVariants" );

    
    // Получаем текущие варианты родительского товара
    // $variants = json_decode($parentProduct->variants, true) ?? [];

    // // Добавляем новый вариант (дочерний товар)
    // $newVariant = [
    //     'sku' => $unasProduct['sku'], // Например, 'OLIVER-WHITE-001-M'
    //     'name' => $unasProduct['name'], // Например, 'Size M'
    //     'price' => $unasProduct['price'], // Например, 21.99
    //     'inventory_management' => 'shopify',
    //     'inventory_quantity' => $unasProduct['quantity'] ?? 0
    // ];

    // // Добавляем новый вариант в массив
    // $variants[] = $newVariant;

    // // Обновляем варианты в Shopify
    // $shopifyService->updateProductVariants($parentProduct->shopify_id, $variants);

    // // Обновляем варианты в локальной базе данных
    // $parentProduct->variants = json_encode($variants);
    // $parentProduct->save();
}

    private function createNewProduct($unasProduct, $shopifyService)
    {
        // Сначала создаем запись в Laravel
        $product = Product::create([
            'sku' => $unasProduct['sku'],
            'unas_id' => $unasProduct['unas_id'],
            'state' => $unasProduct['state'],
            'name' => $unasProduct['name'],
            'price' => $unasProduct['price'],
            'unit' => $unasProduct['unit'],
            'url' => $unasProduct['url'],
            'qty' => $unasProduct['qty'],
            'category' => $unasProduct['category'],
            'description' => $unasProduct['description'],
            'images' => json_encode($unasProduct['images']),
            'params' => json_encode($unasProduct['params'] ?? []),
            'variants' => json_encode($unasProduct['variants'] ?? []), // Empty array by default
            // 'variants' => json_encode($unasProduct['variants']),
            'statuses' => json_encode($unasProduct['statuses']),
            'history' => json_encode($unasProduct['history'] ?? []), // Empty array by default
            // 'history' => json_encode($unasProduct['history']),
            'types' => json_encode($unasProduct['types'] ?? []), // Empty array by default
            'datas' => json_encode($unasProduct['datas'] ?? []), // Empty array by default
            // 'datas' => json_encode($unasProduct['datas']),
            'create_time' => $unasProduct['create_time'],
            'last_mod_time' => $unasProduct['last_mod_time'],
        ]);

        $this->info('Add product: ' . $unasProduct['name']);


        try {
            // Затем создаем в Shopify
            $shopifyId = $shopifyService->createProduct($unasProduct);

            // Обновляем запись в Laravel с shopify_id
            $product->shopify_id = $shopifyId;
            $product->save();

            return $product;
        } catch (\Exception $e) {
            // В случае ошибки с Shopify, не удаляем из Laravel
            Log::error("Error creating Shopify product: " . $e->getMessage());
            throw $e;
        }
    }

    private function removeDeletedProducts($currentUnasIds, $shopifyService)
    {
        // Находим все товары, которых нет в текущем списке Unas
        $deletedProducts = Product::whereNotIn('unas_id', $currentUnasIds)
            ->whereNotNull('shopify_id') // убедимся, что у товара есть shopify_id
            ->get();
    
        foreach ($deletedProducts as $product) {
            try {
                // Сначала удаляем из Shopify
                $shopifyService->deleteProduct($product->shopify_id);
                $this->info("Товар удален из Shopify: {$product->name} (ID: {$product->shopify_id})");
                
                // Потом удаляем из нашей базы
                $product->delete();
                $this->info("Товар удален из базы данных: {$product->name}");
            } catch (\Exception $e) {
                $this->error("Ошибка при удалении товара {$product->name}: " . $e->getMessage());
            }
        }
    }

    private function hasProductChanged($existingProduct, $unasProduct)
    {
        return
            $existingProduct->name !== $unasProduct['name'] ||
            $existingProduct->price != $unasProduct['price'] ||
            $existingProduct->sku !== $unasProduct['sku'] ||
            $existingProduct->description !== $unasProduct['description'];
    }

    private function updateProduct($existingProduct, $unasProduct, $shopifyService)
    {
        // Сначала обновляем в Laravel
        $existingProduct->name = $unasProduct['name'];
        $existingProduct->price = $unasProduct['price'];
        $existingProduct->sku = $unasProduct['sku'];
        $existingProduct->description = $unasProduct['description'];
        $existingProduct->save();

        try {
            // Затем обновляем в Shopify
            if ($existingProduct->shopify_id) {
                $shopifyService->updateProduct($existingProduct->shopify_id, $unasProduct);
            }
        } catch (\Exception $e) {
            Log::error("Error updating Shopify product: " . $e->getMessage());
            throw $e;
        }
    }




    private function handleChildProduct($unasProduct, $shopifyService)
    {
        $parentProduct = $this->findParentProduct($unasProduct);
        
        if (!$parentProduct) {
            $this->error("Parent product not found for child: " . $unasProduct['name']);
            return;
        }

        try {
            $parentProductId = $this->findParentProduct($unasProduct);

            if (!$parentProductId) {
                $this->error("Parent product not found for child: " . $unasProduct['name']);
                return;
            }
            
            $childData = [
                'parent_product_id' => $parentProductId, // Просто ID без ->id
                'unas_id' => (string)$unasProduct['unas_id'],
                'sku' => $unasProduct['sku'],
                'name' => $unasProduct['name'],
                'price' => (float)$unasProduct['price'],
                'qty' => (int)($unasProduct['qty'] ?? 0),
                // 'params' => $unasProduct['params'] ?? [],
                // 'variants' => $unasProduct['variants'] ?? [],
                // 'images' => $unasProduct['images'] ?? []
            ];

            $existingChild = ChildProduct::where('unas_id', $unasProduct['unas_id'])->first();

            if ($existingChild) {
                $existingChild->fill($childData)->save();
            } else {
                ChildProduct::create($childData);
            }

            $this->updateParentProductVariants($parentProduct, $unasProduct, $shopifyService);

        } catch (\Exception $e) {
            $this->error('Error details: ' . $e->getMessage());
            throw $e;
        }
    }

    private function findParentProduct($unasProduct)
    {
        if (empty($unasProduct['types'][0]['parent'])) {
            return null;
        }
    
        $parentId = $unasProduct['types'][0]['parent'];
    
        $this->info("Looking for parent product with identifier: " . $parentId);
    
        return Product::where('sku', $parentId)
                     ->orWhere('unas_id', $parentId)
                     ->value('id'); // Здесь мы берём только id
    }
    
    

}
