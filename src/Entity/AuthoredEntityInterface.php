<?php

declare(strict_types=1);

namespace App\Entity;

interface AuthoredEntityInterface
{
    public function setCreatedBy(string $createdBy): static;

    public function setUpdatedBy(string $updatedBy): static;

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void;
}
