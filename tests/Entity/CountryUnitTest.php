<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Country;
use App\Entity\Region;
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

    public function testGetDataSetRegion(): void
    {
        $region = new Region();
        $this->country->setRegion($region);
        self::assertEquals($region, $this->country->getRegion());
    }

    public function testGetSetActive(): void
    {
        $active = true;
        $this->country->setActive($active);
        self::assertEquals($active, $this->country->isActive());
    }

    public function testGetSetCountryCode(): void
    {
        $countryCode = 'GB';
        $this->country->setCountryCode($countryCode);
        self::assertEquals($countryCode, $this->country->getCountryCode());
    }

    public function testGetSetCountryName(): void
    {
        $countryName = 'United Kingdom';
        $this->country->setCountryName($countryName);
        self::assertEquals($countryName, $this->country->getCountryName());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'Created by';
        $this->country->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->country->getCreatedBy());
    }

    public function testGetSetSortOrder(): void
    {
        $sortOrder = 1;
        $this->country->setSortOrder($sortOrder);
        self::assertEquals($sortOrder, $this->country->getSortOrder());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'Updated by';
        $this->country->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->country->getUpdatedBy());
    }
}
