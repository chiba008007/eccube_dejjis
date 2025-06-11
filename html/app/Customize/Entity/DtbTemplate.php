<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbTemplate
 *
 * @ORM\Table(name="dtb_template", indexes={@ORM\Index(name="IDX_94C12A694FFA550E", columns={"device_type_id"})})
 * @ORM\Entity
 */
class DtbTemplate
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
     * @ORM\Column(name="template_code", type="string", length=255, nullable=false)
     */
    private $templateCode;

    /**
     * @var string
     *
     * @ORM\Column(name="template_name", type="string", length=255, nullable=false)
     */
    private $templateName;

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
