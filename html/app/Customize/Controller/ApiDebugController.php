<?php

namespace Customize\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class ApiDebugController extends AbstractController
{
    /**
     * @Route("%eccube_admin_route%/api/debug", name="app_admin_api_debug")
     */
    public function index(Request $request): Response
    {
        $mode = getenv('API_MODE') ?: 'unknown';

        // 選択されたAPIの種類（デフォルトは cxml）
        $apiType = $request->get('api_type', 'cxml_TEST');

        $map = [
            'cxml_TEST' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/amazonApiSample',
                    'real' => 'https://real.api.example.com/amazonApiSample',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-request.xml',
                'content_type' => 'application/xml',
            ],
            'cxml_punchout_PunchOutSetupRequest2' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/punchOutSetupRequest2',
                    'real' => 'https://real.api.example.com/******',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml',
                'content_type' => 'application/xml',
            ],
            'cxml_punchout_PunchOutSetupRequest3' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/punchOutSetupRequest3',
                    'real' => 'https://real.api.example.com/******',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml',
                'content_type' => 'application/xml',
            ],
            'cxml_punchout_PunchOutSetupRequest3_finCatalog' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/punchOutSetupRequest3_finCatalog',
                    'real' => 'https://real.api.example.com/******',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml',
                'content_type' => 'application/xml',
            ],
            'cxml_orderRequest' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/orderRequest',
                    'real' => 'https://real.api.example.com/******',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-orderRequest.xml',
                'content_type' => 'application/xml',
            ],
            'cxml_shipmentNotice' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/shipmentNotice',
                    'real' => 'https://real.api.example.com/******',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-shipmentNotice.xml',
                'content_type' => 'application/xml',
            ],

            'json' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/amazonJsonApiSample',
                    'real' => 'https://real.api.example.com/amazonJsonApiSample',
                ],
                'file' => '/var/www/html/mockdata/mock-json-api-request.json',
                'content_type' => 'application/json',
            ],
        ];

        $selected = $map[$apiType];
        $url = $selected['url'][$mode];
        $responseParsed = null;
        $matchResult = '';
        try {
            $requestBody = file_get_contents($selected['file']);
            $client = new Client();
            $res = $client->post($url, [
                'headers' => ['Content-Type' => $selected['content_type']],
                'body' => $requestBody,
            ]);
            $body = (string) $res->getBody();
            // XML専用のBuyerCookieチェック（CXMLのみ）
            if (str_starts_with($apiType, 'cxml')) {
                libxml_use_internal_errors(true);

                $xml = simplexml_load_string($body);
                $buyerCookie = "";
                if (isset($xml->Message->PunchOutOrderMessage->BuyerCookie)) {
                    $buyerCookie = (string)$xml->Message->PunchOutOrderMessage->BuyerCookie;
                }
                $requestXml = simplexml_load_string($requestBody);
                $sentBuyerCookie = (string)$requestXml->Request->PunchOutSetupRequest->BuyerCookie;

                $matched = $buyerCookie === $sentBuyerCookie;
                $matchResult = $matched
                    ? "✔ BuyerCookie 一致: $buyerCookie"
                    : "✖ BuyerCookie 不一致\n送信: $sentBuyerCookie\n受信: $buyerCookie";
            }
            if ($xml) {
                $responseParsed = $this->xmlToStructuredArray($xml);
            }

        } catch (\Exception $e) {
            $body = "エラー" . $e->getMessage();
        }

        return $this->render('/admin/api_debug/index.html.twig', [
            'mode' => $mode,
            'url' => $url,
            'response' => $body,
            'match_result' => $matchResult,
            'request_body' => $requestBody,
            'api_type' => $apiType,
            'response_parsed' => $responseParsed,
        ]);
    }

    private function xmlToStructuredArray(\SimpleXMLElement $xml): array
    {
        $result = [
            'tagName' => $xml->getName(),
            'attributes' => [],
            'value' => trim((string)$xml) ?: null,
            'children' => [],
        ];

        foreach ($xml->attributes() as $attrName => $attrValue) {
            $result['attributes'][$attrName] = (string)$attrValue;
        }

        foreach ($xml->children() as $child) {
            $result['children'][] = $this->xmlToStructuredArray($child);
        }

        return $result;
    }
}
