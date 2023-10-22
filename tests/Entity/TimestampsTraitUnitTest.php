<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class TimestampsTraitUnitTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testGetSetCreatedAt(): void
    {
        $createdAt = new \DateTimeImmutable();
        $this->user->setCreatedAt($createdAt);
        self::assertSame($createdAt, $this->user->getCreatedAt());
    }

    public function testGetSetUpdatedAt(): void
    {
        $updatedAt = new \DateTimeImmutable();
        $this->user->setUpdatedAt($updatedAt);
        self::assertSame($updatedAt, $this->user->getUpdatedAt());
    }

    public function testPrePersist(): void
    {
        $this->user->prePersist();
        self::assertInstanceOf(\DateTimeImmutable::class, $this->user->getCreatedAt());
        self::assertNull($this->user->getUpdatedAt());
    }

    public function testPrePersistPreUpdate(): void
    {
        $this->user->prePersist();
        $createdAt = $this->user->getCreatedAt();
        $this->user->preUpdate();
        self::assertSame($createdAt, $this->user->getCreatedAt());
    }

    public function testPreUpdate(): void
    {
        $this->user->preUpdate();
        self::assertInstanceOf(\DateTimeImmutable::class, $this->user->getUpdatedAt());
    }
}
