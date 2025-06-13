<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Customize\Service\AmazonOrderConfirmation;
use Customize\Entity\AmazonOrderConfirmations;

class AmazonOrderConfirmTest extends TestCase
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
        $service = new AmazonOrderConfirmation($entityManager, $logger);

        // テストパラメータ
        $params = [
                'confirm_id' => '250-5123176-9239824',
                'order_id' => 'R18140323289',
                'notice_date' => '2018-12-04T02:07:44+0000',
                'total_amount' => '10466.00',
                'total_tax' => '775.00',
                'total_shipping' => '0.00',
                'raw_cxml' => '<xml></xml>'
        ];

        // 実行
        $result = $service->createSession($params);

        // 戻り値がエンティティであることの確認
        $this->assertInstanceOf(AmazonOrderConfirmations::class, $result);
        // セットされた値の検証
        $this->assertEquals($params[ 'confirm_id' ], $result->getConfirmId());
        $this->assertEquals($params[ 'order_id' ], $result->getOrderId());
        $this->assertEquals(
            (new \DateTime($params['notice_date']))->format('c'), // ISO形式比較
            $result->getNoticeDate()->format('c')
        );
        $this->assertEquals($params[ 'total_amount' ], $result->getTotalAmount());
        $this->assertEquals($params[ 'total_tax' ], $result->getTotalTax());
        $this->assertEquals($params[ 'total_shipping' ], $result->getTotalShipping());
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
        $service = new AmazonOrderConfirmation($entityManager, $logger);

        // テストパラメータ
        $params = [
                'confirm_id' => '250-5123176-9239824',
                'order_id' => 'R18140323289',
                'notice_date' => '2018-12-04T02:07:44+0000',
                'total_amount' => '10466.00',
                'total_tax' => '775.00',
                'total_shipping' => '0.00',
                'raw_cxml' => '<xml></xml>'
        ];

        // 実行＆null返却の検証
        $result = $service->createSession($params);
        $this->assertNull($result);

    }
}
