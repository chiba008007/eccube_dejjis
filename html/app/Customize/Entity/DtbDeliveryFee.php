<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbDeliveryFee
 *
 * @ORM\Table(name="dtb_delivery_fee", indexes={@ORM\Index(name="IDX_491552412136921", columns={"delivery_id"}), @ORM\Index(name="IDX_4915524E171EF5F", columns={"pref_id"})})
 * @ORM\Entity
 */
class DtbDeliveryFee
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
     * @ORM\Column(name="fee", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $fee;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \MtbPref
     *
     * @ORM\ManyToOne(targetEntity="MtbPref")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pref_id", referencedColumnName="id")
     * })
     */
    private $pref;

    /**
     * @var \DtbDelivery
     *
     * @ORM\ManyToOne(targetEntity="DtbDelivery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="delivery_id", referencedColumnName="id")
     * })
     */
    private $delivery;


}
