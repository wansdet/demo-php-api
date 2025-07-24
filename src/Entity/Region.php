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
    order: [
        'sortOrder' => 'ASC',
    ],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Region implements AuthoredEntityInterface
{
    use TimestampsTrait;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 20, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 20)]
    #[ApiProperty(identifier: true)]
    private ?string $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotNull]
    #[Assert\Length(max: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotNull]
    #[Assert\Length(max: 500)]
    private ?string $briefDescription = null;

    #[ORM\Column(length: 2000)]
    #[Assert\NotNull]
    #[Assert\Length(max: 2000)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull]
    #[Assert\Length(max: 8000)]
    private ?string $longDescription = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $active = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    #[ORM\OneToMany(targetEntity: Country::class, mappedBy: 'region')]
    private Collection $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBriefDescription(): ?string
    {
        return $this->briefDescription;
    }

    public function setBriefDescription(string $briefDescription): static
    {
        $this->briefDescription = $briefDescription;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): static
    {
        $this->longDescription = $longDescription;

        return $this;
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

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(string $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): static
    {
        if (!$this->countries->contains($country)) {
            $this->countries->add($country);
            $country->setRegion($this);
        }

        return $this;
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
}
