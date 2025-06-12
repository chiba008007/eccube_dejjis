<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbDeliveryDuration
 *
 * @ORM\Table(name="dtb_delivery_duration")
 * @ORM\Entity
 */
class DtbDeliveryDuration
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="smallint", nullable=false)
     */
    private $duration = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $sortNo;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;


}
