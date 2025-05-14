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
     * @Route("/hello", name="app_hello")
     */
    public function index(HelloRepository $helloRepository): Response
    {
        $hellos = $helloRepository->findAll();

        return $this->render('hello/index.html.twig', [
            'controller_name' => 'HelloController',
            'hellos' => $hellos,
        ]);
    }
}
