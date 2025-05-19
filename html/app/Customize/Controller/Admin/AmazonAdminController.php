<?php

namespace Customize\Controller\Admin;

use Customize\Service\AmazonApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AmazonAdminController extends AbstractController
{
    /**
     * @Route("%eccube_admin_route%/amazon", name="admin_amazon_index" , methods={"GET","POST"})
     * @template("admin/amazon_admin/index.html.twig")
     */
    public function index(Request $request, AmazonApiService $amazonApiService)
    {
        $result = null;
        if ($request->isMethod('POST')) {
            $result = $amazonApiService->createOrder([
                'sku' => 'ABC123',
                'quantity' => 2,
            ]);
        }
        return [
            'result' => $result
        ];
    }
}
