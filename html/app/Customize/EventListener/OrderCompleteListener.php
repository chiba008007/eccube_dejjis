<?php

/**
 * 注文完了時に PunchOutOrderMessage を送信するリスナー
 */

namespace Customize\EventListener;

use BcMath\Number;
use Eccube\Entity\Order;
use Eccube\Event\EventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\DtbPunchoutSession;

class OrderCompleteListener implements EventSubscriberInterface
{
    private $logger;
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    private $entityManager;

    public function __construct(LoggerInterface $logger, OrderRepository $orderRepository, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
          'front.shopping.order.complete' => ['onOrderComplete', 0],
        ];
    }

    public function onOrderComplete(EventArgs $event)
    {
        /** @var Order $order */
        $order = $event->getArgument('Order');
        $request = $event->getRequest();
        $session = $request->getSession();
        $punchoutSessionId = $session->get('punchout_session_id');
        $this->logger->info("セッションID", [ 'sessionID' => $punchoutSessionId ]);
        if (empty($punchoutSessionId)) {
            $this->logger->warning('PunchOutセッションIDが取得できませんでした。処理を中断します。');
            return;
        }

        $repo = $this->entityManager->getRepository(DtbPunchoutSession::class);
        $punchoutSession = $repo->findOneBy([
            "sessionId" => $punchoutSessionId
        ]);

        $buyerCookie = $punchoutSession?->getBuyerCookie();
        $browserPostUrl = $punchoutSession?->getBrowserPostUrl();
        $this->logger->info("注文完了イベントが発火しました", [ 'order_id' => $order->getId() ]);


        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;
        $cxml = $doc->createElement('cXML');
        $cxml->setAttribute('payloadID', uniqid('', true));
        $cxml->setAttribute('timestamp', (new \DateTime())->format(DATE_ATOM));
        $doc->appendChild($cxml);

        // messageノード
        $message = $doc->createElement("Message");
        $cxml->appendChild($message);

        //punchoutordermessage
        $punchOut = $doc->createElement('PunchOutOrderMessage');
        $punchOut->appendChild($doc->createElement('BuyerCookie', $buyerCookie));

        $message->appendChild($punchOut);

        $header = $doc->createElement('PunchOutOrderMessageHeader');
        $header->setAttribute('operationAllowed', 'create');

        // --- Total（支払合計） ---
        $total = $doc->createElement('Total');
        $money = $doc->createElement('Money', number_format($order->getPaymentTotal(), 2, '.', ''));
        $money->setAttribute('currency', 'JPY');
        $total->appendChild($money);
        $header->appendChild($total);

        // --- Shipping（送料） ---
        $shipping = $doc->createElement('Shipping');
        $shipMoney = $doc->createElement('Money', number_format($order->getDeliveryFeeTotal(), 2, '.', ''));
        $shipMoney->setAttribute('currency', 'JPY');
        $shipping->appendChild($shipMoney);
        $desc = $doc->createElement('Description', '配送料（税抜）.');
        $desc->setAttribute('xml:lang', 'ja-JP');
        $shipping->appendChild($desc);
        $header->appendChild($shipping);

        // --- Tax（税額） ---
        $tax = $doc->createElement('Tax');
        $taxMoney = $doc->createElement('Money', number_format($order->getTax(), 2, '.', ''));
        $taxMoney->setAttribute('currency', 'JPY');
        $tax->appendChild($taxMoney);
        $desc = $doc->createElement('Description', '消費税（配送料に対する税額を含む）');
        $desc->setAttribute('xml:lang', 'ja-JP');
        $tax->appendChild($desc);
        $header->appendChild($tax);

        // PunchOutOrderMessage に追加
        $punchOut->appendChild($header);

        $index = 1; // SupplierPartAuxiliaryID 用の連番
        foreach ($order->getOrderItems() as $item) {

            $itemIn = $doc->createElement('ItemIn');
            $itemIn->setAttribute('quantity', $item->getQuantity());

            // itemID
            $itemID = $doc->createElement("ItemID");
            $itemID->appendChild($doc->createElement('SupplierPartID', $item->getProductCode()));
            $itemID->appendChild($doc->createElement('SupplierPartAuxiliaryID', $order->getId() . ',' . $index++));
            $itemIn->appendChild($itemID);

            // itemDetail
            $itemDetail = $doc->createElement('ItemDetail');
            $unitPrice = $doc->createElement("UnitPrice");
            $money = $doc->createElement("Money", number_format($item->getPrice(), 2, '.', ''));
            $money->setAttribute('currency', 'JPY');
            $unitPrice->appendChild($money);
            $itemDetail->appendChild($unitPrice);


            $desc = $doc->createElement('Description', $item->getProductName());
            $desc->setAttribute('xml:lang', 'ja-JP');
            $itemDetail->appendChild($desc);

            $itemDetail->appendChild($doc->createElement('UnitOfMeasure', 'EA'));

            // UNSPSCコード（あれば）
            $itemDetail->appendChild($doc->createElement('Classification', '43211706'))->setAttribute('domain', 'UNSPSC');

            // メーカー情報（なければ空文字）
            $itemDetail->appendChild($doc->createElement('ManufacturerPartID', 'K840'));
            $itemDetail->appendChild($doc->createElement('ManufacturerName', 'ロジクール'));

            // Extrinsic 項目
            $itemDetail->appendChild($doc->createElement('Extrinsic', 'Amazon'))->setAttribute('name', 'soldBy');
            $itemDetail->appendChild($doc->createElement('Extrinsic', 'https://www.amazon.co.jp/dp/' . $item->getProductCode()))->setAttribute('name', 'detailPageURL');

            $itemIn->appendChild($itemDetail);

            // --- Shipping ---
            $shipping = $doc->createElement('Shipping');
            $shipMoney = $doc->createElement('Money', '0.00');
            $shipMoney->setAttribute('currency', 'JPY');
            $shipping->appendChild($shipMoney);
            $shipping->appendChild($doc->createElement('Description', '配送料（税抜）.'))->setAttribute('xml:lang', 'ja-JP');
            $itemIn->appendChild($shipping);

            // --- Tax ---
            $tax = $doc->createElement('Tax');
            $taxMoney = $doc->createElement('Money', number_format($item->getTax(), 2, '.', ''));
            $taxMoney->setAttribute('currency', 'JPY');
            $tax->appendChild($taxMoney);
            $tax->appendChild($doc->createElement('Description', '消費税'))->setAttribute('xml:lang', 'ja-JP');
            $itemIn->appendChild($tax);


            $punchOut->appendChild($itemIn);

            // 商品名
            $productName = $item->getProductName();

            // 商品コード（Amazonでいう SupplierPartID 相当）
            $productCode = $item->getProductCode();

            // 数量
            $quantity = $item->getQuantity();

            // 単価（税抜）
            $price = $item->getPrice();

            // 税
            $tax = $item->getTax();

            // 税率
            $taxRate = $item->getTaxRate();

            // EANやURLなど追加項目が必要な場合、Product エンティティから取得する必要があります（例：$item->getProductClass()->getProduct()）

            // ★ここでログで確認しておくと安心
            $this->logger->info("商品取得", [
                'name' => $productName,
                'code' => $productCode,
                'price' => $price,
                'qty' => $quantity,
                'tax' => $tax,
                'tax_rate' => $taxRate,
            ]);
        }

        // ここでPunchOutOrderMessage用のXMLを生成して、POST送信します
        $postUrl = $browserPostUrl; // お客様側のエンドポイント

        $xml = $doc->saveXML();

        // POST送信
        try {
            $client = new \GuzzleHttp\Client();
            $client->post($postUrl, [
                'headers' => ['Content-Type' => 'application/xml'],
                'body' => $xml,
            ]);
        } catch (\Throwable $e) {
            $this->logger->error('PunchOutOrderMessage送信失敗', ['error' => $e->getMessage()]);
        }

    }

}
