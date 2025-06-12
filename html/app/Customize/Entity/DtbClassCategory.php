<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbClassCategory
 *
 * @ORM\Table(name="dtb_class_category", indexes={@ORM\Index(name="IDX_9B0D1DBAB462FB2A", columns={"class_name_id"}), @ORM\Index(name="IDX_9B0D1DBA61220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbClassCategory
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
     * @ORM\Column(name="backend_name", type="string", length=255, nullable=true)
     */
    private $backendName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $sortNo;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $visible = true;

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
     * @var \DtbClassName
     *
     * @ORM\ManyToOne(targetEntity="DtbClassName")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_name_id", referencedColumnName="id")
     * })
     */
    private $className;

    /**
     * @var \DtbMember
     *
     * @ORM\ManyToOne(targetEntity="DtbMember")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     * })
     */
    private $creator;


}
