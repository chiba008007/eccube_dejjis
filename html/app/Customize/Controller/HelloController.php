<?php

namespace Customize\Controller;

use Symfony\Component\HttpFoundation\Request;
use Customize\Repository\HelloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\Hello;
use Customize\Form\HelloType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello/new", name="hello_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntitymanagerInterface $em): Response
    {
        $hello = new Hello();
        $form = $this->createForm(HelloType::class, $hello);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($hello);
            $em->flush();
            $this->addFlash("success", "データが登録されました");
            return $this->redirectToRoute('hello_new');
        }
        // フォームを作成
        return $this->render('hello/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/hello/edit/{id}", name="hello_edit", methods={"GET","POST"})
     * @template("/hello/edit.html.twig")
     */
    public function edit($id, Request $request, EntityManagerInterface $em)
    {
        $hello = $em->getRepository(Hello::class)->find($id);
        if (!$hello) {
            throw $this->createNotFoundException('データが見つかりません。');
        }
        $form = $this->createForm(HelloType::class, $hello);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash("success", "データが更新されました");
            return $this->redirectToRoute('app_hello');
        }
        return [
            'form' => $form->createView(),
            'hello' => $hello,
        ];
    }
    /**
     * @Route("/hello", name="app_hello")
     * @Template("/hello/index.html.twig")
     */
    public function index(HelloRepository $helloRepository)
    {
        $hellos = $helloRepository->findAll();
        return [
            'controller_name' => 'HelloController',
            'hellos' => $hellos,
        ];
    }
}
