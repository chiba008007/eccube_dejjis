<?php

namespace Customize\Entity;

use Customize\Repository\HelloRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\AbstractEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Customize\Entity\Traits\TimestampableTrait;
use Customize\Validator\UniqueHelloName;

/**
 * @ORM\Entity(repositoryClass=HelloRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
// イベントリスナーの有効化
class Hello extends AbstractEntity
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @UniqueHelloName()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     max = 255,
     *     maxMessage = "コメントは{{ limit }}文字以内で入力してください"
     * )
     */
    private $comment;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
