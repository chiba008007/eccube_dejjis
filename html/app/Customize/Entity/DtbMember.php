<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbMember
 *
 * @ORM\Table(name="dtb_member", indexes={@ORM\Index(name="IDX_10BC3BE6BB3453DB", columns={"work_id"}), @ORM\Index(name="IDX_10BC3BE681EC865B", columns={"authority_id"}), @ORM\Index(name="IDX_10BC3BE661220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbMember
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
     * @ORM\Column(name="department", type="string", length=255, nullable=true)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="login_id", type="string", length=255, nullable=false)
     */
    private $loginId;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_no", type="smallint", nullable=false, options={"unsigned"=true})
     */
    private $sortNo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="two_factor_auth_key", type="string", length=255, nullable=true)
     */
    private $twoFactorAuthKey;

    /**
     * @var bool
     *
     * @ORM\Column(name="two_factor_auth_enabled", type="boolean", nullable=false)
     */
    private $twoFactorAuthEnabled = '0';

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="login_date", type="datetime", nullable=true)
     */
    private $loginDate;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \MtbWork
     *
     * @ORM\ManyToOne(targetEntity="MtbWork")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="work_id", referencedColumnName="id")
     * })
     */
    private $work;

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
