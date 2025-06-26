<?php

namespace Customize\Service\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Eccube\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class AdminAuthenticatorWithOtp extends AbstractAuthenticator
{
    use TargetPathTrait;

    private RouterInterface $router;
    private MemberRepository $memberRepository;
    private SessionInterface $session;
    private MailerInterface $mailer;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        RouterInterface $router,
        MemberRepository $memberRepository,
        SessionInterface $session,
        MailerInterface $mailer,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->router = $router;
        $this->memberRepository = $memberRepository;
        $this->session = $session;
        $this->mailer = $mailer;
        $this->passwordHasher = $passwordHasher;
    }

    public function supports(Request $request): ?bool
    {

        $path = $request->getPathInfo();
        if (str_starts_with($path, '/admin/verify')) {
            return false;
        }
        return $request->isMethod('POST')
        && $request->getPathInfo() === '/admin/login';
    }

    public function authenticate(Request $request)
    {
        $loginId = $request->request->get('login_id');
        $password = $request->request->get('password');
        $user = $this->memberRepository->findOneBy(['login_id' => $loginId]);

        //if (!$user || !password_verify($password, $user->getPassword())) {
        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new CustomUserMessageAuthenticationException('ログインIDまたはパスワードが間違っています。');
        }

        // OTPコードを生成（例: 6桁）
        $otpCode = random_int(100000, 999999);
        $this->session->set('otp_user_id', $user->getId());
        $this->session->set('otp_code', $otpCode);
        $this->session->set('otp_generated_at', time());

        // メール送信
        $email = (new Email())
            ->to($user->getLoginId())
            ->from('xxx@example.com')
            ->subject('ECCUBE 管理画面ログイン用ワンタイムパスワード')
            ->text("以下のコードを入力してください：\n\n{$otpCode}");

        $this->mailer->send($email);


        throw new CustomUserMessageAuthenticationException('otp_required');
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response {
        return new RedirectResponse($this->router->generate('admin_homepage'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ($exception->getMessage() === 'otp_required') {
            return new RedirectResponse($this->router->generate('admin_2fa_verify'));
        }
        return new RedirectResponse($this->router->generate('admin_login'));
    }
}
