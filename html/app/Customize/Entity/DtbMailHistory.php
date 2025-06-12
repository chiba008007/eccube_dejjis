<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbMailHistory
 *
 * @ORM\Table(name="dtb_mail_history", indexes={@ORM\Index(name="IDX_4870AB118D9F6D38", columns={"order_id"}), @ORM\Index(name="IDX_4870AB1161220EA6", columns={"creator_id"})})
 * @ORM\Entity
 */
class DtbMailHistory
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="send_date", type="datetime", nullable=true)
     */
    private $sendDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail_subject", type="string", length=255, nullable=true)
     */
    private $mailSubject;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail_body", type="text", length=0, nullable=true)
     */
    private $mailBody;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail_html_body", type="text", length=0, nullable=true)
     */
    private $mailHtmlBody;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;

    /**
     * @var \DtbOrder
     *
     * @ORM\ManyToOne(targetEntity="DtbOrder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

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
