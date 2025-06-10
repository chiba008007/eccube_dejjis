<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\DtbPunchoutSession;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PunchoutSessionService
{
    private $entityManager;

    private LoggerInterface $logger;

    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
    }

    public function createSession(array $params): bool
    {
        try {
            $session = new DtbPunchoutSession();
            // テスト用でtime()をつけている
            $session->setBuyerCookie($params['buyer_cookie'].time());
            $session->setSessionId($params['session_id']);
            $session->setRequestXml($params['request_xml']);
            $session->setBrowserPostUrl($params['browser_post_url']);
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

    public function replacePlaceholder($template, $sessionId)
    {

        $request = $this->requestStack->getCurrentRequest();
        $host = $request->getHost();        // 例: example.com
        $scheme = $request->getScheme();    // 例: http または https
        $domain = $scheme . '://' . $host;

        $payloadId = date('Ymd\THis') . '-' . uniqid() . '@buyer.com';
        $timestamp = (new \DateTime())->format('c');
        $startUrl = $domain."/punchout/session/{$sessionId}";

        return str_replace(
            ['{{payload_id}}', '{{timestamp}}', '{{start_url}}'],
            [$payloadId, $timestamp, $startUrl],
            $template
        );
    }

    public function findBySessionId($sessionId): ?DtbPunchoutSession
    {
        return $this->entityManager->getRepository(DtbPunchoutSession::class)->findOneBy([ 'sessionId' => $sessionId ]);
    }
}
