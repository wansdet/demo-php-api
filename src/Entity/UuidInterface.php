<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

interface UuidInterface
{
    public function setUuid(Uuid $uuid): void;
}
