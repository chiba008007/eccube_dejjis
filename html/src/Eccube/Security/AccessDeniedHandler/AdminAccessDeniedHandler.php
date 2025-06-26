<?php

namespace Eccube\Security\AccessDeniedHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class AdminAccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private $router;
    private $security;

    public function __construct(RouterInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function handle(Request $request, \Symfony\Component\Security\Core\Exception\AccessDeniedException $accessDeniedException): ?Response
    {
        // 未ログインならログイン画面へ、ログイン済みなら403
        if (null === $this->security->getUser()) {
            return new RedirectResponse($this->router->generate('admin_login'));
        }

        return new Response('Access Denied', 403);
    }
}
