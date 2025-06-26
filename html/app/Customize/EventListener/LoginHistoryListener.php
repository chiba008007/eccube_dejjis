<?php

namespace Customize\EventListener;

use Eccube\Event\EccubeEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Eccube\Repository\MemberRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginHistoryListener implements EventSubscriberInterface
{
    private $memberRepository;
    private $requestStack;

    public function __construct(MemberRepository $memberRepository, RequestStack $requestStack)
    {
        $this->memberRepository = $memberRepository;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => [['onLoginSuccess', 100]],
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event)
    {
        $passport = $event->getPassport();

        // ★ null チェックを追加！
        if (!$passport || !$passport->hasBadge(UserBadge::class)) {
            return;
        }

        $userName = $passport->getBadge(UserBadge::class)->getUserIdentifier();
        $Member = $this->memberRepository->findOneBy(['login_id' => $userName]);

        // ログイン履歴記録処理（省略）
    }
}
