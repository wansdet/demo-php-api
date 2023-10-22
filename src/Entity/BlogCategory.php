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
use App\Repository\BlogCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['BlogCategory:read'],
            ],
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['BlogCategoryCollection:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['BlogCategory:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogCategory:write'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Put(
            normalizationContext: [
                'groups' => ['BlogCategory:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogCategory:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            normalizationContext: [
                'groups' => ['BlogCategory:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogCategory:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    filters: [
        'blog_category.order_filter',
    ],
    order: ['blogCategoryName' => 'ASC'],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: BlogCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class BlogCategory implements AuthoredEntityInterface
{
    use TimestampsTrait;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $active = null;

    #[ORM\Id]
    #[ORM\Column(name: 'blog_category_code', type: 'string', length: 30, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 30)]
    #[ApiProperty(identifier: true)]
    private ?string $blogCategoryCode = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 30)]
    private ?string $blogCategoryName = null;

    #[ORM\OneToMany(mappedBy: 'blogCategory', targetEntity: BlogPost::class)]
    private Collection $blogPosts;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotNull]
    private ?int $sortOrder = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    public function addBlogPost(BlogPost $blogPost): static
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts->add($blogPost);
            $blogPost->setBlogCategory($this);
        }

        return $this;
    }

    public function getBlogCategoryCode(): ?string
    {
        return $this->blogCategoryCode;
    }

    public function getBlogCategoryName(): ?string
    {
        return $this->blogCategoryName;
    }

    /**
     * @return Collection<int, BlogPost>
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
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

    public function removeBlogPost(BlogPost $blogPost): static
    {
        if ($this->blogPosts->removeElement($blogPost)) {
            // set the owning side to null (unless already changed)
            if ($blogPost->getBlogCategory() === $this) {
                $blogPost->setBlogCategory(null);
            }
        }

        return $this;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function setBlogCategoryCode(string $blogCategoryCode): static
    {
        $this->blogCategoryCode = $blogCategoryCode;

        return $this;
    }

    public function setBlogCategoryName(string $blogCategoryName): static
    {
        $this->blogCategoryName = $blogCategoryName;

        return $this;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
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
