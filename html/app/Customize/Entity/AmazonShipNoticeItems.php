<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Customize\Entity\AmazonShipNotices;

/**
 * AmazonShipNoticeItems
 *
 * @ORM\Table(name="amazon_ship_notice_items", indexes={@ORM\Index(name="IDX_SHIP_NOTICE_ID", columns={"ship_notice_id"})})
 * @ORM\Entity
 */
class AmazonShipNoticeItems
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
     * @var int
     *
     * @ORM\Column(name="line_number", type="integer", nullable=false, options={"comment"="明細行番号"})
     */
    private $lineNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false, options={"comment"="数量"})
     */
    private $quantity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_of_measure", type="string", length=32, nullable=true, options={"comment"="単位（例：EA）"})
     */
    private $unitOfMeasure;

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

    /**
     * @var AmazonShipNotices
     *
     * @ORM\ManyToOne(targetEntity="Customize\Entity\AmazonShipNotices", inversedBy="items")
     * @ORM\JoinColumn(name="ship_notice_id", referencedColumnName="id", nullable=false)
     */
    private $shipNotice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    public function setLineNumber(int $lineNumber): self
    {
        $this->lineNumber = $lineNumber;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnitOfMeasure(): ?string
    {
        return $this->unitOfMeasure;
    }

    public function setUnitOfMeasure(?string $unitOfMeasure): self
    {
        $this->unitOfMeasure = $unitOfMeasure;
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

    public function getShipNotice(): ?AmazonShipNotices
    {
        return $this->shipNotice;
    }

    public function setShipNotice(?AmazonShipNotices $shipNotice): self
    {
        $this->shipNotice = $shipNotice;
        return $this;
    }

}
