<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Customize\Entity\AmazonOrderConfirmations;

/**
 * AmazonOrderConfirmationItems
 *
 * @ORM\Table(name="amazon_order_confirmation_items", indexes={@ORM\Index(name="IDX_CONFIRMATION_REQUEST", columns={"confirmation_request_id"})})
 * @ORM\Entity
 */
class AmazonOrderConfirmationItems
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
     * @var int
     *
     * @ORM\Column(name="line_number", type="integer", nullable=false)
     */
    private $lineNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_of_measure", type="string", length=32, nullable=false)
     */
    private $unitOfMeasure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $tax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=5, scale=2, nullable=true)
     */
    private $taxRate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shipping", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $shipping;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @var AmazonOrderConfirmations
     *
     * @ORM\ManyToOne(targetEntity=AmazonOrderConfirmations::class)
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="confirmation_request_id", referencedColumnName="id")
     * })
     */
    private $confirmationRequest;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineNumber(): ?int
    {
        return $this->lineNumber;
    }

    public function setLineNumber(int $lineNumber): self
    {
        $this->lineNumber = $lineNumber;
        return $this;
    }

    public function getQuantity(): ?int
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

    public function setUnitOfMeasure(string $unitOfMeasure): self
    {
        $this->unitOfMeasure = $unitOfMeasure;
        return $this;
    }

    public function getTax(): ?string
    {
        return $this->tax;
    }

    public function setTax(?string $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function getTaxRate(): ?string
    {
        return $this->taxRate;
    }

    public function setTaxRate(?string $taxRate): self
    {
        $this->taxRate = $taxRate;
        return $this;
    }

    public function getShipping(): ?string
    {
        return $this->shipping;
    }

    public function setShipping(?string $shipping): self
    {
        $this->shipping = $shipping;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

    public function getConfirmationRequest(): ?AmazonOrderConfirmations
    {
        return $this->confirmationRequest;
    }

    public function setConfirmationRequest(?AmazonOrderConfirmations $confirmationRequest): self
    {
        $this->confirmationRequest = $confirmationRequest;
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
