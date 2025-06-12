<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbCart
 *
 * @ORM\Table(name="dtb_cart", uniqueConstraints={@ORM\UniqueConstraint(name="dtb_cart_pre_order_id_idx", columns={"pre_order_id"})}, indexes={@ORM\Index(name="IDX_FC3C24F09395C3F3", columns={"customer_id"}), @ORM\Index(name="dtb_cart_update_date_idx", columns={"update_date"})})
 * @ORM\Entity
 */
class DtbCart
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
     * @ORM\Column(name="cart_key", type="string", length=255, nullable=true)
     */
    private $cartKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pre_order_id", type="string", length=255, nullable=true)
     */
    private $preOrderId;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $totalPrice = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="delivery_fee_total", type="decimal", precision=12, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $deliveryFeeTotal = '0.00';

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
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbCustomer
     *
     * @ORM\ManyToOne(targetEntity="DtbCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;


}
