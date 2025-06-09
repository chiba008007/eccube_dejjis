<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Customize\Service\PunchoutSessionService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PunchoutSessionServiceTest extends TestCase
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

        $requestStack = $this->createMock(RequestStack::class);

        // serviceのインスタンス生成
        $service = new PunchoutSessionService($entityManager, $logger, $requestStack);

        // パラメータ例
        $params = [
            'buyer_cookie' => 'cookie',
            'session_id' => bin2hex(random_bytes(16)),
            'request_xml' => '<xml></xml>',
            'browser_post_url' => 'http://www.xxx.jp',
            'user_email' => 'test@example.com',
            'user_first_name' => '太郎',
            'user_last_name' => '千葉',
            'start_date' => '2024-06-06 00:00:00',
            'country' => 'JP',
            'business_unit' => '営業部',
            'ship_to_json' => '{}',
            'expire_at' => null,
            'is_used' => false,
        ];

        // 実行
        $result = $service->createSession($params);

        // 結果をアサート
        $this->assertTrue($result);

    }

    public function testCreateSessionReturnsFalseOnException()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method("persist")->will($this->throwException(new \Exception('DB Error')));

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('debug')->with($this->stringContains('登録処理失敗'));

        $requestStack = $this->createMock(RequestStack::class);

        $service = new PunchoutSessionService($entityManager, $logger, $requestStack);

        $params = [
            'buyer_cookie' => 'cookie',
            'request_xml' => '<xml></xml>',
            'user_email' => 'test@example.com',
            'user_first_name' => '太郎',
            'user_last_name' => '千葉',
            'start_date' => '2024-06-06 00:00:00',
            // ...他も必要に応じて省略OK
        ];

        $result = $service->createSession($params);

        $this->assertFalse($result);
    }
}
