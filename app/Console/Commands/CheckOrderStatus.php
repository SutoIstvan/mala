<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnasApiService;
use App\Models\Order;

class CheckOrderStatus extends Command
{
    protected $signature = 'unas:check-status';
    protected $description = 'Проверка статусов заказов в главном магазине и синхронизация с исходными магазинами';

    public function handle()
    {
        $mainKey = env('UNAS_API_KEY_MAIN');
        $mainUnas = new UnasApiService($mainKey);

        // Ключи магазинов для обратной синхронизации
        $shopKeys = [
            'shop1' => env('UNAS_API_KEY_SHOP1'),
            'shop2' => env('UNAS_API_KEY_SHOP2'),
            // 'shop3' => env('UNAS_API_KEY_SHOP3'),
        ];

        // --- ПРОВЕРКА СТАТУСОВ ЗАКАЗОВ В ГЛАВНОМ МАГАЗИНЕ ---
        $this->info("Проверяем статусы заказов в главном магазине...");
        
        $paramsXml = '<?xml version="1.0" encoding="UTF-8"?><Params><ContentType>full</ContentType><LimitNum>100</LimitNum></Params>';
        $mainOrdersResponse = $mainUnas->getOrders($paramsXml);

        $this->line("Тип ответа getOrders: " . gettype($mainOrdersResponse));
        $this->line("Количество заказов в главном магазине: " . (isset($mainOrdersResponse->Order) ? count($mainOrdersResponse->Order) : 0));

        $updatedCount = 0;

        if ($mainOrdersResponse && isset($mainOrdersResponse->Order)) {
            foreach ($mainOrdersResponse->Order as $mainOrder) {
                $mainOrderKey = (string)$mainOrder->Key;
                $mainStatus = (string)$mainOrder->Status;
                $statusDateMod = (string)$mainOrder->StatusDateMod;

                $this->line("Проверяем заказ из главного магазина: Key=$mainOrderKey, Status=$mainStatus");

                // Обрезаем ключ до формата, который хранится в базе (убираем префикс)
                $shortKey = $this->extractShortKey($mainOrderKey);
                $this->line("Ищем локальный заказ по ключу: '$shortKey' (из полного ключа '$mainOrderKey')");
                
                // Найдем локальный заказ по сокращенному ключу
                $localOrder = Order::where('main_shop_key', $shortKey)->first();
                
                if ($localOrder) {
                    $this->line("Найден локальный заказ: ID={$localOrder->id}, external_id={$localOrder->external_id}, external_shop={$localOrder->external_shop}, текущий статус='{$localOrder->status}'");
                    
                    // Проверяем, изменился ли статус
                    if ($localOrder->status !== $mainStatus) {
                        $oldStatus = $localOrder->status;
                        
                        $this->line("Статус изменился: '$oldStatus' -> '$mainStatus'");
                        
                        // Обновляем статус в локальной базе
                        $localOrder->status = $mainStatus;
                        $result = $localOrder->save();
                        
                        $this->line("Результат сохранения в локальной базе: " . ($result ? 'успешно' : 'ошибка'));
                        
                        // --- ОБРАТНАЯ СИНХРОНИЗАЦИЯ В ИСХОДНЫЙ МАГАЗИН ---
                        $this->syncStatusToOriginalShop($localOrder, $mainStatus, $shopKeys);
                        
                        $this->info("Обновлен статус заказа {$localOrder->external_id} из {$localOrder->external_shop}: {$oldStatus} -> {$mainStatus}");
                        
                        $updatedCount++;
                    } else {
                        $this->line("Статус не изменился ('{$localOrder->status}' == '$mainStatus')");
                    }
                } else {
                    $this->line("Локальный заказ с main_shop_key='$shortKey' не найден");
                }
            }
        } else {
            $this->warn("Не удалось получить заказы из главного магазина для проверки статусов");
        }

        $this->info("Проверка статусов завершена. Обновлено заказов: $updatedCount");
    }

    /**
     * Извлекает короткий ключ из полного ключа
     * Например: "13526-100418" -> "100418"
     */
    private function extractShortKey($fullKey)
    {
        $parts = explode('-', $fullKey);
        // Возвращаем последнюю часть после дефиса, если есть дефис
        return count($parts) > 1 ? end($parts) : $fullKey;
    }

    /**
     * Синхронизация статуса заказа в исходный магазин
     */
    private function syncStatusToOriginalShop($order, $newStatus, $shopKeys)
    {
        $shopKey = $order->external_shop;
        
        if (!isset($shopKeys[$shopKey])) {
            $this->warn("Ключ API для магазина '$shopKey' не найден");
            return;
        }

        $this->line("Синхронизируем статус в исходный магазин '$shopKey'...");
        
        try {
            $shopUnas = new UnasApiService($shopKeys[$shopKey]);
            
            // Создаем XML для обновления статуса заказа
            $updateXml = $this->createStatusUpdateXml($order->key, $newStatus);
            
            $this->line("XML для обновления статуса:\n$updateXml");
            
            // Отправляем обновление в исходный магазин
            $response = $shopUnas->setOrders($updateXml);
            
            $this->line("Ответ от магазина '$shopKey':\n$response");
            
            // Проверяем ответ
            if (is_string($response)) {
                $responseXml = simplexml_load_string($response);
            } else {
                $responseXml = $response;
            }
            
            if ($responseXml && isset($responseXml->Order)) {
                $orderResult = $responseXml->Order;
                if ((string)$orderResult->Status === 'ok') {
                    $this->info("Статус успешно обновлен в магазине '$shopKey' для заказа {$order->external_id}");
                } else {
                    $this->error("Ошибка обновления статуса в магазине '$shopKey': " . (string)$orderResult->Status);
                }
            } else {
                $this->error("Некорректный ответ от магазина '$shopKey'");
            }
            
        } catch (\Exception $e) {
            $this->error("Ошибка при синхронизации с магазином '$shopKey': " . $e->getMessage());
        }
    }

    /**
     * Создает XML для обновления статуса заказа
     */
    private function createStatusUpdateXml($orderId, $status)
    {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Orders>\n" .
               "<Order>\n" .
               "<Action>modify</Action>\n" .
               "<Key>$orderId</Key> \n" .
               "<Status>$status</Status>\n" .
               "</Order>\n" .
               "</Orders>";
    }
}