<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbProductTag
 *
 * @ORM\Table(name="dtb_product_tag", indexes={@ORM\Index(name="IDX_4433E7214584665A", columns={"product_id"}), @ORM\Index(name="IDX_4433E721BAD26311", columns={"tag_id"}), @ORM\Index(name="IDX_4433E72161220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbProductTag
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
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbTag
     *
     * @ORM\ManyToOne(targetEntity="DtbTag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;

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
     * @var \DtbProduct
     *
     * @ORM\ManyToOne(targetEntity="DtbProduct")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;


}
