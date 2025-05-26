<?php

namespace Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Customize\Service\AmazonApiService;

class AmazonApiServiceTest extends KernelTestCase
{
    public function testCreateSampleReturnsExpectedResponse(): void
    {
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
    }
}
