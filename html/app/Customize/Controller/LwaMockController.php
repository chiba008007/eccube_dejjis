<?php

namespace Customize\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LwaMockController extends AbstractController
{
    #[Route('/lwa/mock', name: 'lwa_mock_login')]
    public function login(): Response
    {
        return $this->render('Lwa/mock_login.twig');
    }

    #[Route("/lwa/mock/authorize", name:'lwa_mock_authorize')]
    public function authorize(Request $request): Response
    {
        $code = $request->query->get("code", "mock-code");
        return $this->redirectToRoute('lwa_mock_callback', ["code" => $code]);
    }

    #[Route('/lwa/mock/callback', name: 'lwa_mock_callback')]
    public function callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $accessToken = base64_encode("mock-token-for-{$code}");
        // sessionにtokenを保持
        $session = $request->getSession();
        $session->set('lwa_access_token', $accessToken);

        //dump($session->all());

        return new Response("認可コード: {$code}<br>モックAccessToken: {$accessToken}");
    }

}
