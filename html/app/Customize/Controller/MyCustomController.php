<?php

namespace Customize\Controller;

use Eccube\Repository\BaseInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MyCustomController extends AbstractController
{
    protected $BaseInfo;
    public function __construct(BaseInfoRepository $baseInfoRepository)
    {
        $this->BaseInfo = $baseInfoRepository->get();
    }
    /**
     * @Method("GET")
     * @Route("/mycustom", name="app_controller_my_custom")
     * @template("/controller/my_custom/index.html.twig")
     */
    public function index(ProductRepository $product_repository, PaginatorInterface $paginator)
    {
        $products = $product_repository->getQueryBuilderBySearchDataForAdmin(['id' => 0]);
        $pagination = $paginator->paginate(
            $products,
            1,
            1
        );
        return [
            'controller_name' => 'MyCustomController12',
            'products' => $pagination
        ];
    }
    /**
     * @Method("GET")
     * @Route("/mycustom/{id}", name="app_controller_my_custom_get")
     * @template("/controller/my_custom/index.html.twig")
     */
    public function testMethod($id, ProductRepository $product_repository)
    {
        $products = $product_repository->getQueryBuilderBySearchDataForAdmin(['id' => 0]);
        return [
            'controller_name' => 'MyCustomController_testMethod',
            'products' => $products
        ];
    }
    /**
     * @Method("GET")
     * @Route("%eccube_admin_route%/sample", name="customize_admin_sample")
     * 管理画面にログインしているユーザのみ
     */
    public function sample()
    {
        return new Response("admin page ".$this->BaseInfo->getShopName());
    }
    /**
     * @Method("GET")
     * @Route("%eccube_admin_route%/none", name="customize_admin_none")
     */
    public function none()
    {
        return $this->redirectToRoute("customize_admin_sample");
    }
}
