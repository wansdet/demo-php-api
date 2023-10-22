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
 * @coversNothing
 */
final class RegionUnitTest extends TestCase
{
    private Region $region;

    protected function setUp(): void
    {
        $this->region = new Region();
    }

    public function testGetAddRemoveCountries(): void
    {
        $country = new Country();
        $country->setCountryCode('GB');
        $country->setCountryName('United Kingdom');
        $country->setSortOrder(6);
        $country->setCreatedBy('admin');
        $country->setUpdatedBy('admin');

        $this->region->addCountry($country);
        self::assertInstanceOf(ArrayCollection::class, $this->region->getCountries());
        self::assertEquals(1, $this->region->getCountries()->count());

        $this->region->removeCountry($country);
        self::assertEquals(0, $this->region->getCountries()->count());
    }

    public function testGetSetActive(): void
    {
        $active = true;
        $this->region->setActive($active);
        self::assertEquals($active, $this->region->isActive());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'admin';
        $this->region->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->region->getCreatedBy());
    }

    public function testGetSetRegionCode(): void
    {
        $regionCode = 'EUROPE';
        $this->region->setRegionCode($regionCode);
        self::assertEquals($regionCode, $this->region->getRegionCode());
    }

    public function testGetSetRegionName(): void
    {
        $regionName = 'Europe';
        $this->region->setRegionName($regionName);
        self::assertEquals($regionName, $this->region->getRegionName());
    }

    public function testGetSetSortOrder(): void
    {
        $sortOrder = 6;
        $this->region->setSortOrder($sortOrder);
        self::assertEquals($sortOrder, $this->region->getSortOrder());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'admin';
        $this->region->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->region->getUpdatedBy());
    }
}
