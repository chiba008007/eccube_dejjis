<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbOrderItem
 *
 * @ORM\Table(name="dtb_order_item", indexes={@ORM\Index(name="IDX_A0C8C3ED8D9F6D38", columns={"order_id"}), @ORM\Index(name="IDX_A0C8C3ED4584665A", columns={"product_id"}), @ORM\Index(name="IDX_A0C8C3ED21B06187", columns={"product_class_id"}), @ORM\Index(name="IDX_A0C8C3ED4887F3F8", columns={"shipping_id"}), @ORM\Index(name="IDX_A0C8C3ED1BD5C574", columns={"rounding_type_id"}), @ORM\Index(name="IDX_A0C8C3ED84042C99", columns={"tax_type_id"}), @ORM\Index(name="IDX_A0C8C3EDA2505856", columns={"tax_display_type_id"}), @ORM\Index(name="IDX_A0C8C3EDCAD13EAD", columns={"order_item_type_id"})})
 * @ORM\Entity
 */
class DtbOrderItem
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
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="product_code", type="string", length=255, nullable=true)
     */
    private $productCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_name1", type="string", length=255, nullable=true)
     */
    private $className1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_name2", type="string", length=255, nullable=true)
     */
    private $className2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_category_name1", type="string", length=255, nullable=true)
     */
    private $classCategoryName1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class_category_name2", type="string", length=255, nullable=true)
     */
    private $classCategoryName2;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $price = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $quantity = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tax", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $tax = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tax_rate", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $taxRate = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="tax_adjust", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $taxAdjust = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="tax_rule_id", type="smallint", nullable=true, options={"unsigned"=true})
     */
    private $taxRuleId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency_code", type="string", length=255, nullable=true)
     */
    private $currencyCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="processor_name", type="string", length=255, nullable=true)
     */
    private $processorName;

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
     * @var \DtbProduct
     *
     * @ORM\ManyToOne(targetEntity="DtbProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \DtbProductClass
     *
     * @ORM\ManyToOne(targetEntity="DtbProductClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="id")
     * })
     */
    private $productClass;

    /**
     * @var \MtbRoundingType
     *
     * @ORM\ManyToOne(targetEntity="MtbRoundingType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rounding_type_id", referencedColumnName="id")
     * })
     */
    private $roundingType;

    /**
     * @var \DtbShipping
     *
     * @ORM\ManyToOne(targetEntity="DtbShipping")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shipping_id", referencedColumnName="id")
     * })
     */
    private $shipping;

    /**
     * @var \MtbOrderItemType
     *
     * @ORM\ManyToOne(targetEntity="MtbOrderItemType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_item_type_id", referencedColumnName="id")
     * })
     */
    private $orderItemType;

    /**
     * @var \MtbTaxDisplayType
     *
     * @ORM\ManyToOne(targetEntity="MtbTaxDisplayType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tax_display_type_id", referencedColumnName="id")
     * })
     */
    private $taxDisplayType;

    /**
     * @var \DtbOrder
     *
     * @ORM\ManyToOne(targetEntity="DtbOrder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var \MtbTaxType
     *
     * @ORM\ManyToOne(targetEntity="MtbTaxType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tax_type_id", referencedColumnName="id")
     * })
     */
    private $taxType;


}
