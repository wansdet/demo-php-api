<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CountryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['Country:read'],
            ],
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['CountryCollection:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['Country:read'],
            ],
            denormalizationContext: [
                'groups' => ['Country:write'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Put(
            normalizationContext: [
                'groups' => ['Country:read'],
            ],
            denormalizationContext: [
                'groups' => ['Country:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            normalizationContext: [
                'groups' => ['Country:read'],
            ],
            denormalizationContext: [
                'groups' => ['Country:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    filters: [
        'country.search_filter',
        'country.order_filter',
    ],
    order: ['sortOrder' => 'ASC'],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Country implements AuthoredEntityInterface
{
    use TimestampsTrait;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $active = null;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 2, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 2)]
    #[ApiProperty(identifier: true)]
    private ?string $countryCode = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotNull]
    #[Assert\Length(max: 100)]
    private ?string $countryName = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'countries')]
    #[ORM\JoinColumn(name: 'region_code', referencedColumnName: 'region_code', nullable: false)]
    #[Assert\NotNull]
    private ?Region $region = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function setCountryCode(string $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function setCountryName(string $countryName): static
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function setUpdatedBy(?string $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
}
