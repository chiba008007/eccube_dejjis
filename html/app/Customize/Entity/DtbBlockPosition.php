<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbBlockPosition
 *
 * @ORM\Table(name="dtb_block_position", indexes={@ORM\Index(name="IDX_35DCD731E9ED820C", columns={"block_id"}), @ORM\Index(name="IDX_35DCD7318C22AA1A", columns={"layout_id"})})
 * @ORM\Entity
 */
class DtbBlockPosition
{
    /**
     * @var int
     *
     * @ORM\Column(name="section", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $section;

    /**
     * @var int|null
     *
     * @ORM\Column(name="block_row", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $blockRow;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbBlock
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="DtbBlock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="block_id", referencedColumnName="id")
     * })
     */
    private $block;

    /**
     * @var \DtbLayout
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="DtbLayout")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="layout_id", referencedColumnName="id")
     * })
     */
    private $layout;


}
