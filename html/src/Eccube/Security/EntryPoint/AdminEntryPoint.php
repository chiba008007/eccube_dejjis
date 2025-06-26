<?php

namespace Eccube\Security\EntryPoint;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Routing\RouterInterface;

class AdminEntryPoint implements AuthenticationEntryPointInterface
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {

        $path = $request->getPathInfo();

        // OTP入力画面はリダイレクトしない（空レスポンスなどで終了）
        if (str_starts_with($path, '/admin/verify')) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        // 未ログイン時に管理者ログインページにリダイレクト
        return new RedirectResponse($this->router->generate('admin_login'));
    }
}
