<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbPlugin
 *
 * @ORM\Table(name="dtb_plugin")
 * @ORM\Entity
 */
class DtbPlugin
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
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    private $code;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255, nullable=false)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=false)
     */
    private $source;

    /**
     * @var bool
     *
     * @ORM\Column(name="initialized", type="boolean", nullable=false)
     */
    private $initialized = '0';

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


}
