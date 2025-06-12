<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbCsv
 *
 * @ORM\Table(name="dtb_csv", indexes={@ORM\Index(name="IDX_F55F48C3E8507796", columns={"csv_type_id"}), @ORM\Index(name="IDX_F55F48C361220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbCsv
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
     * @ORM\Column(name="entity_name", type="string", length=255, nullable=false)
     */
    private $entityName;

    /**
     * @var string
     *
     * @ORM\Column(name="field_name", type="string", length=255, nullable=false)
     */
    private $fieldName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reference_field_name", type="string", length=255, nullable=true)
     */
    private $referenceFieldName;

    /**
     * @var string
     *
     * @ORM\Column(name="disp_name", type="string", length=255, nullable=false)
     */
    private $dispName;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=false, options={"unsigned"=true})
     */
    private $sortNo;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false, options={"default"="1"})
     */
    private $enabled = true;

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
     * @var \MtbCsvType
     *
     * @ORM\ManyToOne(targetEntity="MtbCsvType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="csv_type_id", referencedColumnName="id")
     * })
     */
    private $csvType;

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
