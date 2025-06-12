<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbLoginHistory
 *
 * @ORM\Table(name="dtb_login_history", indexes={@ORM\Index(name="IDX_6191DD4F9FA62FDD", columns={"login_history_status_id"}), @ORM\Index(name="IDX_6191DD4F7597D3FE", columns={"member_id"})})
 * @ORM\Entity
 */
class DtbLoginHistory
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
     * @ORM\Column(name="user_name", type="text", length=0, nullable=true)
     */
    private $userName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="client_ip", type="text", length=0, nullable=true)
     */
    private $clientIp;

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
     * @var \MtbLoginHistoryStatus
     *
     * @ORM\ManyToOne(targetEntity="MtbLoginHistoryStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login_history_status_id", referencedColumnName="id")
     * })
     */
    private $loginHistoryStatus;

    /**
     * @var \DtbMember
     *
     * @ORM\ManyToOne(targetEntity="DtbMember")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * })
     */
    private $member;


}
