<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmazonShipNotices
 *
 * @ORM\Table(name="amazon_ship_notices", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_SHIPMENT_ID", columns={"shipment_id"})})
 * @ORM\Entity
 */
class AmazonShipNotices
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="shipment_id", type="string", length=64, nullable=false, options={"comment"="Amazon配送通知ID（shipmentID）"})
     */
    private $shipmentId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notice_date", type="datetime", nullable=false, options={"comment"="通知日時"})
     */
    private $noticeDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="shipment_date", type="datetime", nullable=true, options={"comment"="出荷日"})
     */
    private $shipmentDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="delivery_date", type="datetime", nullable=true, options={"comment"="納品予定日"})
     */
    private $deliveryDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shipment_type", type="string", length=32, nullable=true, options={"comment"="出荷タイプ（例：actual）"})
     */
    private $shipmentType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carrier_name", type="string", length=64, nullable=true, options={"comment"="配送会社名"})
     */
    private $carrierName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tracking_number", type="string", length=64, nullable=true, options={"comment"="送り状番号（ShipmentIdentifier）"})
     */
    private $trackingNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="package_range_begin", type="integer", nullable=true, options={"comment"="荷物番号（開始）"})
     */
    private $packageRangeBegin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="package_range_end", type="integer", nullable=true, options={"comment"="荷物番号（終了）"})
     */
    private $packageRangeEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="order_id", type="string", length=64, nullable=false, options={"comment"="注文ID（AmazonのorderID）"})
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payload_id", type="string", length=255, nullable=true, options={"comment"="payloadID（照合用）"})
     */
    private $payloadId;

    /**
     * @var string
     *
     * @ORM\Column(name="raw_cxml", type="text", length=0, nullable=false, options={"comment"="受信したcXML生データ"})
     */
    private $rawCxml;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"comment"="登録日時"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"comment"="更新日時"})
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShipmentId(): string
    {
        return $this->shipmentId;
    }

    public function setShipmentId(string $shipmentId): self
    {
        $this->shipmentId = $shipmentId;
        return $this;
    }

    public function getNoticeDate(): \DateTime
    {
        return $this->noticeDate;
    }

    public function setNoticeDate(\DateTime $noticeDate): self
    {
        $this->noticeDate = $noticeDate;
        return $this;
    }

    public function getShipmentDate(): ?\DateTime
    {
        return $this->shipmentDate;
    }

    public function setShipmentDate(?\DateTime $shipmentDate): self
    {
        $this->shipmentDate = $shipmentDate;
        return $this;
    }

    public function getDeliveryDate(): ?\DateTime
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTime $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;
        return $this;
    }

    public function getShipmentType(): ?string
    {
        return $this->shipmentType;
    }

    public function setShipmentType(?string $shipmentType): self
    {
        $this->shipmentType = $shipmentType;
        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(?string $carrierName): self
    {
        $this->carrierName = $carrierName;
        return $this;
    }

    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    public function setTrackingNumber(?string $trackingNumber): self
    {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }

    public function getPackageRangeBegin(): ?int
    {
        return $this->packageRangeBegin;
    }

    public function setPackageRangeBegin(?int $packageRangeBegin): self
    {
        $this->packageRangeBegin = $packageRangeBegin;
        return $this;
    }

    public function getPackageRangeEnd(): ?int
    {
        return $this->packageRangeEnd;
    }

    public function setPackageRangeEnd(?int $packageRangeEnd): self
    {
        $this->packageRangeEnd = $packageRangeEnd;
        return $this;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getPayloadId(): ?string
    {
        return $this->payloadId;
    }

    public function setPayloadId(?string $payloadId): self
    {
        $this->payloadId = $payloadId;
        return $this;
    }

    public function getRawCxml(): string
    {
        return $this->rawCxml;
    }

    public function setRawCxml(string $rawCxml): self
    {
        $this->rawCxml = $rawCxml;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
