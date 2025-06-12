<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbTaxRule
 *
 * @ORM\Table(name="dtb_tax_rule", indexes={@ORM\Index(name="IDX_59F696DE21B06187", columns={"product_class_id"}), @ORM\Index(name="IDX_59F696DE61220EA6", columns={"creator_id"}), @ORM\Index(name="IDX_59F696DEF92F3E70", columns={"country_id"}), @ORM\Index(name="IDX_59F696DEE171EF5F", columns={"pref_id"}), @ORM\Index(name="IDX_59F696DE4584665A", columns={"product_id"}), @ORM\Index(name="IDX_59F696DE1BD5C574", columns={"rounding_type_id"})})
 * @ORM\Entity
 */
class DtbTaxRule
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
     * @var \DateTime
     *
     * @ORM\Column(name="apply_date", type="datetime", nullable=false)
     */
    private $applyDate;

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
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \MtbCountry
     *
     * @ORM\ManyToOne(targetEntity="MtbCountry")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var \MtbPref
     *
     * @ORM\ManyToOne(targetEntity="MtbPref")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pref_id", referencedColumnName="id")
     * })
     */
    private $pref;

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


}
