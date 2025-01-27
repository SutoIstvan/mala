<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnasApiService;
use App\Services\ShopifyApiService;
use App\Models\Product;

class Sync extends Command
{
    protected $signature = 'app:sync';
    protected $description = 'Sync products between Unas and Shopify';

    public function handle(UnasApiService $unasService, ShopifyApiService $shopifyService)
    {
        // Получаем список товаров из Unas
        $unasProducts = $unasService->getAllProducts();

        $this->info(json_encode($unasProducts, JSON_PRETTY_PRINT));


        foreach ($unasProducts as $unasProduct) {
            $existingProduct = Product::where('unas_sku', $unasProduct['sku'])->first();

            if (!$existingProduct) {
                // Создаем новый товар, если его нет в базе
                $newProduct = $this->createNewProduct($unasProduct, $unasService, $shopifyService);
            } else {
                // Проверяем, были ли изменения
                if ($this->hasProductChanged($existingProduct, $unasProduct)) {
                    $this->updateProduct($existingProduct, $unasProduct, $unasService, $shopifyService);
                }
            }
        }

        // Удаление товаров, которых больше нет в Unas
        $this->removeDeletedProducts($unasProducts, $shopifyService);
    }

    private function createNewProduct($unasProduct, $unasService, $shopifyService)
    {
        // Логика создания нового товара в базе Laravel
        $product = Product::create([
            'unas_sku' => $unasProduct['sku'],
            'name' => $unasProduct['name'],
            // другие поля
        ]);

        // Создание товара в Shopify
        $shopifyProductId = $shopifyService->createProduct($unasProduct);
        $product->shopify_product_id = $shopifyProductId;
        $product->save();

        return $product;
    }

    private function updateProduct($existingProduct, $unasProduct, $unasService, $shopifyService)
    {
        // Обновление товара в базе Laravel
        $existingProduct->update([
            'name' => $unasProduct['name'],
            'price' => $unasProduct['price'],
            // другие поля
            'updated_at' => now()
        ]);

        // Обновление товара в Shopify
        $shopifyService->updateProduct($existingProduct->shopify_product_id, $unasProduct);
    }

    private function removeDeletedProducts($unasProducts, $shopifyService)
    {
        // Получаем список SKU из Unas
        $unasSKUs = collect($unasProducts)->pluck('sku');

        // Находим товары в базе, которых нет в Unas
        $productsToRemove = Product::whereNotIn('unas_sku', $unasSKUs)->get();

        foreach ($productsToRemove as $product) {
            // Удаление из Shopify
            $shopifyService->deleteProduct($product->shopify_product_id);
            
            // Удаление из базы Laravel
            $product->delete();
        }
    }

    private function hasProductChanged($existingProduct, $unasProduct)
    {
        // Логика проверки изменений товара
        return 
            $existingProduct->name !== $unasProduct['name'] ||
            $existingProduct->price !== $unasProduct['price'] ||
            // другие поля для сравнения
            false;
    }
}