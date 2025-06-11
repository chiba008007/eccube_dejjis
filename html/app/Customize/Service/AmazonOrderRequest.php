<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\AmazonOrderRequests;
use Psr\Log\LoggerInterface;

class AmazonOrderRequest
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
            $amazon = new AmazonOrderRequests();
            $amazon->setPayloadId($params[ 'payload_id' ]);
            $amazon->setOrderId($params[ 'order_id' ]);
            $amazon->setBuyerId($params[ 'buyer_id' ]);
            $amazon->setTotalAmount($params[ 'total_amount' ]);
            $amazon->setCurrency($params[ 'currency' ]);
            $amazon->setStatus($params[ 'status' ]);
            $amazon->setRawCxml($params[ 'raw_cxml' ]);
            $now = new \DateTime();
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
