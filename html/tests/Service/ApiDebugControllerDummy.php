<?php

namespace Tests\Service;

use Tests\TestCase\BaseEccubeTestCase;
use Eccube\Entity\Member;

class ApiDebugControllerDummy extends BaseEccubeTestCase
{
    public function testApiDebugCxmlTestRequestReturnsValidResponse()
    {

        $client = $this->getClient();

        // 管理ユーザーの取得（EntityManager経由）
        $em = static::getContainer()->get('doctrine')->getManager();
        $admin = $em->getRepository(Member::class)->findOneBy([]);
        $this->assertNotNull($admin, '管理ユーザーがDBに存在しません。');

        $crawler = $client->request('GET', '/admin/');
        $crawler = $client->followRedirect();
        $form = $crawler->selectButton('ログイン')->form();
        $client->submit($form, [
            'login_id' => 'admin',
            'password' => 'password',
        ]);
        $client->followRedirect();

        // 管理画面プレフィックスを取得（デフォルトは /admin）

        $client->request('GET', "/admin/api/debug?api_type=cxml_TEST");

        $this->assertStringNotContainsString('ダッシュボード', $client->getResponse()->getContent(), 'ログインに失敗しています');

        $this->assertResponseIsSuccessful();

        // HTMLに BuyerCookie という文言が含まれることを確認（例示）
        $this->assertStringContainsString('BuyerCookie', $client->getResponse()->getContent());

    }
}
