<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbBaseInfo
 *
 * @ORM\Table(name="dtb_base_info", indexes={@ORM\Index(name="IDX_1D3655F4F92F3E70", columns={"country_id"}), @ORM\Index(name="IDX_1D3655F4E171EF5F", columns={"pref_id"})})
 * @ORM\Entity
 */
class DtbBaseInfo
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
     * @ORM\Column(name="company_name", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="company_kana", type="string", length=255, nullable=true)
     */
    private $companyKana;

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
     * @ORM\Column(name="phone_number", type="string", length=14, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="business_hour", type="string", length=255, nullable=true)
     */
    private $businessHour;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email01", type="string", length=255, nullable=true)
     */
    private $email01;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email02", type="string", length=255, nullable=true)
     */
    private $email02;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email03", type="string", length=255, nullable=true)
     */
    private $email03;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email04", type="string", length=255, nullable=true)
     */
    private $email04;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shop_name", type="string", length=255, nullable=true)
     */
    private $shopName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shop_kana", type="string", length=255, nullable=true)
     */
    private $shopKana;

    /**
     * @var string|null
     *
     * @ORM\Column(name="shop_name_eng", type="string", length=255, nullable=true)
     */
    private $shopNameEng;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime", nullable=false)
     */
    private $updateDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="good_traded", type="string", length=4000, nullable=true)
     */
    private $goodTraded;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message", type="string", length=4000, nullable=true)
     */
    private $message;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_free_amount", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $deliveryFreeAmount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="delivery_free_quantity", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $deliveryFreeQuantity;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_mypage_order_status_display", type="boolean", nullable=false, options={"default"="1"})
     */
    private $optionMypageOrderStatusDisplay = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_nostock_hidden", type="boolean", nullable=false)
     */
    private $optionNostockHidden = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="option_favorite_product", type="boolean", nullable=false, options={"default"="1"})
     */
    private $optionFavoriteProduct = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_product_delivery_fee", type="boolean", nullable=false)
     */
    private $optionProductDeliveryFee = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="invoice_registration_number", type="string", length=255, nullable=true)
     */
    private $invoiceRegistrationNumber;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_product_tax_rule", type="boolean", nullable=false)
     */
    private $optionProductTaxRule = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="option_customer_activate", type="boolean", nullable=false, options={"default"="1"})
     */
    private $optionCustomerActivate = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_remember_me", type="boolean", nullable=false, options={"default"="1"})
     */
    private $optionRememberMe = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_mail_notifier", type="boolean", nullable=false)
     */
    private $optionMailNotifier = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="authentication_key", type="string", length=255, nullable=true)
     */
    private $authenticationKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="php_path", type="string", length=255, nullable=true)
     */
    private $phpPath;

    /**
     * @var bool
     *
     * @ORM\Column(name="option_point", type="boolean", nullable=false, options={"default"="1"})
     */
    private $optionPoint = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="basic_point_rate", type="decimal", precision=10, scale=0, nullable=true, options={"default"="1"})
     */
    private $basicPointRate = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_conversion_rate", type="decimal", precision=10, scale=0, nullable=true, options={"default"="1"})
     */
    private $pointConversionRate = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="company_name_vn", type="string", length=255, nullable=true)
     */
    private $companyNameVn;

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


}
