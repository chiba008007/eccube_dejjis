<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbShipping
 *
 * @ORM\Table(name="dtb_shipping", indexes={@ORM\Index(name="IDX_2EBD22CE8D9F6D38", columns={"order_id"}), @ORM\Index(name="IDX_2EBD22CEF92F3E70", columns={"country_id"}), @ORM\Index(name="IDX_2EBD22CEE171EF5F", columns={"pref_id"}), @ORM\Index(name="IDX_2EBD22CE12136921", columns={"delivery_id"}), @ORM\Index(name="IDX_2EBD22CE61220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbShipping
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
     * @ORM\Column(name="name01", type="string", length=255, nullable=false)
     */
    private $name01;

    /**
     * @var string
     *
     * @ORM\Column(name="name02", type="string", length=255, nullable=false)
     */
    private $name02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kana01", type="string", length=255, nullable=true)
     */
    private $kana01;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kana02", type="string", length=255, nullable=true)
     */
    private $kana02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="company_name", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_number", type="string", length=14, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code", type="string", length=8, nullable=true)
     */
    private $postalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addr01", type="string", length=255, nullable=true)
     */
    private $addr01;

    /**
     * @var string|null
     *
     * @ORM\Column(name="addr02", type="string", length=255, nullable=true)
     */
    private $addr02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_name", type="string", length=255, nullable=true)
     */
    private $deliveryName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="time_id", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $timeId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_time", type="string", length=255, nullable=true)
     */
    private $deliveryTime;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="delivery_date", type="datetime", nullable=true)
     */
    private $deliveryDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="shipping_date", type="datetime", nullable=true)
     */
    private $shippingDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tracking_number", type="string", length=255, nullable=true)
     */
    private $trackingNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="string", length=4000, nullable=true)
     */
    private $note;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=true, options={"unsigned"=true})
     */
    private $sortNo;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="mail_send_date", type="datetime", nullable=true)
     */
    private $mailSendDate;

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
     * @var \DtbDelivery
     *
     * @ORM\ManyToOne(targetEntity="DtbDelivery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="delivery_id", referencedColumnName="id")
     * })
     */
    private $delivery;

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


}
