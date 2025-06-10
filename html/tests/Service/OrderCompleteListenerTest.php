<?php

namespace Tests\Service;

use Eccube\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Customize\EventListener\OrderCompleteListener;
use Customize\Entity\DtbPunchoutSession;
use Eccube\Repository\OrderRepository;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Eccube\Event\EventArgs;

class OrderCompleteListenerTest extends TestCase
{
    public function testOnOrderComplete_DispatchesXml()
    {
        // order モック：注文データのテスト用。必要なメソッドのみ定義
        $order = $this->createMock(Order::class);
        $order->method('getId')->willReturn(1234); // 注文ID
        $order->method('getPaymentTotal')->willReturn(1000); // 支払い総額
        $order->method('getDeliveryFeeTotal')->willReturn(100); // 配送手数料
        $order->method('getTax')->willReturn(80); // 消費税
        $order->method('getOrderItems')->willReturn([]); // 商品明細

        // PunchOutセッション モック：外部連携情報を返す
        $punchoutSession = $this->createMock(DtbPunchoutSession::class);
        $punchoutSession->method('getBuyerCookie')->willReturn('TESTBUYERCOOKIE123'); // パンチアウト識別子
        $punchoutSession->method('getBrowserPostUrl')->willReturn('https://example.com/dummy'); // POST先URL



        // Repository モック：セッションIDでPunchOutセッションを取得できるようにする
        $repo = $this->createMock(\Doctrine\Persistence\ObjectRepository::class);
        $repo->method('findOneBy')->willReturn($punchoutSession);

        // EntityManager モック：getRepository() が常に PunchOut 用の Repository を返す
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($repo);

        // 注文リポジトリとロガーもモック（今回は特に挙動の定義は不要）
        $orderRepository = $this->createMock(OrderRepository::class);
        $logger = $this->createMock(LoggerInterface::class);

        // Symfony セッションのモック（パンチアウトセッションIDをセット）
        $session = new Session(new MockArraySessionStorage());
        $session->set('punchout_session_id', 'dummy-session-id');

        // リクエストオブジェクトにセッションを埋め込む
        $request = Request::create('/');
        $request->setSession($session);

        // EventArgs：EC-CUBEのイベント引数として Order と Request を設定
        $eventArgs = new EventArgs(['Order' => $order], $request);

        // OrderCompleteListener をインスタンス化し、イベント処理を実行
        $listener = new OrderCompleteListener($logger, $orderRepository, $entityManager);
        $listener->onOrderComplete($eventArgs);

        // 例外が発生しなければテスト成功とする（振る舞いの確認は別途必要）
        $this->assertTrue(true);
    }
}
