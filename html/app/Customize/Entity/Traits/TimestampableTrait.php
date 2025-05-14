<?php

namespace Customize\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeImmutable $deleted_at = null;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }
    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }
    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

}
