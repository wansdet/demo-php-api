<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Information;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 *
 * @coversNothing
 */
final class InformationUnitTest extends TestCase
{
    private Information $information;

    protected function setUp(): void
    {
        $this->information = new Information();
    }

    public function testGetSetActive(): void
    {
        $active = true;
        $this->information->setActive($active);
        self::assertEquals($active, $this->information->isActive());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'Donald Duck';
        $this->information->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->information->getCreatedBy());
    }

    public function testGetSetInformation(): void
    {
        $information = 'Test Information';
        $this->information->setInformation($information);
        self::assertEquals($information, $this->information->getInformation());
    }

    public function testGetSetInformationId(): void
    {
        $informationId = Uuid::v4();
        $this->information->setInformationId($informationId);
        self::assertEquals($informationId, $this->information->getInformationId());
    }

    public function testGetSetInformationType(): void
    {
        $informationType = Information::TYPE_FAQ;
        $this->information->setInformationType($informationType);
        self::assertEquals($informationType, $this->information->getInformationType());
    }

    public function testGetSetSortOrder(): void
    {
        $sortOrder = 1;
        $this->information->setSortOrder($sortOrder);
        self::assertEquals($sortOrder, $this->information->getSortOrder());
    }

    public function testGetSetSubtitle(): void
    {
        $subtitle = 'Test Subtitle';
        $this->information->setSubtitle($subtitle);
        self::assertEquals($subtitle, $this->information->getSubtitle());
    }

    public function testGetSetTitle(): void
    {
        $title = 'Test Title';
        $this->information->setTitle($title);
        self::assertEquals($title, $this->information->getTitle());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'Mickey Mouse';
        $this->information->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->information->getUpdatedBy());
    }
}
