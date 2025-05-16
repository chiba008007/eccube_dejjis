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
use Psr\Log\LoggerInterface;

class HelloController extends AbstractController
{
    private $em;
    private $logger;
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {

        $this->em = $em;
        $this->logger = $logger;
    }
    /**
     * @Route("/hello/new", name="hello_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hello = new Hello();
        $form = $this->createForm(HelloType::class, $hello);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            if ($file) {
                $originalExtension = $file->getClientOriginalExtension();
                $filename = uniqid().".".$originalExtension;
                $file->move($this->getParameter("eccube_save_image_dir"), $filename);
                $hello->setImagePath("upload/save_image/".$filename);
            }
            $this->em->persist($hello);
            $this->em->flush();
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
    public function edit($id, Request $request)
    {
        $hello = $this->em->getRepository(Hello::class)->find($id);
        if (!$hello) {
            throw $this->createNotFoundException('データが見つかりません。');
        }
        $form = $this->createForm(HelloType::class, $hello);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
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
        $this->logger->info("indexページのデバックログです");

        $hellos = $helloRepository->findAll();
        return [
            'controller_name' => 'HelloController',
            'hellos' => $hellos,
        ];
    }
}
