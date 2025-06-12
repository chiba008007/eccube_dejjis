<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbProductClass
 *
 * @ORM\Table(name="dtb_product_class", indexes={@ORM\Index(name="IDX_1A11D1BA4584665A", columns={"product_id"}), @ORM\Index(name="IDX_1A11D1BAB0524E01", columns={"sale_type_id"}), @ORM\Index(name="IDX_1A11D1BA248D128", columns={"class_category_id1"}), @ORM\Index(name="IDX_1A11D1BA9B418092", columns={"class_category_id2"}), @ORM\Index(name="IDX_1A11D1BABA4269E", columns={"delivery_duration_id"}), @ORM\Index(name="IDX_1A11D1BA61220EA6", columns={"creator_id"}), @ORM\Index(name="dtb_product_class_price02_idx", columns={"price02"}), @ORM\Index(name="dtb_product_class_stock_stock_unlimited_idx", columns={"stock", "stock_unlimited"})})
 * @ORM\Entity
 */
class DtbProductClass
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="product_code", type="string", length=255, nullable=true)
     */
    private $productCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="stock", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $stock;

    /**
     * @var bool
     *
     * @ORM\Column(name="stock_unlimited", type="boolean", nullable=false)
     */
    private $stockUnlimited = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="sale_limit", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $saleLimit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price01", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $price01;

    /**
     * @var string
     *
     * @ORM\Column(name="price02", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $price02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_fee", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $deliveryFee;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $visible = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false)
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=false)
     */
    private $updateDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency_code", type="string", length=255, nullable=true)
     */
    private $currencyCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_rate", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $pointRate;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbDeliveryDuration
     *
     * @ORM\ManyToOne(targetEntity="DtbDeliveryDuration")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="delivery_duration_id", referencedColumnName="id")
     * })
     */
    private $deliveryDuration;

    /**
     * @var \MtbSaleType
     *
     * @ORM\ManyToOne(targetEntity="MtbSaleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sale_type_id", referencedColumnName="id")
     * })
     */
    private $saleType;

    /**
     * @var \DtbClassCategory
     *
     * @ORM\ManyToOne(targetEntity="DtbClassCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_category_id2", referencedColumnName="id")
     * })
     */
    private $classCategoryId2;

    /**
     * @var \DtbMember
     *
     * @ORM\ManyToOne(targetEntity="DtbMember")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     * })
     */
    private $creator;

    /**
     * @var \DtbProduct
     *
     * @ORM\ManyToOne(targetEntity="DtbProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \DtbClassCategory
     *
     * @ORM\ManyToOne(targetEntity="DtbClassCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_category_id1", referencedColumnName="id")
     * })
     */
    private $classCategoryId1;


}
