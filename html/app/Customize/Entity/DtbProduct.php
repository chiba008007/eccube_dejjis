<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbProduct
 *
 * @ORM\Table(name="dtb_product", indexes={@ORM\Index(name="IDX_C49DE22F61220EA6", columns={"creator_id"}), @ORM\Index(name="IDX_C49DE22F557B630", columns={"product_status_id"})})
 * @ORM\Entity
 */
class DtbProduct
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", length=0, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_list", type="text", length=0, nullable=true)
     */
    private $descriptionList;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_detail", type="text", length=0, nullable=true)
     */
    private $descriptionDetail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="search_word", type="text", length=0, nullable=true)
     */
    private $searchWord;

    /**
     * @var string|null
     *
     * @ORM\Column(name="free_area", type="text", length=0, nullable=true)
     */
    private $freeArea;

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
     * @var string|null
     *
     * @ORM\Column(name="maker_name", type="string", length=255, nullable=true)
     */
    private $makerName;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \MtbProductStatus
     *
     * @ORM\ManyToOne(targetEntity="MtbProductStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_status_id", referencedColumnName="id")
     * })
     */
    private $productStatus;

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
     * @ORM\ManyToMany(targetEntity="DtbCategory", inversedBy="product")
     * @ORM\JoinTable(name="dtb_product_category",
     *   joinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *   }
     * )
     */
    private $category = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
