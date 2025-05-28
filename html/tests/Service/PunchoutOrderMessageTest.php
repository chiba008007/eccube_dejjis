<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Customize\Service\AmazonApiServiceConnect;

class PunchoutOrderMessageTest extends TestCase
{
    private $xml;
    private $xmlString;

    protected function setUp(): void
    {
        $path = __DIR__ . '/../../mockdata/mock-cxml-api-response-PunchoutOrderMessage.xml';
        $stubResponseXml = file_get_contents($path);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getContent')->willReturn($stubResponseXml);

        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->method('request')->willReturn($mockResponse);

        $service = new AmazonApiServiceConnect($mockClient, 'http://dummy-url');
        $result = $service->getApiResponse($path, "http://dummy-url");
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

        // 2. Message & PunchOutOrderMessage
        $message = $xml->Message;
        $this->assertNotEmpty($message);
        $pom = $message->PunchOutOrderMessage;
        $this->assertNotEmpty($pom);

        // 3. BuyerCookie
        $this->assertNotEmpty($pom->BuyerCookie);

        // 4. PunchOutOrderMessageHeader
        $pomHeader = $pom->PunchOutOrderMessageHeader;

        $this->assertNotEmpty($pomHeader);
        $this->assertNotEmpty((string)$pomHeader['operationAllowed']);

        // 5. TotalとMoney
        $this->assertNotEmpty($pomHeader->Total);
        $this->assertNotEmpty($pomHeader->Total->Money);
        $this->assertNotEmpty((string)$pomHeader->Total->Money['currency']);

        // 6. ItemIn（複数OK、1つ以上必須）
        $this->assertGreaterThan(0, count($pom->ItemIn));
        foreach ($pom->ItemIn as $item) {
            // ItemID & SupplierPartID
            $this->assertNotEmpty($item->ItemID);
            $this->assertNotEmpty($item->ItemID->SupplierPartID);

            // ItemDetail & UnitPrice & Money
            $this->assertNotEmpty($item->ItemDetail);
            $this->assertNotEmpty($item->ItemDetail->UnitPrice);
            $this->assertNotEmpty($item->ItemDetail->UnitPrice->Money);
            $this->assertNotEmpty((string)$item->ItemDetail->UnitPrice->Money['currency']);
        }
    }

}
