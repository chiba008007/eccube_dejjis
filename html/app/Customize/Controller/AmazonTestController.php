<?php

namespace Customize\Controller;

use Customize\Service\AmazonApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmazonTestController extends AbstractController
{
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
