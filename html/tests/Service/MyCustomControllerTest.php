<?php

namespace Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyCustomControllerTest extends WebTestCase
{
    public function testMyCustomControllerSampleTest()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/custom/sampleTest');
        $this->assertResponseIsSuccessful(); // ステータスコード 200
        $this->assertStringContainsString('Hello, EC-Cube', $client->getResponse()->getContent());
    }
}
