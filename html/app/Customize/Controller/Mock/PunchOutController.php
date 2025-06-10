<?php

namespace Customize\Controller\Mock;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Customize\Service\PunchoutSessionService;

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
}
