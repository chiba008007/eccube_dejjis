<?php

namespace Customize\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Repository\MemberRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OtpController extends AbstractController
{
    #[Route("/%eccube_admin_route%/verify", name: "admin_2fa_verify", methods: ["GET", "POST"])]
    public function verify(Request $request, MemberRepository $memberRepository, TokenStorageInterface $tokenStorage): Response
    {

        $session = $request->getSession();
        $userId = $session->get('otp_user_id');
        $otp = $session->get('otp_code');
        $generatedAt = $session->get('otp_generated_at');

        if (!$userId || !$otp || time() - $generatedAt > 300) {
            $this->addFlash('error', 'OTPの有効期限が切れています。');
            return $this->redirectToRoute('admin_login');
        }

        $user = $memberRepository->find($userId);

        if ($request->isMethod('POST')) {
            if ($request->request->get('otp') === (string)$otp) {
                $token = new UsernamePasswordToken($user, 'admin', $user->getRoles());
                $tokenStorage->setToken($token);
                $session->remove('otp_user_id');
                $session->remove('otp_code');
                $session->remove('otp_generated_at');
                return $this->redirectToRoute('admin_homepage');
            } else {
                $this->addFlash('error', 'OTPコードが間違っています。');
            }
        }

        return $this->render('/admin/two_factor/otp_verify.twig', [
            'controller_name' => 'TwoFactorController',
        ]);
    }
}
