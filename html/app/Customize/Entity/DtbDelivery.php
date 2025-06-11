<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbDelivery
 *
 * @ORM\Table(name="dtb_delivery", indexes={@ORM\Index(name="IDX_3420D9FA61220EA6", columns={"creator_id"}), @ORM\Index(name="IDX_3420D9FAB0524E01", columns={"sale_type_id"})})
 * @ORM\Entity
 */
class DtbDelivery
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="service_name", type="string", length=255, nullable=true)
     */
    private $serviceName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirm_url", type="string", length=4000, nullable=true)
     */
    private $confirmUrl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sort_no", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $sortNo;

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
     * @var \MtbSaleType
     *
     * @ORM\ManyToOne(targetEntity="MtbSaleType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sale_type_id", referencedColumnName="id")
     * })
     */
    private $saleType;

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
     * @ORM\ManyToMany(targetEntity="DtbPayment", inversedBy="delivery")
     * @ORM\JoinTable(name="dtb_payment_option",
     *   joinColumns={
     *     @ORM\JoinColumn(name="delivery_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     *   }
     * )
     */
    private $payment = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payment = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
