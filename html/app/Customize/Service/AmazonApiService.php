<?php

namespace Customize\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AmazonApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function createOrder(array $data): array
    {
        $response = $this->httpClient->request("POST", 'https://2e039687-d528-415b-a66d-77313995df77.mock.pstmn.io/orders', [
          'json' => $data
        ]);

        return $response->toArray();
    }
    public function createSample(): ResponseInterface
    {

        // $requestBody = file_get_contents("/var/www/html/mockdata/mock-cxml-api-request.xml");
        $requestBody = file_get_contents(__DIR__ . '/../../../mockdata/mock-cxml-api-request.xml');

        $url = "http://mock-api-server:3456/amazonApiSample";

        $res = $this->httpClient->request("POST", $url, [
                'headers' => ['Content-Type' => 'application/xml'],
                'body' => $requestBody,
            ]);

        return $res;
    }

}
