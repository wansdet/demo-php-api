<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Country;
use App\Entity\Region;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \App\Entity\Region
 */
final class RegionUnitTest extends TestCase
{
    private Region $region;

    protected function setUp(): void
    {
        $this->region = new Region();
    }

    public function testSetAndGetId(): void
    {
        $this->region->setId('R001');
        $this->assertSame('R001', $this->region->getId());
    }

    public function testSetAndGetName(): void
    {
        $this->region->setName('Test Region');
        $this->assertSame('Test Region', $this->region->getName());
    }

    public function testSetAndGetBriefDescription(): void
    {
        $this->region->setBriefDescription('A brief description of the region.');
        $this->assertSame('A brief description of the region.', $this->region->getBriefDescription());
    }

    public function testSetAndGetShortDescription(): void
    {
        $this->region->setShortDescription('A short description of the region.');
        $this->assertSame('A short description of the region.', $this->region->getShortDescription());
    }

    public function testSetAndGetLongDescription(): void
    {
        $this->region->setLongDescription('A long description of the region that provides detailed information.');
        $this->assertSame('A long description of the region that provides detailed information.', $this->region->getLongDescription());
    }

    public function testSetGetActive(): void
    {
        $this->region->setActive(true);
        $this->assertTrue($this->region->isActive());
    }

    public function testSetGetSortOrder(): void
    {
        $this->region->setSortOrder(1);
        $this->assertSame(1, $this->region->getSortOrder());
    }

    public function testSetGetCreatedBy(): void
    {
        $createdBy = 'user5';
        $this->region->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $this->region->getCreatedBy());
    }

    public function testSetGetCreatedAt(): void
    {
        $createdAt = new \DateTimeImmutable();
        $this->region->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $this->region->getCreatedAt());
    }

    public function testSetGetUpdatedBy(): void
    {
        $updatedBy = 'user6';
        $this->region->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $this->region->getUpdatedBy());
    }

    public function testSetGetUpdatedAt(): void
    {
        $updatedAt = new \DateTimeImmutable();
        $this->region->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $this->region->getUpdatedAt());
    }

    public function testAddRemoveGetCountries(): void
    {
        $country = new Country();

        $this->region->addCountry($country);
        $this->assertCount(1, $this->region->getCountries());
        $this->assertSame($this->region, $country->getRegion());
        $this->assertTrue($this->region->getCountries()->contains($country));

        $this->region->removeCountry($country);
        $this->assertCount(0, $this->region->getCountries());
        $this->assertNull($country->getRegion());
    }

    public function testGetCountriesInitializesAsEmptyCollection(): void
    {
        $this->assertInstanceOf(ArrayCollection::class, $this->region->getCountries());
        $this->assertCount(0, $this->region->getCountries());
    }
}
