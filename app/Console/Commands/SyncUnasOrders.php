<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnasApiService;
use App\Models\Order;
use Carbon\Carbon;

class SyncUnasOrders extends Command
{
    protected $signature = 'unas:sync-orders';
    protected $description = 'Синхронизация заказов из всех магазинов в главный магазин';

    public function handle()
    {
        // Ключи магазинов
        $shopKeys = [
            'shop1' => env('UNAS_API_KEY_SHOP1'),
            'shop2' => env('UNAS_API_KEY_SHOP2'),
            // 'shop3' => env('UNAS_API_KEY_SHOP3'),
        ];
        $mainKey = env('UNAS_API_KEY_MAIN');
        $mainUnas = new UnasApiService($mainKey);

        foreach ($shopKeys as $shop => $apiKey) {
            $unas = new UnasApiService($apiKey);

            // Параметры для getOrder
            $paramsXml = '<?xml version="1.0" encoding="UTF-8"?><Params><ContentType>full</ContentType><LimitNum>50</LimitNum></Params>';
            $ordersXml = $unas->getOrders($paramsXml);

            if (!empty($ordersXml->Order)) {
                foreach ($ordersXml->Order as $orderXml) {
                    $externalId = (string)$orderXml->Id;
                    $key = (string)$orderXml->Key;
                    $createdAt = Carbon::createFromFormat('Y.m.d H:i:s', (string)$orderXml->Date);
                    $updatedAt = Carbon::createFromFormat('Y.m.d H:i:s', (string)$orderXml->DateMod);
                    $bodyXml = $orderXml->asXML();

                    // Удалим старый Action если есть, и добавим правильный (для надёжности)
                    $bodyXml = preg_replace('/<Order>/', '<Order><Action>add</Action>', $bodyXml, 1);

                    $localOrder = Order::where('external_id', $externalId)
                        ->where('external_shop', $shop)
                        ->first();

                    if (!$localOrder) {
                        Order::create([
                            'external_id' => $externalId,
                            'external_shop' => $shop,
                            'key' => $key,
                            'created_at_external' => $createdAt,
                            'updated_at_external' => $updatedAt,
                            'body_xml' => $bodyXml,
                            'status' => (string)$orderXml->Status,
                        ]);
                        $this->info("Сохранён новый заказ $externalId из $shop");
                    } else {
                        if ($localOrder->body_xml !== $bodyXml) {
                            $localOrder->update([
                                'updated_at_external' => $updatedAt,
                                'body_xml' => $bodyXml,
                                'status' => (string)$orderXml->Status,
                            ]);
                            $this->info("Обновлён заказ $externalId из $shop");
                        }
                    }
                }
            }
        }

        // --- СБОРКА XML ДЛЯ UNAS ---
        $orders = Order::where('external_shop', '!=', 'main')
            ->whereNull('sync') // только неотправленные
            ->get();
        
        $ordersXmlArray = [];
        // Создаём массив для сопоставления порядка заказов с их ID
        $orderMapping = [];

        foreach ($orders as $index => $order) {
            $orderXml = $order->body_xml;

            $orderXml = preg_replace('/<Key>.*?<\/Key>\s*/s', '', $orderXml);

            // Гарантируем Action и правильную структуру
            if (strpos($orderXml, '<Action>') === false) {
                $orderXml = preg_replace('/<Order>/', '<Order><Action>add</Action>', $orderXml, 1);
            }
            $ordersXmlArray[] = $orderXml;
            
            // Сохраняем сопоставление индекса с ID заказа
            $orderMapping[$index] = $order->id;
            $this->line("Mapping: индекс $index -> ID заказа {$order->id} (external_id: {$order->external_id}, shop: {$order->external_shop})");
        }

        if (empty($ordersXmlArray)) {
            $this->info("Нет заказов для синхронизации");
            return;
        }

        $bodyXml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<Orders>\n" . implode("\n", $ordersXmlArray) . "\n</Orders>";

        // --- ОТПРАВКА В ГЛАВНЫЙ МАГАЗИН ---
        $response = $mainUnas->setOrders($bodyXml);
        $this->line("Ответ главного магазина:\n$response");

        // Определяем тип ответа
        if (is_string($response)) {
            $responseXml = simplexml_load_string($response);
        } else {
            $responseXml = $response; // уже SimpleXML объект
        }
        
        $this->line("Тип ответа: " . gettype($response));
        $this->line("Количество заказов в ответе: " . (isset($responseXml->Order) ? count($responseXml->Order) : 0));
        $this->line("Количество заказов в mapping: " . count($orderMapping));
        
        if ($responseXml && isset($responseXml->Order)) {
            $responseIndex = 0; // Используем отдельный счетчик
            foreach ($responseXml->Order as $orderResult) {
                $this->line("Обрабатываем заказ с индексом: $responseIndex");
                
                if ((string)$orderResult->Status === 'ok') {
                    $newKey = (string)$orderResult->Key;
                    $this->line("Ключ из ответа: $newKey");

                    // Используем счетчик для получения правильного ID заказа
                    if (isset($orderMapping[$responseIndex])) {
                        $orderId = $orderMapping[$responseIndex];
                        $this->line("ID заказа из mapping: $orderId");
                        
                        $order = Order::find($orderId);
                        if ($order) {
                            $this->line("Найден заказ: {$order->external_id} из {$order->external_shop}");
                            $order->main_shop_key = $newKey;
                            $order->sync = true;
                            $result = $order->save();
                            $this->line("Результат сохранения: " . ($result ? 'успешно' : 'ошибка'));
                            $this->info("Заказ {$order->external_id} из {$order->external_shop} синхронизирован с ключом $newKey");
                        } else {
                            $this->error("Заказ с ID $orderId не найден в базе");
                        }
                    } else {
                        $this->error("Индекс $responseIndex не найден в mapping");
                    }
                } else {
                    $this->error("Ошибка синхронизации заказа с индексом $responseIndex: " . (string)$orderResult->Status);
                }
                
                $responseIndex++; // Увеличиваем счетчик
            }
        } else {
            $this->error("Ответ не содержит заказов или некорректный XML");
        }



        $this->info("Синхронизация завершена успешно");
    }
}