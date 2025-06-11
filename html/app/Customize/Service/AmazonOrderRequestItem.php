<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\AmazonOrderRequestItems;
use Psr\Log\LoggerInterface;

class AmazonOrderRequestItem
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
            $amazonItem  = new AmazonOrderRequestItems();
            $amazonItem->setLineNumber($params[ 'line_number' ]);
            $amazonItem->setSupplierPartId($params[ 'supplier_part_id' ]);
            $amazonItem->setSupplierPartAuxiliaryId($params[ 'supplier_part_auxiliary_id' ]);
            $amazonItem->setQuantity($params[ 'quantity' ]);
            $amazonItem->setUnitPrice($params[ 'unit_price' ]);
            $amazonItem->setManufacturerPartId($params[ 'manufacturer_part_id' ]);
            $amazonItem->setManufacturerName($params[ 'manufacturer_name' ]);
            $amazonItem->setCategory($params[ 'category' ]);
            $amazonItem->setSubCategory($params[ 'sub_category' ]);
            $amazonItem->setItemCondition($params[ 'item_condition' ]);
            $amazonItem->setDetailPageUrl($params[ 'detail_page_url' ]);
            $amazonItem->setEan($params[ 'ean' ]);
            $amazonItem->setPreference($params[ 'preference' ]);
            $now = new \DateTime();
            $amazonItem->setCreatedAt($now);
            $amazonItem->setUpdatedAt($now);


            if (!empty($params['request'])) {
                $amazonItem->setRequest($params['request']);
            } else {
                throw new \Exception('親OrderRequestエンティティが渡されていません');
            }
            $this->entityManager->persist($amazonItem);


            return $amazonItem;
        } catch (\Throwable $e) {
            $this->logger->debug('登録処理失敗'.$e);
            return null;
        }
    }

    public function getSubCategory($itemParams, $pattern)
    {

        $subCategory = null;
        if (isset($itemParams->ItemDetail->Extrinsic)) {
            foreach ($itemParams->ItemDetail->Extrinsic as $extrinsic) {
                if ((string)$extrinsic['name'] === $pattern) {
                    $subCategory = (string)$extrinsic;
                    break;
                }
            }
        }
        return $subCategory;
    }
}
