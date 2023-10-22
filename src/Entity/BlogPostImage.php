<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\BlogPostImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['BlogPostImage:read'],
            ],
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['BlogPostImageCollection:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['BlogPostImage:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPostImage:write'],
            ],
            security: 'is_granted("ROLE_BLOGGER")',
        ),
        new Put(
            normalizationContext: [
                'groups' => ['BlogPostImage:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPostImage:update'],
            ],
            security: '(is_granted("ROLE_BLOGGER") && object.getBlogPost().getAuthor().getUserIdentifier() === user.getUserIdentifier()) or is_granted("ROLE_EDITOR")',
        ),
        new Patch(
            normalizationContext: [
                'groups' => ['BlogPostImage:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPostImage:update'],
            ],
            security: '(is_granted("ROLE_BLOGGER") && object.getBlogPost().getAuthor().getUserIdentifier() === user.getUserIdentifier()) or is_granted("ROLE_EDITOR")',
        ),
        new Delete(
            security: '(is_granted("ROLE_BLOGGER") && object.getBlogPost().getAuthor().getUserIdentifier() === user.getUserIdentifier()) or is_granted("ROLE_EDITOR")',
        ),
    ],
    order: ['id' => 'ASC'],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: BlogPostImageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class BlogPostImage implements AuthoredEntityInterface
{
    use TimestampsTrait;

    #[ORM\ManyToOne(inversedBy: 'blogPostImages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?BlogPost $blogPost = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $filename = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $title = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    public function getBlogPost(): ?BlogPost
    {
        return $this->blogPost;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setBlogPost(?BlogPost $blogPost): static
    {
        $this->blogPost = $blogPost;

        return $this;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setFilename(?string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setUpdatedBy(?string $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }
}
