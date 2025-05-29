<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Customize\Service\AmazonApiServiceConnect;

class OrderConfirmationTest extends TestCase
{
    private $xml;
    private $xmlString;

    protected function setUp(): void
    {
        $path = __DIR__ . '/../../mockdata/mock-cxml-api-orderConfirmation.xml';
        $stubResponseXml = file_get_contents($path);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getContent')->willReturn($stubResponseXml);

        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->method('request')->willReturn($mockResponse);

        $service = new AmazonApiServiceConnect($mockClient, 'http://mock-api-server:3456/orderRequest');
        $result = $service->getApiResponse($path, "http://mock-api-server:3456/orderRequest");
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
        $OrderReference = $xml->Request->ConfirmationRequest->OrderReference;
        $DocumentReference = $xml->Request->ConfirmationRequest->OrderReference->DocumentReference;
        $this->assertNotEmpty($OrderReference);
        $this->assertNotEmpty((string)$OrderReference['orderID']);
        $this->assertNotEmpty((string)$DocumentReference['payloadID']);
        // 商品情報1つ以上
        $ConfirmationRequest = $xml->Request->ConfirmationRequest;
        $this->assertGreaterThan(0, count($ConfirmationRequest->ConfirmationItem));
        foreach ($ConfirmationRequest->ConfirmationItem as $item) {
            $this->assertNotEmpty($item->ConfirmationStatus);
            $this->assertNotEmpty($item->ConfirmationStatus->Tax->Money);
            $this->assertNotEmpty($item->ConfirmationStatus->Tax->TaxDetail);
            $this->assertNotEmpty($item->ConfirmationStatus->Tax->TaxDetail->TaxAmount->Money);
            $this->assertNotEmpty((string)$item->ConfirmationStatus->Tax->TaxDetail->TaxAmount->Money['currency']);
        }
    }
}
