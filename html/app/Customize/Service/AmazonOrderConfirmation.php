<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\AmazonOrderConfirmations;
use Psr\Log\LoggerInterface;

class AmazonOrderConfirmation
{
    private $entityManager;

    private LoggerInterface $logger;

    public $requestId;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function createSession(array $params)
    {
        try {
            $amazon = new AmazonOrderConfirmations();
            $amazon->setConfirmId($params[ 'confirm_id' ]);
            $amazon->setOrderId($params[ 'order_id' ]);
            $amazon->setNoticeDate(new \DateTime($params[ 'notice_date' ]));
            $amazon->setTotalAmount($params[ 'total_amount' ]);
            $amazon->setTotalTax($params[ 'total_tax' ]);
            $amazon->setTotalShipping($params[ 'total_shipping' ]);
            $amazon->setRawCxml($params[ 'raw_cxml' ]);
            $now = new \DateTime();
            $amazon->setReceivedAt($now);
            $amazon->setCreatedAt($now);
            $amazon->setUpdatedAt($now);

            $this->entityManager->persist($amazon);
            $this->entityManager->flush();

            return $amazon;
        } catch (\Throwable $e) {
            $this->logger->debug('登録処理失敗'.$e);
            return null;
        }
    }



}
