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
use App\Repository\InformationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['Information:read'],
            ],
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['InformationCollection:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['Information:read'],
            ],
            denormalizationContext: [
                'groups' => ['Information:write'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Put(
            normalizationContext: [
                'groups' => ['Information:read'],
            ],
            denormalizationContext: [
                'groups' => ['Information:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            normalizationContext: [
                'groups' => ['Information:read'],
            ],
            denormalizationContext: [
                'groups' => ['Information:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    filters: [
        'information.search_filter',
        'information.order_filter',
    ],
    order: ['sortOrder' => 'ASC'],
)]
#[ORM\Entity(repositoryClass: InformationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Information implements AuthoredEntityInterface, UuidInterface
{
    use TimestampsTrait;

    public const TYPE_FAQ = 'faq';

    public const TYPE_SERVICES = 'services';

    public const TYPES = [
        self::TYPE_SERVICES,
        self::TYPE_FAQ,
    ];

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $active = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(length: 1000)]
    #[Assert\NotNull]
    #[Assert\Length(max: 1000)]
    private ?string $information = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    private ?Uuid $informationId = null;

    #[ORM\Column(length: 30)]
    #[Assert\Choice(choices: self::TYPES)]
    private ?string $informationType = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $subTitle = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotNull]
    #[Assert\Length(max: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function getInformationId(): ?Uuid
    {
        return $this->informationId;
    }

    public function getInformationType(): ?string
    {
        return $this->informationType;
    }

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function getTitle(): ?string
    {
        return $this->title;
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

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setInformation(string $information): static
    {
        $this->information = $information;

        return $this;
    }

    public function setInformationId(Uuid $informationId): static
    {
        $this->informationId = $informationId;

        return $this;
    }

    public function setInformationType(string $informationType): static
    {
        $this->informationType = $informationType;

        return $this;
    }

    public function setSortOrder(int $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setUpdatedBy(?string $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function setUuid(Uuid $uuid): void
    {
        $this->informationId = $uuid;
    }
}
