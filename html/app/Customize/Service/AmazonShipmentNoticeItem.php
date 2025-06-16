<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\AmazonShipNoticeItems;
use Psr\Log\LoggerInterface;

class AmazonShipmentNoticeItem
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
            $amazonItem = new AmazonShipNoticeItems();
            $amazonItem->setLineNumber($params['line_number']);
            $amazonItem->setQuantity($params['quantity']);
            $amazonItem->setUnitOfMeasure($params['unit_of_measure'] ?? null);
            $now = new \DateTime();
            $amazonItem->setCreatedAt($now);
            $amazonItem->setUpdatedAt($now);

            if (!empty($params['request'])) {
                $amazonItem->setShipNotice($params['request']);
            } else {
                throw new \Exception('親AmazonShipmentNoticeエンティティが渡されていません');
            }

            $this->entityManager->persist($amazonItem);

            return $amazonItem;
        } catch (\Exception $e) {
            $this->logger->debug('登録処理失敗'.$e);
            return null;
        }
    }



}
