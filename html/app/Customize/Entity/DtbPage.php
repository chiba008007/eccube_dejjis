<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbPage
 *
 * @ORM\Table(name="dtb_page", indexes={@ORM\Index(name="IDX_E3951A67D0618E8C", columns={"master_page_id"}), @ORM\Index(name="dtb_page_url_idx", columns={"url"})})
 * @ORM\Entity
 */
class DtbPage
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
     * @ORM\Column(name="page_name", type="string", length=255, nullable=true)
     */
    private $pageName;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @var int
     *
     * @ORM\Column(name="edit_type", type="smallint", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $editType = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="keyword", type="string", length=255, nullable=true)
     */
    private $keyword;

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
     * @ORM\Column(name="meta_robots", type="string", length=255, nullable=true)
     */
    private $metaRobots;

    /**
     * @var string|null
     *
     * @ORM\Column(name="meta_tags", type="string", length=4000, nullable=true)
     */
    private $metaTags;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbPage
     *
     * @ORM\ManyToOne(targetEntity="DtbPage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="master_page_id", referencedColumnName="id")
     * })
     */
    private $masterPage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DtbLayout", inversedBy="page")
     * @ORM\JoinTable(name="dtb_page_layout",
     *   joinColumns={
     *     @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="layout_id", referencedColumnName="id")
     *   }
     * )
     */
    private $layout = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->layout = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
