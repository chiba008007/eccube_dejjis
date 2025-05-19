<?php

namespace Customize\Event;

// TemplateEvent:テンプレートを差し込んだり変数を追加したりできる
use Eccube\Event\TemplateEvent;
// EventSubscriberInterface:どのイベントに対して反応するかを定義
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

// 管理画面メニューの表示処理にフックして、メニューを追加する役割
class AdminMenuEventSubscriber implements EventSubscriberInterface
{
    // このクラスがどのイベントを購読するかを教えるメソッド
    public static function getSubscribedEvents(): array
    {
        // EC-Cubeが管理画面メニューを出力
        return [
          'admin.main.nav' => 'onAdminMainNav'
        ];
    }

    public function onAdminMainNav(TemplateEvent $event)
    {
        file_put_contents('/tmp/menu_test.log', "★ 呼ばれた\n", FILE_APPEND);
        $event->addSnippet('Customize/admin/_menu_amazon.twig');
    }
}
