<?php

namespace Customize\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyCustomController extends AbstractController
{
    /**
     * @Route("/controller/my/custom", name="app_controller_my_custom")
     */
    public function index(): Response
    {

        
        return $this->render('controller/my_custom/index.html.twig', [
            'controller_name' => 'MyCustomController',
        ]);
    }
}
