<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DtbPunchoutSession
 *
 * @ORM\Table(
 *     name="dtb_punchout_session",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_punchout_session_buyer_cookie", columns={"buyer_cookie"})}
 * )
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
    private $isUsed = false;

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

    // ----- getter / setter ここから -----

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getBuyerCookie(): ?string
    {
        return $this->buyerCookie;
    }

    public function setBuyerCookie(string $buyerCookie): self
    {
        $this->buyerCookie = $buyerCookie;
        return $this;
    }

    public function getRequestXml(): ?string
    {
        return $this->requestXml;
    }

    public function setRequestXml(string $requestXml): self
    {
        $this->requestXml = $requestXml;
        return $this;
    }
    public function getBrowserPostUrl(): ?string
    {
        return $this->browserPostUrl;
    }

    public function setBrowserPostUrl(string $browserPostUrl): self
    {
        $this->browserPostUrl = $browserPostUrl;
        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(?string $userEmail): self
    {
        $this->userEmail = $userEmail;
        return $this;
    }

    public function getUserFirstName(): ?string
    {
        return $this->userFirstName;
    }

    public function setUserFirstName(?string $userFirstName): self
    {
        $this->userFirstName = $userFirstName;
        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->userLastName;
    }

    public function setUserLastName(?string $userLastName): self
    {
        $this->userLastName = $userLastName;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getBusinessUnit(): ?string
    {
        return $this->businessUnit;
    }

    public function setBusinessUnit(?string $businessUnit): self
    {
        $this->businessUnit = $businessUnit;
        return $this;
    }

    public function getShipToJson(): ?string
    {
        return $this->shipToJson;
    }

    public function setShipToJson(?string $shipToJson): self
    {
        $this->shipToJson = $shipToJson;
        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(?\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;
        return $this;
    }

    public function getIsUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function setIsUsed(?bool $isUsed): self
    {
        $this->isUsed = $isUsed;
        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;
        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;
        return $this;
    }
}
