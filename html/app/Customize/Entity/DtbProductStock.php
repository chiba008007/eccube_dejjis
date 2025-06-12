<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbProductStock
 *
 * @ORM\Table(name="dtb_product_stock", indexes={@ORM\Index(name="IDX_BC6C9E4521B06187", columns={"product_class_id"}), @ORM\Index(name="IDX_BC6C9E4561220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbProductStock
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
     * @ORM\Column(name="stock", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $stock;

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
     * @var \DtbProductClass
     *
     * @ORM\ManyToOne(targetEntity="DtbProductClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="id")
     * })
     */
    private $productClass;


}
