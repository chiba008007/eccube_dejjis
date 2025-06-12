<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlgSecuritychecker4Config
 *
 * @ORM\Table(name="plg_Securitychecker4_config")
 * @ORM\Entity
 */
class PlgSecuritychecker4Config
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
     * @var string|null
     *
     * @ORM\Column(name="check_result", type="text", length=0, nullable=true)
     */
    private $checkResult;

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


}
