<?php

namespace Tests\Service;

use Customize\Service\AmazonApiService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AmazonApiServiceTest extends TestCase
{
    public function testCreateSampleReturnsExpectedResponse(): void
    {
        // 1. モックXMLの内容を用意（実ファイルも存在させること）
        $expectedXml = file_get_contents(__DIR__ . '/../../mockdata/mock-cxml-api-request.xml');
        // 2. レスポンスモックの用意
        $mockResponse = $this->createMock(ResponseInterface::class);
        // 3. HttpClientInterfaceのモック
        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('http://mock-api-server:3456/amazonApiSample'),
                $this->callback(function ($options) use ($expectedXml) {
                    // XML内容が本当にセットされているか
                    return isset($options['body']) && $options['body'] === $expectedXml;
                })
            )
            ->willReturn($mockResponse);

        // 4. Serviceにモックを渡してインスタンス化
        $service = new AmazonApiService($mockClient);

        // 5. テスト実行
        $result = $service->createSample();

        // 6. 結果がモックレスポンスと一致することを検証
        $this->assertSame($mockResponse, $result);
        /*
        self::bootKernel();
        $container = static::getContainer();
        // 期待するレスポンス
        $service = $container->get(AmazonApiService::class);
        $response = $service->createSample();

        $content = $response->getContent();

        // レスポンスのステータスを確認
        $this->assertEquals(200, $response->getStatusCode());

        // 必須のタグや値が含まれているか確認
        $this->assertStringContainsString('<PunchOutOrderMessage>', $content);
        $this->assertStringContainsString('<BuyerCookie>', $content);
        $this->assertStringContainsString('<Money currency="JPY">0.00</Money>', $content);
        */
    }
}
