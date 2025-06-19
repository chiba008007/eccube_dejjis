<?php

use PHPUnit\Framework\TestCase;
use Customize\Controller\PunchOut\PurchaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Eccube\Service\CartService;
use Eccube\Service\OrderHelper;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Eccube\Service\MailService;
use Eccube\Entity\Cart;
use Eccube\Entity\CartItem;
use Eccube\Entity\Order;
use Eccube\Entity\Master\Pref;
use Eccube\Entity\Master\OrderStatus;

class PurchaseControllerTest extends TestCase
{
    public function testComplete正常系()
    {
        echo "\ntestComplete_正常系 実行中\n";

        // sessionセットアップ
        $session = new Session(new MockArraySessionStorage());
        $session->set("punchout_session_id", "dummy-session-id");
        $request = new Request();
        $request->setSession($session);

        // --- CartServiceのモック
        $cartItem = $this->createMock(CartItem::class);
        $cart = $this->createMock(Cart::class);
        $cart->method('getCartItems')->willReturn([$cartItem]);

        $cartService = $this->createMock(CartService::class);
        $cartService->method('getCart')->willReturn($cart);
        $cartService->expects($this->once())->method('clear');

        // --- Orderのモック
        $order = $this->createMock(Order::class);
        $order->method('getId')->willReturn(123);

        $orderHelper = $this->createMock(OrderHelper::class);
        $orderHelper->method('initializeOrder')->willReturn($order);

        $orderStatus = $this->createMock(OrderStatus::class);
        $pref = $this->createMock(Pref::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getReference')->willReturnMap([
            [Pref::class, 13, $pref],
            [OrderStatus::class, OrderStatus::PENDING, $orderStatus],
        ]);
        $entityManager->expects($this->once())->method('persist')->with($order);
        $entityManager->expects($this->once())->method('flush');

        $mailService = $this->createMock(MailService::class);
        $mailService->expects($this->once())->method('sendOrderMail')->with($order);

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $purchaseFlow = $this->createMock(PurchaseFlow::class);

        $controller = new PurchaseController(
            $cartService,
            $orderHelper,
            $entityManager,
            $eventDispatcher,
            $purchaseFlow,
            $mailService
        );

        $response = $controller->complete($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('/punchout/complete', $response->getTargetUrl());
        $this->assertStringContainsString('session_id=dummy-session-id', $response->getTargetUrl());
        $this->assertStringContainsString('order_id=123', $response->getTargetUrl());
    }

}
