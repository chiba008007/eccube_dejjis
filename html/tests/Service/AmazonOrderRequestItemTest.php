<?php

namespace Tests\Service;

use Customize\Service\AmazonOrderRequestItem;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Customize\Entity\AmazonOrderRequestItems;

class AmazonOrderRequestItemTest extends TestCase
{
    public function testCreateSessionCanBeCalledMultipleTimes()
    {
        // EntityManagerのモック
        // persistとflushが1回ずつ呼ばれていることを確認
        $entityManager = $this->createMock(EntityManagerInterface::class);
        // Loggerのモック
        $logger = $this->createMock(LoggerInterface::class);
        // 3回persistされることを期待
        $entityManager->expects($this->exactly(3))
            ->method("persist")
            ->with($this->isInstanceOf(AmazonOrderRequestItems::class));

        // サービス生成
        $service = new AmazonOrderRequestItem($entityManager, $logger);

        // 「親」エンティティ（AmazonOrderRequests等）のモック
        $parentRequest = $this->createMock(\Customize\Entity\AmazonOrderRequests::class);

        $results = [];
        for ($i = 1; $i <= 3; $i++) {
            $params = [
                'line_number' => $i,
                'supplier_part_id' => 'SPID001',
                'supplier_part_auxiliary_id' => 'AUX001',
                'quantity' => 10,
                'unit_price' => 1234,
                'manufacturer_part_id' => 'MPID001',
                'manufacturer_name' => 'テストメーカー',
                'category' => '家電',
                'sub_category' => 'テレビ',
                'item_condition' => '新品',
                'detail_page_url' => 'https://example.com/item/1',
                'ean' => '1234567890123',
                'preference' => 'high',
                'request' => $parentRequest
            ];

            $result = $service->createSession($params);
            $results[] = $result;
            $this->assertInstanceOf(AmazonOrderRequestItems::class, $result);
            $this->assertEquals($i, $result->getLineNumber());
        }


        // すべて異なるインスタンスであること
        $this->assertNotSame($results[0], $results[1]);
        $this->assertNotSame($results[1], $results[2]);
    }

}
