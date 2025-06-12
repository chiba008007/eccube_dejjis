<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Customize\Entity\AmazonOrderRequests;

/**
 * AmazonOrderRequestItems
 *
 * @ORM\Table(name="amazon_order_request_items", indexes={@ORM\Index(name="request_id", columns={"request_id"})})
 * @ORM\Entity
 */
class AmazonOrderRequestItems
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
     * @var int|null
     *
     * @ORM\Column(name="line_number", type="integer", nullable=true, options={"comment"="明細行番号（ItemOut lineNumber）"})
     */
    private $lineNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="supplier_part_id", type="string", length=255, nullable=true, options={"comment"="商品ID（SupplierPartID）"})
     */
    private $supplierPartId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="supplier_part_auxiliary_id", type="string", length=255, nullable=true, options={"comment"="商品補助ID（SupplierPartAuxiliaryID）"})
     */
    private $supplierPartAuxiliaryId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true, options={"comment"="数量（ItemOut quantity）"})
     */
    private $quantity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit_price", type="decimal", precision=15, scale=2, nullable=true, options={"comment"="単価（ItemDetail/UnitPrice/Money）"})
     */
    private $unitPrice;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true, options={"comment"="商品説明（ItemDetail/Description）"})
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="manufacturer_part_id", type="string", length=255, nullable=true, options={"comment"="メーカー型番（ManufacturerPartID）"})
     */
    private $manufacturerPartId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="manufacturer_name", type="string", length=255, nullable=true, options={"comment"="メーカー名（ManufacturerName）"})
     */
    private $manufacturerName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="category", type="string", length=64, nullable=true, options={"comment"="カテゴリ（Extrinsic/category）"})
     */
    private $category;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sub_category", type="string", length=64, nullable=true, options={"comment"="サブカテゴリ（Extrinsic/subCategory）"})
     */
    private $subCategory;

    /**
     * @var string|null
     *
     * @ORM\Column(name="item_condition", type="string", length=32, nullable=true, options={"comment"="商品状態（Extrinsic/itemCondition）"})
     */
    private $itemCondition;

    /**
     * @var string|null
     *
     * @ORM\Column(name="detail_page_url", type="string", length=512, nullable=true, options={"comment"="商品詳細URL（Extrinsic/detailPageURL）"})
     */
    private $detailPageUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ean", type="string", length=64, nullable=true, options={"comment"="EANコード（Extrinsic/ean）"})
     */
    private $ean;

    /**
     * @var string|null
     *
     * @ORM\Column(name="preference", type="string", length=32, nullable=true, options={"comment"="preference（Extrinsic/preference）"})
     */
    private $preference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="レコード作成日時"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP","comment"="レコード更新日時"})
     */
    private $updatedAt;

    /**
     * @var \Customize\Entity\AmazonOrderRequests
     *
     * @ORM\ManyToOne(targetEntity="Customize\Entity\AmazonOrderRequests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="request_id", referencedColumnName="id")
     * })
     */
    private $request;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineNumber(): ?int
    {
        return $this->lineNumber;
    }

    public function setLineNumber(?int $lineNumber): self
    {
        $this->lineNumber = $lineNumber;
        return $this;
    }

    public function getSupplierPartId(): ?string
    {
        return $this->supplierPartId;
    }

    public function setSupplierPartId(?string $supplierPartId): self
    {
        $this->supplierPartId = $supplierPartId;
        return $this;
    }

    public function getSupplierPartAuxiliaryId(): ?string
    {
        return $this->supplierPartAuxiliaryId;
    }

    public function setSupplierPartAuxiliaryId(?string $supplierPartAuxiliaryId): self
    {
        $this->supplierPartAuxiliaryId = $supplierPartAuxiliaryId;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;
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

    public function getManufacturerPartId(): ?string
    {
        return $this->manufacturerPartId;
    }

    public function setManufacturerPartId(?string $manufacturerPartId): self
    {
        $this->manufacturerPartId = $manufacturerPartId;
        return $this;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function setManufacturerName(?string $manufacturerName): self
    {
        $this->manufacturerName = $manufacturerName;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getSubCategory(): ?string
    {
        return $this->subCategory;
    }

    public function setSubCategory(?string $subCategory): self
    {
        $this->subCategory = $subCategory;
        return $this;
    }

    public function getItemCondition(): ?string
    {
        return $this->itemCondition;
    }

    public function setItemCondition(?string $itemCondition): self
    {
        $this->itemCondition = $itemCondition;
        return $this;
    }

    public function getDetailPageUrl(): ?string
    {
        return $this->detailPageUrl;
    }

    public function setDetailPageUrl(?string $detailPageUrl): self
    {
        $this->detailPageUrl = $detailPageUrl;
        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(?string $ean): self
    {
        $this->ean = $ean;
        return $this;
    }

    public function getPreference(): ?string
    {
        return $this->preference;
    }

    public function setPreference(?string $preference): self
    {
        $this->preference = $preference;
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

    public function getRequest(): ?AmazonOrderRequests
    {
        return $this->request;
    }

    public function setRequest(?AmazonOrderRequests $request): self
    {
        $this->request = $request;
        return $this;
    }
}
