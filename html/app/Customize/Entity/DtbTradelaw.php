<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbTradelaw
 *
 * @ORM\Table(name="dtb_tradelaw")
 * @ORM\Entity
 */
class DtbTradelaw
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
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=false)
     */
    private $sortNo;

    /**
     * @var bool
     *
     * @ORM\Column(name="display_order_screen", type="boolean", nullable=false)
     */
    private $displayOrderScreen;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;


}
