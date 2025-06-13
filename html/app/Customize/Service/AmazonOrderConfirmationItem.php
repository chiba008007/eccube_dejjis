<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\AmazonOrderConfirmationItems;
use Psr\Log\LoggerInterface;

class AmazonOrderConfirmationItem
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
            $amazonItem = new AmazonOrderConfirmationItems();
            $amazonItem->setLineNumber($params[ 'line_number' ]);
            $amazonItem->setQuantity($params[ 'quantity' ]);
            $amazonItem->setUnitOfMeasure($params[ 'unit_of_measure' ]);
            $amazonItem->setTax($params[ 'tax' ]);
            $amazonItem->setTaxRate($params[ 'tax_rate' ]);
            $amazonItem->setShipping($params[ 'shipping' ]);
            $amazonItem->setDescription($params[ 'description' ]);
            $amazonItem->setComments($params[ 'comments' ]);
            $now = new \DateTime();
            $amazonItem->setCreatedAt($now);
            $amazonItem->setUpdatedAt($now);

            if (!empty($params['request'])) {
                $amazonItem->setConfirmationRequest($params['request']);
            } else {
                throw new \Exception('親OrderRequestエンティティが渡されていません');
            }

            $this->entityManager->persist($amazonItem);
            $this->entityManager->flush();

            return $amazonItem;
        } catch (\Throwable $e) {
            $this->logger->debug('登録処理失敗'.$e);
            return null;
        }
    }



}
