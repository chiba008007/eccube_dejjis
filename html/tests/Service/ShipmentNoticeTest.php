<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Customize\Service\AmazonApiServiceConnect;

class ShipmentNoticeTest extends TestCase
{
    private $xml;
    private $xmlString;

    protected function setUp(): void
    {
        $path = __DIR__ . '/../../mockdata/mock-cxml-api-shipmentNotice.xml';
        $stubResponseXml = file_get_contents($path);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getContent')->willReturn($stubResponseXml);

        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->method('request')->willReturn($mockResponse);

        $service = new AmazonApiServiceConnect($mockClient, 'http://mock-api-server:3456/shipmentNotice');
        $result = $service->getApiResponse($path, "http://mock-api-server:3456/shipmentNotice");
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

        $request = $xml->Request;
        $this->assertNotEmpty($request);
        $shipNoticeHeader = $request->ShipNoticeRequest->ShipNoticeHeader;
        $this->assertNotEmpty($shipNoticeHeader);
        $this->assertNotEmpty((string)$shipNoticeHeader['shipmentID']);
        $noticeDate = $shipNoticeHeader['noticeDate'];
        $date = \DateTime::createFromFormat('Y-m-d\TH:i:sO', $noticeDate);
        $this->assertInstanceOf(\DateTime::class, $date, 'noticeDate is not a valid datetime format');
        $DocumentReference = $request->ShipNoticeRequest->ShipNoticePortion->OrderReference->DocumentReference;
        $payloadID = (string)$DocumentReference['payloadID'];
        $this->assertNotEmpty($payloadID, 'payloadID should not be empty');
        $this->assertMatchesRegularExpression(
            '/^\d{14}\.\d+\.\d+@[\w.-]+\.[a-z]{2,}$/i',
            $payloadID,
            'payloadID does not match the expected format'
        );
    }
}
