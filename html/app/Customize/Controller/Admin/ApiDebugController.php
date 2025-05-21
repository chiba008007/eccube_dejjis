<?php

namespace Customize\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

class ApiDebugController extends AbstractController
{
    /**
     * @Route("%eccube_admin_route%/api/debug", name="app_admin_api_debug")
     */
    public function index(): Response
    {
        $mode = getenv('API_MODE') ?: 'unknown';

        $url = $mode === 'mock'
            ? 'http://mock-api-server:3456/amazonApiSample'
            : 'https://real.api.example.com/endpoint'; // 実APIに差し替え

        try {
            // ここでcxml形式の文字列をリクエストするデータの準備
            $cxml_request = "";
            if ($mode === 'mock') {
                // リクエスト値モック用(cxml)
                $cxml_request = file_get_contents('/var/www/html/mockdata/mock-cxml-api-request.xml');
            } else {
                // リクエスト本番用
                $cxml_request = "";
            }
            $client = new Client();
            $res = $client->post($url, [
                'headers' => ['Content-Type' => 'application/xml'],
                'body' => $cxml_request,
            ]);
            $body = (string) $res->getBody();
            // cxmlをphpで解析
            // BuyerCookie を取り出す
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($body);
            $buyerCookie = (string)$xml->Message->PunchOutOrderMessage->BuyerCookie;

            $requestXml = simplexml_load_string($cxml_request);
            $sentBuyerCookie = (string)$requestXml->Request->PunchOutSetupRequest->BuyerCookie;
            $matched = $buyerCookie === $sentBuyerCookie;
            $matchResult = $matched
                ? "✔ BuyerCookie 一致: $buyerCookie"
                : "✖ BuyerCookie 不一致\n送信: $sentBuyerCookie\n受信: $buyerCookie";


        } catch (\Exception $e) {
            $body = "エラー" . $e->getMessage();
        }
        return $this->render('admin/api_debug/index.html.twig', [
            'mode' => $mode,
            'url' => $url,
            'response' => $body,
            'match_result' => $matchResult,
        ]);
    }
}
