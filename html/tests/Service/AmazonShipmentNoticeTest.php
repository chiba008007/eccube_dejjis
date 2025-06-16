<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Customize\Service\AmazonShipmentNotice;
use Customize\Entity\AmazonShipNotices;

class AmazonShipmentNoticeTest extends TestCase
{
    public function testCreateSession正常系()
    {
        // EntityManagerのモック
        // persistとflushが1回ずつ呼ばれていることを確認
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->once())->method("persist");
        $entityManager->expects($this->once())->method("flush");

        // Loggerのモック
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->never())->method('debug');

        // サービス生成
        $service = new AmazonShipmentNotice($entityManager, $logger);

        // テストパラメータ
        $params = [
            'shipment_id' => 'SHIP123',
            'order_id' => 'ORD456',
            'notice_date' => '2024-06-01',
            'shipment_date' => '2024-06-02',
            'delivery_date' => '2024-06-03',
            'shipment_type' => 'STANDARD',
            'carrier_name' => 'Yamato',
            'tracking_number' => 'TRACK789',
            'package_range_begin' => '1',
            'package_range_end' => '5',
            'payload_id' => 'PLID0001',
            'raw_cxml' => '<xml>test</xml>',
        ];

        // 実行
        $result = $service->createSession($params);

        // 戻り値がエンティティであることの確認
        $this->assertInstanceOf(AmazonShipNotices::class, $result);
        // セットされた値の検証(例)
        $this->assertEquals('SHIP123', $result->getShipmentId());
        $this->assertEquals('ORD456', $result->getOrderId());
        $this->assertEquals('2024-06-01', $result->getNoticeDate()->format('Y-m-d'));
        $this->assertEquals('2024-06-02', $result->getShipmentDate()->format('Y-m-d'));
        $this->assertEquals('2024-06-03', $result->getDeliveryDate()->format('Y-m-d'));
        $this->assertEquals('STANDARD', $result->getShipmentType());
        $this->assertEquals('Yamato', $result->getCarrierName());
        $this->assertEquals('TRACK789', $result->getTrackingNumber());
        $this->assertEquals('1', $result->getPackageRangeBegin());
        $this->assertEquals('5', $result->getPackageRangeEnd());
        $this->assertEquals('<xml>test</xml>', $result->getRawCxml());
    }


    public function testCreateSession異常系_例外時はnullを返す()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $entityManager->method('persist')->willThrowException(new \Exception("DB error"));
        $logger->expects($this->once())->method('debug')->with($this->stringContains('登録処理失敗'));

        $service = new AmazonShipmentNotice($entityManager, $logger);

        $params = [
            'shipment_id' => 'SHIP999',
            'order_id' => 'ORD999',
            'notice_date' => 'invalid-date', // DateTimeで例外出したければここでもOK
            'raw_cxml' => '<xml>test</xml>',
        ];

        $result = $service->createSession($params);

        $this->assertNull($result);


    }

}
