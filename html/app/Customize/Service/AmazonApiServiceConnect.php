<?php

namespace Customize\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AmazonApiServiceConnect
{
    private HttpClientInterface $httpClient;
    private string $endpoint;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

    }

    public function getApiResponse(string $xmlBody, ?string $overrideEndpoint = null): \SimpleXMLElement
    {

        $endpoint = $overrideEndpoint ?? $this->endpoint;
        $xml = file_get_contents($xmlBody);

        $response = $this->httpClient->request("POST", $endpoint, [
                'headers' => ['Content-Type' => 'application/xml'],
                'body' => $xml,
            ]);

        return $this->extractCxmlContent($response);

    }
    public function extractCxmlContent(ResponseInterface $response): \SimpleXMLElement
    {
        $raw = $response->getContent();
        return new \SimpleXMLElement($raw);
    }

}
