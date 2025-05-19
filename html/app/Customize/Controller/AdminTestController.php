<?php

namespace Customize\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTestController extends AbstractController
{
    /**
     * @Route("/admin/test/event", name="admin_test_event")
     */
    public function index()
    {
        return $this->render('@Customize/admin/system.twig');
    }
}
