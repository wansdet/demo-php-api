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
use App\Dto\Blog\BlogPostCommentTransitionRequest;
use App\Repository\BlogPostCommentRepository;
use App\State\Blog\Comment\BlogPostCommentRejectProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => ['BlogPostComment:read'],
            ],
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['BlogPostCommentCollection:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['BlogPostComment:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPostComment:write'],
            ],
            security: 'is_granted("ROLE_USER")',
        ),
        new Patch(
            uriTemplate: '/blog_post_comments/{blogPostCommentId}/reject',
            status: 200,
            denormalizationContext: [
                'groups' => ['BlogPostComment:transition'],
            ],
            security: 'is_granted("ROLE_MODERATOR")',
            input: BlogPostCommentTransitionRequest::class,
            output: false,
            name: 'app_blog_post_comment_reject',
            processor: BlogPostCommentRejectProcessor::class,
        ),
        new Delete(
            security: 'is_granted("ROLE_MODERATOR") and object.getStatus() === "rejected"',
        ),
    ],
    filters: [
        'blog_post_comment.search_filter',
        'blog_post_comment.order_filter',
        'blog_post_comment.date_filter',
    ],
    order: ['id' => 'DESC'],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: BlogPostCommentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class BlogPostComment implements AuthoredEntityInterface, AuthorInterface, UuidInterface
{
    use TimestampsTrait;

    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';
    public const BLOG_POST_COMMENT_STATUSES = [
        self::STATUS_PUBLISHED,
        self::STATUS_REJECTED,
    ];

    public const TRANSITION_REJECT = 'reject';

    #[ORM\ManyToOne(inversedBy: 'blogPostComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BlogPost $blogPost = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    private ?Uuid $blogPostCommentId = null;

    #[ORM\Column(length: 1000)]
    #[Assert\NotNull]
    #[Assert\Length(max: 1000)]
    private ?string $comment = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Range(min: 1, max: 10)]
    private ?int $rating = null;

    #[Assert\Length(max: 255)]
    private ?string $remarks = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: self::BLOG_POST_COMMENT_STATUSES)]
    private ?string $status = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    #[ORM\ManyToOne(inversedBy: 'blogPostComments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function __construct()
    {
        $this->status = self::STATUS_PUBLISHED;
    }

    public function getBlogPost(): ?BlogPost
    {
        return $this->blogPost;
    }

    public function getBlogPostCommentId(): ?Uuid
    {
        return $this->blogPostCommentId;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setBlogPost(?BlogPost $blogPost): static
    {
        $this->blogPost = $blogPost;

        return $this;
    }

    public function setBlogPostCommentId(Uuid $blogPostCommentId): static
    {
        $this->blogPostCommentId = $blogPostCommentId;

        return $this;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function setRemarks(?string $remarks): static
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function setUpdatedBy(?string $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function setUuid(Uuid $uuid): void
    {
        $this->blogPostCommentId = $uuid;
    }
}
