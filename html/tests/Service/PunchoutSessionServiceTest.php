<?php

namespace Tests\Service;

use PHPUnit\Framework\TestCase;
use Customize\Service\PunchoutSessionService;
use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\DtbPunchoutSession;

class PunchoutSessionServiceTest extends TestCase
{
    private $entityManager;
    private $service;

    public function testCreateSessionSuccess()
    {
        $params = [
            'buyer_cookie' => 'SAMPLE_BUYER_COOKIE',
            'request_xml' => '<xml>dummy</xml>',
            'user_email' => 'sample@example.com',
            'user_first_name' => 'テスト',
            'user_last_name' => '太郎',
            'start_date' => new \DateTime('2025-06-05 16:00:00'),
            'country' => 'JP',
        ];

    }
}
