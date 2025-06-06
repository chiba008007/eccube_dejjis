<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\DtbPunchoutSession;
use Psr\Log\LoggerInterface;

class PunchoutSessionService
{
    private $entityManager;

    private LoggerInterface $logger;


    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function createSession(array $params): bool
    {
        try {
            $session = new DtbPunchoutSession();
            $session->setBuyerCookie($params['buyer_cookie'].time());
            $session->setRequestXml($params['request_xml']);
            $session->setUserEmail($params['user_email'] ?? null);
            $session->setUserFirstName($params['user_first_name'] ?? null);
            $session->setUserLastName($params['user_last_name'] ?? null);
            $session->setStartDate(new \DateTime($params['start_date']));
            $session->setCountry($params['country'] ?? null);
            $session->setBusinessUnit($params['business_unit'] ?? null);
            $session->setShipToJson($params['ship_to_json'] ?? null);
            $session->setExpireAt($params['expire_at'] ?? null);
            $session->setIsUsed($params['is_used'] ?? false);
            $now = new \DateTime();
            $session->setCreateDate($now);
            $session->setUpdateDate($now);


            $this->entityManager->persist($session);
            $this->entityManager->flush();
            return true;
        } catch (\Throwable $e) {
            $this->logger->debug('登録処理失敗'.$e);
            return false;
        }
    }
}
