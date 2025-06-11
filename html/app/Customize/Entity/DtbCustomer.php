<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbCustomer
 *
 * @ORM\Table(name="dtb_customer", uniqueConstraints={@ORM\UniqueConstraint(name="secret_key", columns={"secret_key"})}, indexes={@ORM\Index(name="IDX_8298BBE3C00AF8A7", columns={"customer_status_id"}), @ORM\Index(name="IDX_8298BBE35A2DB2A0", columns={"sex_id"}), @ORM\Index(name="IDX_8298BBE3BE04EA9", columns={"job_id"}), @ORM\Index(name="IDX_8298BBE3F92F3E70", columns={"country_id"}), @ORM\Index(name="IDX_8298BBE3E171EF5F", columns={"pref_id"}), @ORM\Index(name="dtb_customer_buy_times_idx", columns={"buy_times"}), @ORM\Index(name="dtb_customer_buy_total_idx", columns={"buy_total"}), @ORM\Index(name="dtb_customer_create_date_idx", columns={"create_date"}), @ORM\Index(name="dtb_customer_update_date_idx", columns={"update_date"}), @ORM\Index(name="dtb_customer_last_buy_date_idx", columns={"last_buy_date"}), @ORM\Index(name="dtb_customer_email_idx", columns={"email"})})
 * @ORM\Entity
 */
class DtbCustomer
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_number", type="string", length=14, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth", type="datetime", nullable=true)
     */
    private $birth;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_key", type="string", length=255, nullable=false)
     */
    private $secretKey;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="first_buy_date", type="datetime", nullable=true)
     */
    private $firstBuyDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_buy_date", type="datetime", nullable=true)
     */
    private $lastBuyDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="buy_times", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $buyTimes = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="buy_total", type="decimal", precision=12, scale=2, nullable=true, options={"default"="0.00"})
     */
    private $buyTotal = '0.00';

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="string", length=4000, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reset_key", type="string", length=255, nullable=true)
     */
    private $resetKey;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="reset_expire", type="datetime", nullable=true)
     */
    private $resetExpire;

    /**
     * @var string
     *
     * @ORM\Column(name="point", type="decimal", precision=12, scale=0, nullable=false)
     */
    private $point = '0';

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
     * @var \MtbCustomerStatus
     *
     * @ORM\ManyToOne(targetEntity="MtbCustomerStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_status_id", referencedColumnName="id")
     * })
     */
    private $customerStatus;

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
     * @var \MtbSex
     *
     * @ORM\ManyToOne(targetEntity="MtbSex")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sex_id", referencedColumnName="id")
     * })
     */
    private $sex;


}
