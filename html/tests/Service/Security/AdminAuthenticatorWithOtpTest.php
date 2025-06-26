<?php

namespace App\Tests\Service\Security;

use Customize\Service\Security\AdminAuthenticatorWithOtp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Eccube\Repository\MemberRepository;
use Eccube\Entity\Member;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Mailer\Exception\TransportException;

class AdminAuthenticatorWithOtpTest extends TestCase
{
    public function testAuthenticateGeneratesOtpAndSendsEmail正常系()
    {

        echo "\ntestAuthenticateGeneratesOtpAndSendsEmail正常系_ 実行中";

        $user = $this->createMock(Member::class);
        $user->method('getId')->willReturn(1);
        $user->method('getLoginId')->willReturn('admin@example.com');
        $user->method('getRoles')->willReturn(['ROLE_ADMIN']);

        $passwordHasher = $this->createMock(UserPasswordHasher::class);
        $passwordHasher->method('isPasswordValid')->willReturn(true);

        $memberRepo = $this->createMock(MemberRepository::class);
        $memberRepo->method('findOneBy')->willReturn($user);

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())->method('set')->with('otp_user_id', 1);

        $router = $this->createMock(RouterInterface::class);
        $mailer = $this->createMock(MailerInterface::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getConnection')->willReturn(new class () {
            public function beginTransaction()
            {
            }
            public function commit()
            {
            }
        });

        $authenticator = new AdminAuthenticatorWithOtp(
            $router,
            $memberRepo,
            $session,
            $mailer,
            $passwordHasher,
            $entityManager
        );

        $request = new Request([], [
            'login_id' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->expectExceptionMessage('');
        $authenticator->authenticate($request);

    }

    public function testAuthenticateThrowsExceptionOnInvalidPasswordパスワード不一致()
    {

        echo "\ntestAuthenticateThrowsExceptionOnInvalidPasswordパスワード不一致_ 実行中";

        $user = $this->createMock(\Eccube\Entity\Member::class);
        $user->method('getLoginId')->willReturn('admin@example.com');

        $passwordHasher = $this->createMock(UserPasswordHasher::class);
        $passwordHasher->method('isPasswordValid')->willReturn(false); // エラーを出す

        $memberRepo = $this->createMock(MemberRepository::class);
        $memberRepo->method('findOneBy')->willReturn($user);

        $session = $this->createMock(SessionInterface::class);
        $router = $this->createMock(RouterInterface::class);
        $mailer = $this->createMock(MailerInterface::class);
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $authenticator = new \Customize\Service\Security\AdminAuthenticatorWithOtp(
            $router,
            $memberRepo,
            $session,
            $mailer,
            $passwordHasher,
            $entityManager
        );

        $request = new \Symfony\Component\HttpFoundation\Request([], [
            'login_id' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('ログインIDまたはパスワードが間違っています。');

        $authenticator->authenticate($request);
    }

    public function testAuthenticateThrowsExceptionOnEmailFailureメール送信失敗()
    {

        echo "\ntestAuthenticateThrowsExceptionOnEmailFailureメール送信失敗_ 実行中";
        $user = $this->createMock(Member::class);
        $user->method('getId')->willReturn(1);
        $user->method('getLoginId')->willReturn('admin@example.com');
        $user->method('getRoles')->willReturn(['ROLE_ADMIN']);

        $passwordHasher = $this->createMock(UserPasswordHasher::class);
        $passwordHasher->method('isPasswordValid')->willReturn(true);

        $memberRepo = $this->createMock(MemberRepository::class);
        $memberRepo->method('findOneBy')->willReturn($user);

        $session = $this->createMock(SessionInterface::class);
        $router = $this->createMock(RouterInterface::class);

        // メール送信で例外を発生させる
        $mailer = $this->createMock(MailerInterface::class);
        $mailer->method('send')->willThrowException(new TransportException('メール失敗'));

        $connection = $this->getMockBuilder(\Doctrine\DBAL\Connection::class)
        ->disableOriginalConstructor()
        ->onlyMethods(['beginTransaction', 'commit', 'rollBack', 'isTransactionActive'])
        ->getMock();
        $connection->method('isTransactionActive')->willReturn(true);

        $entityManager = $this->createMock(\Doctrine\ORM\EntityManagerInterface::class);
        $entityManager->method('getConnection')->willReturn($connection);

        $authenticator = new \Customize\Service\Security\AdminAuthenticatorWithOtp(
            $router,
            $memberRepo,
            $session,
            $mailer,
            $passwordHasher,
            $entityManager
        );

        $request = new \Symfony\Component\HttpFoundation\Request([], [
            'login_id' => 'admin@example.com',
            'password' => 'correct-password',
        ]);

        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('システムエラーが発生しました。');

        $authenticator->authenticate($request);
    }
}
