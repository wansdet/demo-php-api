<?php

declare(strict_types=1);

namespace App\Entity;

interface AuthorInterface
{
    public function setAuthor(?User $author): void;
}
