<?php

namespace Customize\Controller;

use Symfony\Component\HttpFoundation\Request;
use Eccube\Entity\BaseInfo;
use Customize\Form\Type\BaseInfoType;
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
        $products = $product_repository->findAll();

        return [
            'controller_name' => 'MyCustomController12',
            'products' => $products
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
    /**
     * @Method("GET")
     * @Route("%eccube_admin_route%/baseInfo", name="customize_admin_baseinfo")
     * @template("/controller/my_custom/form.html.twig")
     */
    public function baseinfo(Request $request)
    {
        // 既存のBaseInfoエンティティを取得
        $baseInfo = $this->getDoctrine()->getRepository(BaseInfo::class)->find(1);

        // フォームを作成
        $form = $this->createForm(BaseInfoType::class, $baseInfo);

        // フォームが送信されたかを確認
        $form->handleRequest($request);

        return [
            "controller_name" => "baseInfo Controller",
            "form" => $form->createView()
        ];
    }
    /**
     * @Method("POST")
     * @Route("%eccube_admin_route%/baseInfo", name="customize_admin_baseinfo_set")
     */
    public function baseinfoSet(Request $request)
    {
        $baseInfo = $this->getDoctrine()->getRepository(BaseInfo::class)->find(1);

        // フォームを作成
        $form = $this->createForm(BaseInfoType::class, $baseInfo);

        // フォームが送信されたかを確認
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'BaseInfoが更新されました');
        } else {
            $this->addFlash('error', 'BaseInfoが更新失敗しました');
        }
        return $this->redirectToRoute('customize_admin_baseinfo');
    }
}
