<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmazonOrderRequests
 *
 * @ORM\Table(name="amazon_order_requests")
 * @ORM\Entity
 */
class AmazonOrderRequests
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="主キー"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payload_id", type="string", length=255, nullable=true, options={"comment"="cXMLルートのpayloadID"})
     */
    private $payloadId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true, options={"comment"="OrderRequestHeaderのorderID"})
     */
    private $orderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="buyer_id", type="string", length=255, nullable=true, options={"comment"="発注者（From/Credential/Identity）"})
     */
    private $buyerId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=15, scale=2, nullable=true, options={"comment"="注文合計金額（OrderRequestHeader/Total/Money）"})
     */
    private $totalAmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency", type="string", length=8, nullable=true, options={"comment"="注文通貨（OrderRequestHeader/Total/Money/currency）"})
     */
    private $currency;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=true, options={"default"="new","comment"="処理状況（new/processed/error等）"})
     */
    private $status = 'new';

    /**
     * @var string
     *
     * @ORM\Column(name="raw_cxml", type="text", length=0, nullable=false, options={"comment"="受信した生cXML電文"})
     */
    private $rawCxml;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="レコード作成日時"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="レコード更新日時"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';


    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId): self
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getBuyerId(): ?string
    {
        return $this->buyerId;
    }

    public function setBuyerId(?string $buyerId): self
    {
        $this->buyerId = $buyerId;
        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getRawCxml(): ?string
    {
        return $this->rawCxml;
    }

    public function setRawCxml(string $rawCxml): self
    {
        $this->rawCxml = $rawCxml;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}
