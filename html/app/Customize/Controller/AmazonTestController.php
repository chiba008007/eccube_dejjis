<?php

namespace Customize\Controller;

use Customize\Service\AmazonApiService;
use Customize\Service\AmazonApiServiceConnect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmazonTestController extends AbstractController
{
    /**
     * @Route("/amazon/amazonApiSample", name="amazonApiSample", methods={"GET","POST"})
     * http://mock-api-server:3456/amazonApiSample
     */
    public function amazonApiSample(AmazonApiService $amazonApiService): Response
    {
        $result = $amazonApiService->createSample();
        return $this->json($result);
    }

    /**
     * @Route("/amazonApiPunchOutSetupRequest", name="PunchOutSetupRequest", methods={"GET","POST"})
     */
    public function amazonApiPunchOutSetupRequest(AmazonApiServiceConnect $amazonApiService): Response
    {
        $xmlpath = '/var/www/html/mockdata/mock-cxml-api-request-PunchOutSetupRequest.xml';
        $result = $amazonApiService->getApiResponse($xmlpath, "http://mock-api-server:3456/amazonApiPunchOutSetupRequest");
        return $this->json($result);
    }
    /**
     * @Route("/amazon/test", name="app_amazon_test")
     */
    public function index(): Response
    {
        return $this->render('amazon_test/index.html.twig', [
            'controller_name' => 'AmazonTestController',
        ]);
    }

    /**
     * @Route("test-amazon-api", name="test_amazon_api")
     */
    public function test(AmazonApiService $amazonApiService)
    {
        $result = $amazonApiService->createOrder([
            'sku' => 'ABC123',
            'quantity' => 2,
        ]);

        return $this->json($result);
    }
}
