<?php

namespace Customize\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Customize\Resource\trait\TransactionalTrait;
use Psr\Log\LoggerInterface;
use Customize\Service\PunchoutSessionService;

class ApiDebugController extends AbstractController
{
    use TransactionalTrait;

    private $map;

    private LoggerInterface $logger;

    private $punchoutSessionService;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, PunchoutSessionService $punchoutSessionService)
    {
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
            'cxml_orderRequestChange' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/orderRequestChange',
                    'real' => 'https://real.api.example.com/******',
                ],
                'file' => '/var/www/html/mockdata/mock-cxml-api-orderRequest.xml',
                'content_type' => 'application/xml',
            ],
            'cxml_orderRequestCancel' => [
                'url' => [
                    'mock' => 'http://mock-api-server:3456/orderRequestCancel',
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

        $this->map = $map;

        $this->setEntityManager($entityManager); // TraitにEntityManagerを渡す

        $this->logger = $logger;

        $this->punchoutSessionService = $punchoutSessionService;
    }

    /**
     * @Route("%eccube_admin_route%/api/debug", name="app_admin_api_debug")
     */
    public function index(Request $request): Response
    {

        $this->logger->debug('APIデバック処理の開始', ['method' => __METHOD__]);

        $mode = getenv('API_MODE') ?: 'unknown';

        // 選択されたAPIの種類（デフォルトは cxml）
        $apiType = $request->get('api_type', 'cxml_TEST');

        $selected = $this->map[$apiType];
        $url = $selected['url'][$mode];
        $responseParsed = null;
        $matchResult = '';

        try {
            //  $this->runInTransaction(function () use ($selected, $url, $apiType, &$body, &$responseParsed, &$matchResult, &$requestBody) {

            $requestBody = file_get_contents($selected['file']);

            /*
                                        $fileXml = simplexml_load_string($requestBody);
                                        $this->logger->debug('登録処理の開始', ['method' => __METHOD__]);
                                        if (
                                            $apiType === "cxml_punchout_PunchOutSetupRequest2" ||
                                            $apiType === "cxml_punchout_PunchOutSetupRequest3" ||
                                            $apiType === "cxml_punchout_PunchOutSetupRequest3_finCatalog"
                                        ) {
                                            // requestBodyをDBに保持
                                            $params = [
                                                "buyer_cookie" => (string)$fileXml->Request->PunchOutSetupRequest->BuyerCookie,
                                                "request_xml" => $fileXml->asXML(),
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

                                            if ($this->punchoutSessionService->createSession($params) === false) {
                                                throw new \Exception();
                                            } else {
                                                $this->logger->debug('登録処理の成功', ['method' => __METHOD__]);
                                            }

                                        }
                        */

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

            //     $this->entityManager->flush();
            //     });

            return $this->render('/admin/api_debug/index.html.twig', [
                'mode' => $mode,
                'url' => $url,
                'response' => $body,
                'match_result' => $matchResult,
                'request_body' => $requestBody,
                'api_type' => $apiType,
                'response_parsed' => $responseParsed,
            ]);

        } catch (\Exception $e) {
            $body = "エラー" . $e->getMessage();
            echo $body;
            exit();
        }


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
