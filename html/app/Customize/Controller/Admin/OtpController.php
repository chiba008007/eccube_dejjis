<?php

namespace Customize\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Repository\MemberRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;

class OtpController extends AbstractController
{
    public $errorCount = 5; //5回間違ったらログイン画面

    #[Route("/%eccube_admin_route%/verify", name: "admin_2fa_verify", methods: ["GET", "POST"])]
    public function verify(Request $request, EntityManagerInterface $entityManager, MemberRepository $memberRepository, TokenStorageInterface $tokenStorage): Response
    {

        $session = $request->getSession();
        $userId = $session->get('otp_user_id');
        if (!$userId) {
            $this->addFlash('error', 'ログイン情報が見つかりません。');
            return $this->redirectToRoute('admin_login');
        }

        $user = $memberRepository->find($userId);
        $otp = $user->getAuthCode();
        $generatedAt = $user->getAuthCodeExpiresAt();
        $getAuthCodeTryCount = $user->getAuthCodeTryCount();

        if (new \DateTime() > $generatedAt) {
            $this->addFlash('error', 'OTPの有効期限が切れています。');
            return $this->redirectToRoute('admin_login');
        }

        if ($request->isMethod('POST')) {
            if ($request->request->get('otp') === (string)$otp) {
                $token = new UsernamePasswordToken($user, 'admin', $user->getRoles());
                $tokenStorage->setToken($token);

                $user->setAuthCode(null);
                $user->setAuthCodeExpiresAt(null);
                $user->setAuthCodeTryCount(0);

                $session->remove('otp_user_id');
                $entityManager->flush();
                return $this->redirectToRoute('admin_homepage');
            } else {
                // 5回以上間違ったとき
                if ($getAuthCodeTryCount >= $this->errorCount) {
                    $user->setAuthCode(null);
                    $user->setAuthCodeExpiresAt(null);
                    $user->setAuthCodeTryCount(0);
                    $entityManager->flush();
                    $session->remove('otp_user_id');
                    return $this->redirectToRoute('admin_login');
                }
                $user->setAuthCodeTryCount(($user->getAuthCodeTryCount() ?? 0) + 1);
                $entityManager->flush();
                $this->addFlash('error', 'OTPコードが間違っています。');
            }
        }

        return $this->render('/admin/two_factor/otp_verify.twig', [
            'controller_name' => 'TwoFactorController',
        ]);
    }
}
