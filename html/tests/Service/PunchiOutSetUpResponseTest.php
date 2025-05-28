<?php

namespace Tests\Service;

use Customize\Service\AmazonApiService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Customize\Service\AmazonApiServiceConnect;

class PunchiOutSetUpResponseTest extends TestCase
{
    public function testCreatePunchOutSetupResponse(): void
    {
        $path = __DIR__ . '/../../mockdata/mock-cxml-api-response-PunchOutSetupResponse.xml';
        $stubResponseXml = file_get_contents($path);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getContent')->willReturn($stubResponseXml);

        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->method('request')->willReturn($mockResponse);

        $service = new AmazonApiServiceConnect($mockClient, 'http://dummy-url');
        $result = $service->getApiResponse($path, "http://dummy-url");

        $this->assertSame('https://www.amazon.com/b2b/punchout/session/abcdef123456', (string) $result->Response->PunchOutSetupResponse->StartPage->URL);
        $this->assertSame('Success', (string) $result->Response->Status);
        $this->assertSame('200', (string) $result->Response->Status['code']);
        $this->assertSame('OK', (string) $result->Response->Status['text']);

    }
}
