<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbOrder
 *
 * @ORM\Table(name="dtb_order", uniqueConstraints={@ORM\UniqueConstraint(name="dtb_order_pre_order_id_idx", columns={"pre_order_id"})}, indexes={@ORM\Index(name="IDX_1D66D8079395C3F3", columns={"customer_id"}), @ORM\Index(name="IDX_1D66D807F92F3E70", columns={"country_id"}), @ORM\Index(name="IDX_1D66D807E171EF5F", columns={"pref_id"}), @ORM\Index(name="IDX_1D66D8075A2DB2A0", columns={"sex_id"}), @ORM\Index(name="IDX_1D66D807BE04EA9", columns={"job_id"}), @ORM\Index(name="IDX_1D66D8074C3A3BB", columns={"payment_id"}), @ORM\Index(name="IDX_1D66D8074FFA550E", columns={"device_type_id"}), @ORM\Index(name="IDX_1D66D807D7707B45", columns={"order_status_id"}), @ORM\Index(name="dtb_order_email_idx", columns={"email"}), @ORM\Index(name="dtb_order_order_date_idx", columns={"order_date"}), @ORM\Index(name="dtb_order_payment_date_idx", columns={"payment_date"}), @ORM\Index(name="dtb_order_update_date_idx", columns={"update_date"}), @ORM\Index(name="dtb_order_order_no_idx", columns={"order_no"})})
 * @ORM\Entity
 */
class DtbOrder
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
     * @ORM\Column(name="pre_order_id", type="string", length=255, nullable=true)
     */
    private $preOrderId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="order_no", type="string", length=255, nullable=true)
     */
    private $orderNo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="string", length=4000, nullable=true)
     */
    private $message;

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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth", type="datetime", nullable=true)
     */
    private $birth;

    /**
     * @var string
     *
     * @ORM\Column(name="subtotal", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $subtotal = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $discount = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_fee_total", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $deliveryFeeTotal = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="charge", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $charge = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="tax", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $tax = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $total = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="payment_total", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $paymentTotal = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true)
     */
    private $paymentMethod;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="string", length=4000, nullable=true)
     */
    private $note;

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
     * @ORM\Column(name="order_date", type="datetime", nullable=true)
     */
    private $orderDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="payment_date", type="datetime", nullable=true)
     */
    private $paymentDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="currency_code", type="string", length=255, nullable=true)
     */
    private $currencyCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="complete_message", type="text", length=0, nullable=true)
     */
    private $completeMessage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="complete_mail_message", type="text", length=0, nullable=true)
     */
    private $completeMailMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="add_point", type="decimal", precision=12, scale=0, nullable=false)
     */
    private $addPoint = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="use_point", type="decimal", precision=12, scale=0, nullable=false)
     */
    private $usePoint = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="order_status_id", type="smallint", nullable=true, options={"unsigned"=true})
     */
    private $orderStatusId;

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
     * @var \MtbJob
     *
     * @ORM\ManyToOne(targetEntity="MtbJob")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     */
    private $job;

    /**
     * @var \DtbCustomer
     *
     * @ORM\ManyToOne(targetEntity="DtbCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \MtbSex
     *
     * @ORM\ManyToOne(targetEntity="MtbSex")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sex_id", referencedColumnName="id")
     * })
     */
    private $sex;

    /**
     * @var \MtbDeviceType
     *
     * @ORM\ManyToOne(targetEntity="MtbDeviceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="device_type_id", referencedColumnName="id")
     * })
     */
    private $deviceType;

    /**
     * @var \DtbPayment
     *
     * @ORM\ManyToOne(targetEntity="DtbPayment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     * })
     */
    private $payment;


}
