<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbLayout
 *
 * @ORM\Table(name="dtb_layout", indexes={@ORM\Index(name="IDX_5A62AA7C4FFA550E", columns={"device_type_id"})})
 * @ORM\Entity
 */
class DtbLayout
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
     * @ORM\Column(name="layout_name", type="string", length=255, nullable=true)
     */
    private $layoutName;

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
     * @var \MtbDeviceType
     *
     * @ORM\ManyToOne(targetEntity="MtbDeviceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="device_type_id", referencedColumnName="id")
     * })
     */
    private $deviceType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DtbPage", mappedBy="layout")
     */
    private $page = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->page = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
