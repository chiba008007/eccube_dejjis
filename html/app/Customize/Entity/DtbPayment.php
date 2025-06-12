<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbPayment
 *
 * @ORM\Table(name="dtb_payment", indexes={@ORM\Index(name="IDX_7AFF628F61220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbPayment
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
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true)
     */
    private $paymentMethod;

    /**
     * @var string|null
     *
     * @ORM\Column(name="charge", type="decimal", precision=12, scale=2, nullable=true, options={"default"="0.00"})
     */
    private $charge = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="rule_max", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $ruleMax;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=true, options={"unsigned"=true})
     */
    private $sortNo;

    /**
     * @var bool
     *
     * @ORM\Column(name="fixed", type="boolean", nullable=false, options={"default"="1"})
     */
    private $fixed = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_image", type="string", length=255, nullable=true)
     */
    private $paymentImage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rule_min", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $ruleMin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="method_class", type="string", length=255, nullable=true)
     */
    private $methodClass;

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
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DtbDelivery", mappedBy="payment")
     */
    private $delivery = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->delivery = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
