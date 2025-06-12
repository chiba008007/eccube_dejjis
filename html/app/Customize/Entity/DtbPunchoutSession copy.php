<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbPunchoutSession
 *
 * @ORM\Table(name="dtb_punchout_session", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_punchout_session_buyer_cookie", columns={"buyer_cookie"}), @ORM\UniqueConstraint(name="UNIQ_punchout_session_session_id", columns={"session_id"})})
 * @ORM\Entity
 */
class DtbPunchoutSession
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=255, nullable=false)
     */
    private $sessionId;

    /**
     * @var string
     *
     * @ORM\Column(name="buyer_cookie", type="string", length=255, nullable=false)
     */
    private $buyerCookie;

    /**
     * @var string
     *
     * @ORM\Column(name="request_xml", type="text", length=0, nullable=false)
     */
    private $requestXml;

    /**
     * @var string
     *
     * @ORM\Column(name="browser_post_url", type="text", length=0, nullable=false)
     */
    private $browserPostUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_email", type="string", length=255, nullable=true)
     */
    private $userEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_first_name", type="string", length=255, nullable=true)
     */
    private $userFirstName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_last_name", type="string", length=255, nullable=true)
     */
    private $userLastName;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=32, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="business_unit", type="string", length=64, nullable=true)
     */
    private $businessUnit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ship_to_json", type="text", length=0, nullable=true)
     */
    private $shipToJson;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="expire_at", type="datetime", nullable=true)
     */
    private $expireAt;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_used", type="boolean", nullable=true)
     */
    private $isUsed = '0';

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


}
