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
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['Region:read'],
            ],
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['RegionCollection:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['Region:read'],
            ],
            denormalizationContext: [
                'groups' => ['Region:write'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Put(
            normalizationContext: [
                'groups' => ['Region:read'],
            ],
            denormalizationContext: [
                'groups' => ['Region:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            normalizationContext: [
                'groups' => ['Region:read'],
            ],
            denormalizationContext: [
                'groups' => ['Region:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    filters: [
        'region.order_filter',
    ],
    order: ['regionName' => 'ASC'],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Region implements AuthoredEntityInterface
{
    use TimestampsTrait;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $active = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Country::class)]
    private Collection $countries;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Id]
    #[ORM\Column(name: 'region_code', type: 'string', length: 20, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 20)]
    #[ApiProperty(identifier: true)]
    private ?string $regionCode = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\NotNull]
    #[Assert\Length(max: 20)]
    private ?string $regionName = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    public function addCountry(Country $country): static
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
            $country->setRegion($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    public function getRegionName(): ?string
    {
        return $this->regionName;
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

    public function removeCountry(Country $country): static
    {
        if ($this->countries->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getRegion() === $this) {
                $country->setRegion(null);
            }
        }

        return $this;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setRegionCode(string $regionCode): static
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    public function setRegionName(string $regionName): static
    {
        $this->regionName = $regionName;

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
