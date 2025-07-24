<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Country;
use App\Entity\Region;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class CountryUnitTest extends TestCase
{
    private Country $country;

    protected function setUp(): void
    {
        $this->country = new Country();
    }

    public function testSetGetId(): void
    {
        $id = 'GB';
        $this->country->setId($id);
        $this->assertSame($id, $this->country->getId());
    }

    public function testSetGetName(): void
    {
        $name = 'United Kingdom';
        $this->country->setName($name);
        $this->assertSame($name, $this->country->getName());
    }

    public function testSetGetActive(): void
    {
        $this->country->setActive(true);
        $this->assertTrue($this->country->isActive());
    }

    public function testSetGetSortOrder(): void
    {
        $this->country->setSortOrder(6);
        $this->assertSame(6, $this->country->getSortOrder());
    }

    public function testSetGetCreatedBy(): void
    {
        $createdBy = 'user1';
        $this->country->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $this->country->getCreatedBy());
    }

    public function testSetGetCreatedAt(): void
    {
        $this->country->setCreatedAt(new \DateTimeImmutable());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->country->getCreatedAt());
    }

    public function testSetGetUpdatedBy(): void
    {
        $updatedBy = 'user2';
        $this->country->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $this->country->getUpdatedBy());
    }

    public function testSetGetUpdatedAt(): void
    {
        $this->country->setUpdatedAt(new \DateTimeImmutable());
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->country->getUpdatedAt());
    }

    public function testSetGetRegion(): void
    {
        $region = new Region();
        $region->setName('Test Region');
        $this->country->setRegion($region);
        $this->assertSame($region, $this->country->getRegion());
    }

    public function testAddRemoveGetUsers(): void
    {
        $user = new User();
        $user->setEmail('admin@test.com');

        $this->country->addUser($user);
        self::assertInstanceOf(ArrayCollection::class, $this->country->getUsers());
        self::assertEquals(1, $this->country->getUsers()->count());

        $this->country->removeUser($user);
        self::assertEquals(0, $this->country->getUsers()->count());
    }

    public function testGetUsersInitializesAsEmptyCollection(): void
    {
        self::assertInstanceOf(ArrayCollection::class, $this->country->getUsers());
        self::assertCount(0, $this->country->getUsers());
    }
}
