<?php

namespace Customize\Controller\Mock;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Customize\Service\PunchoutSessionService;
use Customize\Service\AmazonOrderRequest;
use Customize\Service\AmazonOrderRequestItem;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

use function PHPUnit\Framework\throwException;

class PunchOutController extends AbstractController
{
    /**
     * PunchOutセッションのエントリーポイント
     *
     * @Route("/punchout/session/{session_id}", name="punchout_entry", methods={"GET"})
     */
    public function entry(string $session_id, PunchoutSessionService $sessionService): Response
    {
        // セッションの有効確認
        $session = $sessionService->findBySessionId($session_id);
        if (!$session) {
            throw $this->createNotFoundException("PunchOutセッションが見つかりません");
        }
        // 例として商品一覧にリダイレクト（パラメータ付き）
        return $this->redirectToRoute('product_list', ['_punchout' => 1, 'session_id' => $session_id]);
    }

    /**
     * @Route("/api/mock/punchout/PunchOutSetupRequest/PunchOutSetupResponse", name="mock_punchout_setup", methods={"POST","GET"})
    */
    // ①PunchOutSetupRequestから②PunchOutSetupResponse
    public function PunchOutSetupResponse(Request $request, PunchoutSessionService $sessionService): Response
    {

        $xml = $request->getContent();
        $fileXml = simplexml_load_string($xml);
        $sessionId = bin2hex(random_bytes(16));
        $params = [
          "session_id" => $sessionId,
          "buyer_cookie" => (string)$fileXml->Request->PunchOutSetupRequest->BuyerCookie,
          "request_xml" => $fileXml->asXML(),
          "browser_post_url" => (string)$fileXml->Request->PunchOutSetupRequest->BrowserFormPost->URL,
          "user_email" => (string)$fileXml->Request->PunchOutSetupRequest->Extrinsic[1],
          "user_first_name" => (string)$fileXml->Request->PunchOutSetupRequest->Extrinsic[3],
          "user_last_name" => (string)$fileXml->Request->PunchOutSetupRequest->Extrinsic[4],
          "start_date" => (string)$fileXml->Request->PunchOutSetupRequest->Extrinsic[2],
          "country" => (string)$fileXml->Request->PunchOutSetupRequest->Extrinsic[0],
          "business_unit" => (string)$fileXml->Request->PunchOutSetupRequest->Extrinsic[5],
          "ship_to_json" => json_encode($fileXml->Request->PunchOutSetupRequest->ShipTo),
          "expire_at" => (new \DateTime())->modify('+1 hour'), // 有効期限 1時間を指定
          "is_used" => true
        ];


        $success = $sessionService->createSession($params);
        if (!$success) {
            // エラーの時のxmlを返す
            $errorXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cXML payloadID="error" timestamp="{$params['start_date']}">
  <Response>
    <Status code="500" text="Internal Server Error">PunchOut session registration failed.</Status>
  </Response>
</cXML>
XML;
            return new Response($errorXml, 500, ['Content-Type' => 'application/xml']);
        } else {
            $responseXml = file_get_contents("/var/www/html/mockdata/mock-cxml-api-response-PunchOutSetupResponse.xml");
            $responseXml = $sessionService->replacePlaceholder($responseXml, $sessionId);
            return new Response($responseXml, 200, ['Content-Type' => 'application/xml']);
        }
    }


    /**
     * @Route("/api/mock/punchout/orderRequest", name="mock_orderRequest_setup", methods={"POST","GET"})
    */
    // ①OrderRequest
    public function PunchOutOrderRequest(
        Request $request,
        AmazonOrderRequest $amazonOrder,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ): Response {
        $entityManager->getConnection()->beginTransaction();
        $logger->info('OrderRequest登録処理開始');
        try {
            $xml = $request->getContent();
            $fileXml = simplexml_load_string($xml);
            $params = [
              "payload_id" => (string)$fileXml['payloadID'],
              "order_id" => (string)$fileXml->Request->OrderRequest->OrderRequestHeader[ 'orderID' ],
              "buyer_id" => (string)$fileXml->Header->From->Credential->Identity,
              "total_amount" => (string)$fileXml->Request->OrderRequest->OrderRequestHeader->Total->Money,
              "currency" => (string)$fileXml->Request->OrderRequest->OrderRequestHeader->Total->Money[ 'currency' ],
              "status" => "new",
              "raw_cxml" => $fileXml->asXML(),
            ];
            $logger->info('OrderRequest登録処理', ['params' => $params]);

            $amazon = $amazonOrder->createSession($params);
            if ($amazon) {
                $itemParamsList = $fileXml->Request->OrderRequest->ItemOut;
                foreach ($itemParamsList as $itemParams) {

                    $itemService = new AmazonOrderRequestItem($entityManager, $logger);
                    $params = [
                      "line_number" => (string)$itemParams['lineNumber'],
                      "supplier_part_id" => (string)$itemParams->ItemID->SupplierPartID,
                      "supplier_part_auxiliary_id" => (string)$itemParams->ItemID->SupplierPartAuxiliaryID,
                      "quantity" => (string)$itemParams['quantity'],
                      "unit_price" => (string)$fileXml->Request->OrderRequest->ItemOut->ItemDetail->UnitPrice->Money,
                      "description" => (string)$fileXml->Request->OrderRequest->ItemOut->ItemDetail->Description,
                      "manufacturer_part_id" => (string)$fileXml->Request->OrderRequest->ItemOut->ItemDetail->ManufacturerPartID,
                      "manufacturer_name" => (string)$fileXml->Request->OrderRequest->ItemOut->ItemDetail->ManufacturerName,
                      "category" => (string)$fileXml->Request->OrderRequest->ItemOut->Tax->TaxDetail['category'],
                      "sub_category" => $itemService->getSubCategory($itemParams, "subCategory"),
                      "item_condition" => $itemService->getSubCategory($itemParams, "itemCondition"),
                      "detail_page_url" => $itemService->getSubCategory($itemParams, "detailPageURL"),
                      "ean" => $itemService->getSubCategory($itemParams, "ean"),
                      "preference" => $itemService->getSubCategory($itemParams, "preference"),

                      "request" => $amazon
                    ];
                    $logger->info('OrderRequestアイテム登録', ['params' => $params]);
                    $itemService->createSession($params);
                }
                $logger->info('OrderRequest登録終了');
                $entityManager->flush();

            } else {
                $logger->error('OrderRequest登録失敗', ['params' => $params]);

                throwException(new \Exception('REGIST FALSE'));
            }

            $responseXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cXML payloadID="ok" timestamp="">
  <Response>
    <Status code="200" text="OK" >Success</Status>
  </Response>
</cXML>
XML;
            $entityManager->getConnection()->commit();
            return new Response($responseXml, 200, ['Content-Type' => 'application/xml']);

        } catch (\Exception $e) {
            // エラーの時のxmlを返す
            $errorXml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<cXML payloadID="error" timestamp="">
  <Response>
    <Status code="500" text="Internal Server Error">{{$e}}</Status>
  </Response>
</cXML>
XML;
            $entityManager->getConnection()->rollBack();
            return new Response($errorXml, 500, ['Content-Type' => 'application/xml']);
        }
    }

}
