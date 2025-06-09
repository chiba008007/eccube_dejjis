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

class MyApiDebugController extends AbstractController
{
    use TransactionalTrait;

    private $map;

    private LoggerInterface $logger;

    private $punchoutSessionService;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, PunchoutSessionService $punchoutSessionService)
    {

        $this->setEntityManager($entityManager); // TraitにEntityManagerを渡す

        $this->logger = $logger;

        $this->punchoutSessionService = $punchoutSessionService;
    }

    /**
     * @Route("%eccube_admin_route%/api/my", name="app_admin_api_my")
     */
    public function index(Request $request): Response
    {
        $mode = getenv('API_MODE') ?: 'unknown';
        $this->logger->debug('APIデバック処理の開始', ['method' => __METHOD__]);


        // ①PunchOutSetupRequestから②PunchOutSetupResponse
        $url = "http://localhost/api/mock/punchout/PunchOutSetupRequest/PunchOutSetupResponse";
        $requestBodyServerPath = "/var/www/html/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml"; // サーバー用
        $requestBodyWebPath = "/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml"; // クライアント用（Webブラウザからの相対URL）
        $requestBody = file_get_contents($requestBodyServerPath);

        return $this->render('/admin/api_debug/my.html.twig', [
            "mode" => $mode,
            "url" => $url,
            "request_body_web_path" => $requestBodyWebPath,
            "request_body" => $requestBody
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
