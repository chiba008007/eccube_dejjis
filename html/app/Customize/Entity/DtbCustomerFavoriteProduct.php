<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbCustomerFavoriteProduct
 *
 * @ORM\Table(name="dtb_customer_favorite_product", indexes={@ORM\Index(name="IDX_ED6313839395C3F3", columns={"customer_id"}), @ORM\Index(name="IDX_ED6313834584665A", columns={"product_id"})})
 * @ORM\Entity
 */
class DtbCustomerFavoriteProduct
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
     * @var \DtbCustomer
     *
     * @ORM\ManyToOne(targetEntity="DtbCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \DtbProduct
     *
     * @ORM\ManyToOne(targetEntity="DtbProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;


}
