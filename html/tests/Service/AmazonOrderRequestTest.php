<?php

namespace Tests\Service;

use Customize\Service\AmazonOrderRequest;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Customize\Entity\AmazonOrderRequests;

class AmazonOrderRequestTest extends TestCase
{
    public function testCreateSessionReturnsTrueOnSuccess()
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
        $service = new AmazonOrderRequest($entityManager, $logger);

        // テストパラメータ
        $params = [
            'payload_id' => '20181204110720.25750.1821@test.co.jp',
            'order_id' => 'R18140323289',
            'buyer_id' => '9032597353',
            'total_amount' => '10466.00',
            'currency' => 'JPY',
            'status' => 'new',
            'raw_cxml' => '<xml></xml>',
        ];

        // 実行
        $result = $service->createSession($params);

        // 戻り値がエンティティであることの確認
        $this->assertInstanceOf(AmazonOrderRequests::class, $result);
        // セットされた値の検証(例)
        $this->assertEquals($params[ 'payload_id' ], $result->getPayloadId());
        $this->assertEquals($params[ 'order_id' ], $result->getOrderId());
        $this->assertEquals($params[ 'buyer_id' ], $result->getBuyerId());
        $this->assertEquals($params[ 'total_amount' ], $result->getTotalAmount());
        $this->assertEquals($params[ 'currency' ], $result->getCurrency());
        $this->assertEquals($params[ 'status' ], $result->getStatus());
        $this->assertEquals($params[ 'raw_cxml' ], $result->getRawCxml());
        $this->assertNotNull($result->getCreatedAt());
        $this->assertNotNull($result->getUpdatedAt());
    }

    public function testCreateSessionReturnsNullOnException()
    {
        // EntityManagerのモック:persist例外発生
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method("persist")->willThrowException(new \Exception('dummy'));

        // Loggerのモック
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('debug');

        // サービス生成
        $service = new AmazonOrderRequest($entityManager, $logger);

        // テストパラメータ
        $params = [
            'payload_id' => '20181204110720.25750.1821@test.co.jp',
            'order_id' => 'R18140323289',
            'buyer_id' => '9032597353',
            'total_amount' => '10466.00',
            'currency' => 'JPY',
            'status' => 'new',
            'raw_cxml' => '<xml></xml>',
        ];

        // 実行＆null返却の検証
        $result = $service->createSession($params);
        $this->assertNull($result);

    }
}
