<?php

namespace Tests\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\DBAL\Connection;

abstract class BaseEccubeTestCase extends WebTestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $conn = static::getContainer()->get(Connection::class);
        $conn->executeQuery("UPDATE dtb_plugin SET enabled = 1 WHERE code = 'ApiDebugPlugin'");
    }
    protected function getClient()
    {
        return $this->client;
    }
}
