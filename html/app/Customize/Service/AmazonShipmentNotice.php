<?php

namespace Customize\Service;

use Doctrine\ORM\EntityManagerInterface;
use Customize\Entity\AmazonShipNotices;
use Psr\Log\LoggerInterface;

class AmazonShipmentNotice
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
            $amazon = new AmazonShipNotices();
            $amazon->setShipmentId($params['shipment_id']);
            $amazon->setOrderId($params['order_id']);
            $amazon->setNoticeDate(new \DateTime($params['notice_date']));
            $amazon->setShipmentDate(!empty($params['shipment_date']) ? new \DateTime($params['shipment_date']) : null);
            $amazon->setDeliveryDate(!empty($params['delivery_date']) ? new \DateTime($params['delivery_date']) : null);
            $amazon->setShipmentType($params['shipment_type'] ?? null);
            $amazon->setCarrierName($params['carrier_name'] ?? null);
            $amazon->setTrackingNumber($params['tracking_number'] ?? null);
            $amazon->setPackageRangeBegin($params['package_range_begin'] ?? null);
            $amazon->setPackageRangeEnd($params['package_range_end'] ?? null);
            $amazon->setPayloadId($params['payload_id'] ?? null);
            $amazon->setRawCxml($params['raw_cxml']);
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
