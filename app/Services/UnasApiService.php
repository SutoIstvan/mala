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

    public function getAllProducts($categoryId = '901601', $limit = 1000)
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

        $response = curl_exec($this->curl);
        if ($response === false) {
            throw new \Exception('Curl error: ' . curl_error($this->curl));
        }

        $productsXml = simplexml_load_string($response);
        if (!$productsXml) {
            throw new \Exception('XML parsing error: ' . $response);
        }

        return $productsXml->Product;
    }

    public function __destruct()
    {
        if ($this->curl) {
            curl_close($this->curl);
        }
    }
}