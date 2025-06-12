<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbCartItem
 *
 * @ORM\Table(name="dtb_cart_item", indexes={@ORM\Index(name="IDX_B0228F7421B06187", columns={"product_class_id"}), @ORM\Index(name="IDX_B0228F741AD5CDBF", columns={"cart_id"})})
 * @ORM\Entity
 */
class DtbCartItem
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
     * @var \DtbProductClass
     *
     * @ORM\ManyToOne(targetEntity="DtbProductClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="id")
     * })
     */
    private $productClass;

    /**
     * @var \DtbCart
     *
     * @ORM\ManyToOne(targetEntity="DtbCart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cart_id", referencedColumnName="id")
     * })
     */
    private $cart;


}
