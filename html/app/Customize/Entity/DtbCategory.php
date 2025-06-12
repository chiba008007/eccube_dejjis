<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbCategory
 *
 * @ORM\Table(name="dtb_category", indexes={@ORM\Index(name="IDX_5ED2C2B796A8F92", columns={"parent_category_id"}), @ORM\Index(name="IDX_5ED2C2B61220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbCategory
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
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false)
     */
    private $categoryName;

    /**
     * @var int
     *
     * @ORM\Column(name="hierarchy", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $hierarchy;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="integer", nullable=false)
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
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbCategory
     *
     * @ORM\ManyToOne(targetEntity="DtbCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_category_id", referencedColumnName="id")
     * })
     */
    private $parentCategory;

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
     * @ORM\ManyToMany(targetEntity="DtbProduct", mappedBy="category")
     */
    private $product = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
