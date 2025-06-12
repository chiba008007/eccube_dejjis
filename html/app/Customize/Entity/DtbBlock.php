<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbBlock
 *
 * @ORM\Table(name="dtb_block", uniqueConstraints={@ORM\UniqueConstraint(name="device_type_id", columns={"device_type_id", "file_name"})}, indexes={@ORM\Index(name="IDX_6B54DCBD4FFA550E", columns={"device_type_id"})})
 * @ORM\Entity
 */
class DtbBlock
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
     * @ORM\Column(name="block_name", type="string", length=255, nullable=true)
     */
    private $blockName;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255, nullable=false)
     */
    private $fileName;

    /**
     * @var bool
     *
     * @ORM\Column(name="use_controller", type="boolean", nullable=false)
     */
    private $useController = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="deletable", type="boolean", nullable=false, options={"default"="1"})
     */
    private $deletable = true;

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


}
