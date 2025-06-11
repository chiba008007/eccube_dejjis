<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbOrderPdf
 *
 * @ORM\Table(name="dtb_order_pdf")
 * @ORM\Entity
 */
class DtbOrderPdf
{
    /**
     * @var int
     *
     * @ORM\Column(name="member_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $memberId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message1", type="string", length=255, nullable=true)
     */
    private $message1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message2", type="string", length=255, nullable=true)
     */
    private $message2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="message3", type="string", length=255, nullable=true)
     */
    private $message3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note1", type="string", length=255, nullable=true)
     */
    private $note1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note2", type="string", length=255, nullable=true)
     */
    private $note2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note3", type="string", length=255, nullable=true)
     */
    private $note3;

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
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $visible = true;

    /**
     * @var string
     *
     * @ORM\Column(name="discriminator_type", type="string", length=255, nullable=false)
     */
    private $discriminatorType;


}
