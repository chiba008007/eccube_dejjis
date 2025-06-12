<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbAuthorityRole
 *
 * @ORM\Table(name="dtb_authority_role", indexes={@ORM\Index(name="IDX_4A1F70B181EC865B", columns={"authority_id"}), @ORM\Index(name="IDX_4A1F70B161220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbAuthorityRole
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
     * @ORM\Column(name="deny_url", type="string", length=4000, nullable=false)
     */
    private $denyUrl;

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
     * @var \MtbAuthority
     *
     * @ORM\ManyToOne(targetEntity="MtbAuthority")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="authority_id", referencedColumnName="id")
     * })
     */
    private $authority;

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
