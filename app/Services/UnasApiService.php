<?php

namespace App\Services;

class UnasApiService
{
    private $apiKey;
    private $token;
    private $curl;

    

    public function __construct($apiKey)
    {
        $this->apiKey = trim($apiKey);
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
        // Диагностика: выводим ключ
        file_put_contents(storage_path('unas_api_debug.txt'), "APIKEY: [{$this->apiKey}]\n", FILE_APPEND);

        $loginRequest = sprintf(
            '<?xml version="1.0" encoding="UTF-8"?><Params><ApiKey>%s</ApiKey></Params>',
            trim($this->apiKey)
        );
        file_put_contents(storage_path('unas_api_debug.txt'), "LOGIN XML: $loginRequest\n", FILE_APPEND);

        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/login");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $loginRequest);
        $response = curl_exec($this->curl);

        // Логируем raw response
        file_put_contents(storage_path('unas_api_debug.txt'), "RESPONSE: $response\n", FILE_APPEND);

        if ($response === false) {
            $err = curl_error($this->curl);
            file_put_contents(storage_path('unas_api_debug.txt'), "CURL ERROR: $err\n", FILE_APPEND);
            throw new \Exception('Curl error: ' . $err);
        }

        $loginXml = simplexml_load_string($response);
        // Диагностика: что распарсилось?
        file_put_contents(storage_path('unas_api_debug.txt'), "LOGIN XML OBJECT: " . print_r($loginXml, true) . "\n", FILE_APPEND);

        $this->token = isset($loginXml->Token) ? (string)$loginXml->Token : null;
        if (!$this->token) {
            throw new \Exception('Не удалось получить токен UNAS: ' . $response);
        }
        return $this->token;
    }

    public function getOrders($paramsXml)
    {
        if (!$this->token) $this->login();
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->token,
            "Content-Type: application/xml"
        ]);
        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/getOrder");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $paramsXml);
        $response = curl_exec($this->curl);
        file_put_contents(storage_path('unas_api_debug.txt'), "getOrders RESPONSE: $response\n", FILE_APPEND);

        if ($response === false) {
            $err = curl_error($this->curl);
            file_put_contents(storage_path('unas_api_debug.txt'), "getOrders CURL ERROR: $err\n", FILE_APPEND);
            throw new \Exception('Curl error: ' . $err);
        }

        return simplexml_load_string($response);
    }

    public function setOrders($ordersXml)
    {
        if (!$this->token) $this->login();
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->token,
            "Content-Type: application/xml"
        ]);
        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/setOrder");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $ordersXml);
        $response = curl_exec($this->curl);
        file_put_contents(storage_path('unas_api_debug.txt'), "setOrders REQUEST: $ordersXml\n", FILE_APPEND);
        file_put_contents(storage_path('unas_api_debug.txt'), "setOrders RESPONSE: $response\n", FILE_APPEND);

        if ($response === false) {
            $err = curl_error($this->curl);
            file_put_contents(storage_path('unas_api_debug.txt'), "setOrders CURL ERROR: $err\n", FILE_APPEND);
            throw new \Exception('Curl error: ' . $err);
        }

        return $response; // Строка XML-ответа
    }

    public function getOrderStatus($paramsXml)
    {
        if (!$this->token) $this->login();
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->token,
            "Content-Type: application/xml"
        ]);
        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/getOrderStatus");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $paramsXml);
        $response = curl_exec($this->curl);
        file_put_contents(storage_path('unas_api_debug.txt'), "getOrderStatus RESPONSE: $response\n", FILE_APPEND);

        if ($response === false) {
            $err = curl_error($this->curl);
            file_put_contents(storage_path('unas_api_debug.txt'), "getOrderStatus CURL ERROR: $err\n", FILE_APPEND);
            throw new \Exception('Curl error: ' . $err);
        }

        
        // // Выводим сырой ответ в консоль
        // echo "\n------ RAW getOrderStatus RESPONSE ------\n";
        // echo $response . "\n";
        // echo "------ END RAW RESPONSE ------\n";
        
        return simplexml_load_string($response);
    }

    public function setOrderStatus($statusXml)
    {
        if (!$this->token) $this->login();
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->token,
            "Content-Type: application/xml"
        ]);
        curl_setopt($this->curl, CURLOPT_URL, "https://api.unas.eu/shop/setOrderStatus");
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $statusXml);
        $response = curl_exec($this->curl);
        file_put_contents(storage_path('unas_api_debug.txt'), "setOrderStatus REQUEST: $statusXml\n", FILE_APPEND);
        file_put_contents(storage_path('unas_api_debug.txt'), "setOrderStatus RESPONSE: $response\n", FILE_APPEND);

        if ($response === false) {
            $err = curl_error($this->curl);
            file_put_contents(storage_path('unas_api_debug.txt'), "setOrderStatus CURL ERROR: $err\n", FILE_APPEND);
            throw new \Exception('Curl error: ' . $err);
        }

        return $response;
    }
}
