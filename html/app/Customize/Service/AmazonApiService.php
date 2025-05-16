<?php

namespace Customize\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

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

}
