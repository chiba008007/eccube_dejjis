<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MtbJob
 *
 * @ORM\Table(name="mtb_job")
 * @ORM\Entity
 */
class MtbJob
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="smallint", nullable=false, options={"unsigned"=true})
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
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=false, options={"unsigned"=true})
     */
    private $sortNo;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;


}
