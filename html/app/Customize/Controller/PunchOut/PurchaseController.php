<?php

namespace Customize\Controller\PunchOut;

use Eccube\Controller\AbstractController;
use Eccube\Entity\Customer;
use Eccube\Entity\Order;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Event\OrderEvent;
use Eccube\Event\EccubeEvents;
use Eccube\Service\CartService;
use Eccube\Service\OrderHelper;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Service\MailService;
use Eccube\Entity\Master\Pref;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PurchaseController extends AbstractController
{
    private $orderHelper;
    private $cartService;
    protected $entityManager;
    protected $eventDispatcher;
    protected $purchaseFlow;
    private $mailService;

    public function __construct(
        CartService $cartService,
        OrderHelper $orderHelper,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher,
        PurchaseFlow $purchaseFlow,
        MailService $mailService
    ) {
        $this->cartService = $cartService;
        $this->orderHelper = $orderHelper;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->purchaseFlow = $purchaseFlow;
        $this->mailService = $mailService;
    }

    /**
     * @Route("/punchout/purchase", name="punchout_purchase")
     */
    public function complete(Request $request): Response
    {
        $sessionId = $request->getSession()->get('punchout_session_id');

        if (!$sessionId) {
            return new Response('PunchOutセッションIDがありません', 400);
        }

        $Cart = $this->cartService->getCart();
        if (!$Cart || count($Cart->getCartItems()) === 0) {
            return new Response('カートが空です', 400);
        }

        $Customer = new Customer();
        $Customer->setEmail('guest@example.com');
        $Customer->setName01('ゲスト');
        $Customer->setName02('ユーザー');
        $Order = $this->orderHelper->initializeOrder($Cart, $Customer);

        $Order->setPref(
            $this->entityManager->getReference(Pref::class, 13) // 例：東京都
        );
        $Order->setAddr01('千代田区');
        $Order->setAddr02('永田町1-1-1');

        // ステータスと日付を明示的に設定
        $Order->setOrderStatus(
            $this->entityManager->getReference(OrderStatus::class, OrderStatus::PENDING)
        );

        // 注文保存
        try {
            $this->entityManager->persist($Order);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new Response('保存時にエラー: ' . $e->getMessage(), 500);
        }

        // メール送信
        $this->mailService->sendOrderMail($Order);

        // カートクリア
        $this->cartService->clear();

        $url = '/punchout/complete?session_id=' . urlencode($sessionId) . '&order_id=' . $Order->getId();
        return new RedirectResponse($url);
    }
    /**
   * @Route("/punchout/complete", name="punchout_complete")
   */
    public function completed(Request $request): Response
    {
        $session_id = $request->query->get('session_id');
        $order_id = $request->query->get('order_id');

        return new Response(sprintf(
            "PunchOut注文完了: セッションID = %s, 注文ID = %d",
            $session_id,
            $order_id
        ));
    }

}
