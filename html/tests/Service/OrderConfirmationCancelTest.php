<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Customize\Service\AmazonApiServiceConnect;

class OrderConfirmationCancelTest extends TestCase
{
    private $xml;
    private $xmlString;

    protected function setUp(): void
    {
        $request = __DIR__ . '/../../mockdata/mock-cxml-api-orderRequest.xml';
        $path = __DIR__ . '/../../mockdata/mock-cxml-api-orderConfirmation_cancel.xml';
        $stubResponseXml = file_get_contents($path);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getContent')->willReturn($stubResponseXml);

        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->method('request')->willReturn($mockResponse);

        $service = new AmazonApiServiceConnect($mockClient);
        $result = $service->getApiResponse($request, "http://mock-api-server:3456/orderRequestCancel");
        $this->assertNotEmpty($result, 'XMLファイルが読み込めていません');

        $this->xmlString = $result->asXML();
        $xmlStringWithoutDoctype = preg_replace('/<!DOCTYPE.*?>/si', '', $this->xmlString);
        $this->xml = simplexml_load_string($xmlStringWithoutDoctype);

        $this->assertNotFalse($this->xml, 'setUp内: XMLパースに失敗しました');
        $this->assertNotNull($this->xml, 'setUp内: XMLパース結果がnullです');
    }

    public function testPunchoutOrderMessage(): void
    {


        $this->assertNotFalse($this->xml);
        $this->assertNotNull($this->xml);
        $this->assertNotEmpty($this->xml->Header);

        $dom = new \DOMDocument();
        $dom->loadXML($this->xmlString);
        $isValid = $dom->validate(); // DTD参照があれば true/false
        $this->assertTrue($isValid);
    }

    public function testCxmlHasAllRequiredTags()
    {
        $xml = $this->xml;
        // 1. Header
        $header = $xml->Header;
        $this->assertNotEmpty($header);
        foreach (['From', 'To', 'Sender'] as $tag) {
            $section = $header->$tag;
            $this->assertNotEmpty($section);
            $this->assertGreaterThan(0, count($section->Credential));
            foreach ($section->Credential as $cred) {
                $this->assertNotEmpty($cred->Identity);
            }
        }
        $ConfirmationHeader = $xml->Request->ConfirmationRequest->ConfirmationHeader;
        $this->assertNotEmpty($ConfirmationHeader);
        $this->assertNotEmpty((string)$ConfirmationHeader['operation']);
        $this->assertSame('new', (string)$ConfirmationHeader['operation']);
        $Comments = $ConfirmationHeader->Comments;
        $this->assertSame('OrderErrorCode', (string)$Comments['type']);
        $ConfirmationItem = $xml->Request->ConfirmationRequest->ConfirmationItem;
        $ConfirmationStatus = $ConfirmationItem->ConfirmationStatus;
        $this->assertSame('reject', (string)$ConfirmationStatus['type']);
        $Comments = $ConfirmationStatus->Comments;
        $this->assertSame('LineItemErrorCode', (string)$Comments['type']);

    }
}
