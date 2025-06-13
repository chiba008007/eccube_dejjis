<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmazonOrderConfirmations
 *
 * @ORM\Table(name="amazon_order_confirmations", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_CONFIRM_ID", columns={"confirm_id"})})
 * @ORM\Entity
 */
class AmazonOrderConfirmations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="confirm_id", type="string", length=255, nullable=false)
     */
    private $confirmId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_id", type="string", length=255, nullable=true)
     */
    private $orderId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="notice_date", type="datetime", nullable=false)
     */
    private $noticeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $totalAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="total_tax", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $totalTax;

    /**
     * @var string
     *
     * @ORM\Column(name="total_shipping", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $totalShipping;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="received_at", type="datetime", nullable=false)
     */
    private $receivedAt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;


    /**
     * @var string
     *
     * @ORM\Column(name="raw_cxml", type="text", nullable=false, options={"comment": "受信したcXML電文の生データ"})
     */
    private $rawCxml;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfirmId(): string
    {
        return $this->confirmId;
    }

    public function setConfirmId(string $confirmId): self
    {
        $this->confirmId = $confirmId;
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

    public function getNoticeDate(): \DateTime
    {
        return $this->noticeDate;
    }

    public function setNoticeDate(\DateTime $noticeDate): self
    {
        $this->noticeDate = $noticeDate;
        return $this;
    }

    public function getTotalAmount(): string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function getTotalTax(): string
    {
        return $this->totalTax;
    }

    public function setTotalTax(string $totalTax): self
    {
        $this->totalTax = $totalTax;
        return $this;
    }

    public function getTotalShipping(): string
    {
        return $this->totalShipping;
    }

    public function setTotalShipping(string $totalShipping): self
    {
        $this->totalShipping = $totalShipping;
        return $this;
    }

    public function getReceivedAt(): \DateTime
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(\DateTime $receivedAt): self
    {
        $this->receivedAt = $receivedAt;
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

    public function getRawCxml(): ?string
    {
        return $this->rawCxml;
    }

    public function setRawCxml(string $rawCxml): self
    {
        $this->rawCxml = $rawCxml;
        return $this;
    }
}
