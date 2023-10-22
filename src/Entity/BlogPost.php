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
use App\Controller\Admin\BlogPostExportAdminController;
use App\Controller\Admin\BlogPostExportBloggerController;
use App\Controller\Blog\Reports\BlogPostsMonthlyAuthorsController;
use App\Controller\Blog\Reports\BlogPostsMonthlyCategoriesController;
use App\Dto\Blog\BlogPostsAnnualAuthorsResponse;
use App\Dto\Blog\BlogPostsAnnualCategoriesResponse;
use App\Dto\Blog\BlogPostTransitionRequest;
use App\Repository\BlogPostRepository;
use App\State\Blog\Post\AuthorBlogPostsProvider;
use App\State\Blog\Post\BlogPostArchiveProcessor;
use App\State\Blog\Post\BlogPostPublishProcessor;
use App\State\Blog\Post\BlogPostRejectProcessor;
use App\State\Blog\Post\BlogPostSubmitProcessor;
use App\State\Blog\Post\FeaturedBlogPostsProvider;
use App\State\Blog\Post\PublishedBlogPostsProvider;
use App\State\Blog\Reports\BlogPostsAnnualAuthorsProvider;
use App\State\Blog\Reports\BlogPostsAnnualCategoriesProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: [
                'groups' => ['BlogPostCollection:read'],
            ],
            security: 'is_granted("ROLE_EDITOR")',
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/author',
            normalizationContext: [
                'groups' => ['BlogPostCollection:read'],
            ],
            security: 'is_granted("ROLE_BLOGGER")',
            name: '_api_blog_posts_author',
            provider: AuthorBlogPostsProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/featured',
            normalizationContext: [
                'groups' => ['BlogPostCollection:read'],
            ],
            name: '_api_blog_posts_featured',
            provider: FeaturedBlogPostsProvider::class
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/published',
            normalizationContext: [
                'groups' => ['BlogPostCollection:read'],
            ],
            name: '_api_blog_posts_published',
            provider: PublishedBlogPostsProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/reports/annual/authors',
            normalizationContext: [
                'groups' => ['BlogPostReportsAnnualAuthors:read'],
            ],
            output: BlogPostsAnnualAuthorsResponse::class,
            name: '_api_blog_posts_reports_annual_authors',
            provider: BlogPostsAnnualAuthorsProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/reports/annual/categories',
            normalizationContext: [
                'groups' => ['BlogPostReportsAnnualCategories:read'],
            ],
            output: BlogPostsAnnualCategoriesResponse::class,
            name: '_api_blog_posts_reports_annual_categories',
            provider: BlogPostsAnnualCategoriesProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/reports/monthly/authors',
            controller: BlogPostsMonthlyAuthorsController::class,
            normalizationContext: [
                'groups' => ['BlogPostCollection:read'],
            ],
            name: '_api_blog_posts_reports_monthly_authors',
        ),
        new GetCollection(
            uriTemplate: '/blog_posts/reports/monthly/categories',
            controller: BlogPostsMonthlyCategoriesController::class,
            normalizationContext: [
                'groups' => ['BlogPostReportsMonthlyCategories:read'],
            ],
            name: '_api_blog_posts_reports_monthly_categories',
        ),
        new Get(
            normalizationContext: [
                'groups' => ['BlogPost:read'],
            ],
        ),
        new Post(
            normalizationContext: [
                'groups' => ['BlogPost:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPost:write'],
            ],
            security: 'is_granted("ROLE_BLOGGER")',
        ),
        new Post(
            uriTemplate: '/blog_posts/export/admin',
            controller: BlogPostExportAdminController::class,
            denormalizationContext: [
                'groups' => ['BlogPost:export'],
            ],
            security: 'is_granted("ROLE_EDITOR")',
            name: '_api_blog_posts_export_admin',
        ),
        new Post(
            uriTemplate: '/blog_posts/export/blogger',
            controller: BlogPostExportBloggerController::class,
            denormalizationContext: [
                'groups' => ['BlogPost:export'],
            ],
            security: 'is_granted("ROLE_BLOGGER")',
            name: '_api_blog_posts_export_blogger',
        ),
        new Put(
            normalizationContext: [
                'groups' => ['BlogPost:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPost:update'],
            ],
            security: '(is_granted("ROLE_BLOGGER") && object.getAuthor().getUserIdentifier() === user.getUserIdentifier()) or is_granted("ROLE_EDITOR")',
        ),
        new Patch(
            normalizationContext: [
                'groups' => ['BlogPost:read'],
            ],
            denormalizationContext: [
                'groups' => ['BlogPost:update'],
            ],
            security: '(is_granted("ROLE_BLOGGER") && object.getAuthor().getUserIdentifier() === user.getUserIdentifier()) or is_granted("ROLE_EDITOR")',
        ),
        new Put(
            uriTemplate: '/blog_posts/{blogPostId}/submit',
            status: 200,
            denormalizationContext: [
                'groups' => ['BlogPost:transition'],
            ],
            security: 'is_granted("ROLE_BLOGGER") && object.getAuthor().getUserIdentifier() === user.getUserIdentifier()',
            input: BlogPostTransitionRequest::class,
            output: false,
            name: '_api_blog_posts_item_submit',
            processor: BlogPostSubmitProcessor::class,
        ),
        new Put(
            uriTemplate: '/blog_posts/{blogPostId}/reject',
            status: 200,
            denormalizationContext: [
                'groups' => ['BlogPost:transition'],
            ],
            security: 'is_granted("ROLE_EDITOR")',
            input: BlogPostTransitionRequest::class,
            output: false,
            name: '_api_blog_posts_item_reject',
            processor: BlogPostRejectProcessor::class,
        ),
        new Put(
            uriTemplate: '/blog_posts/{blogPostId}/publish',
            status: 200,
            denormalizationContext: [
                'groups' => ['BlogPost:transition'],
            ],
            security: 'is_granted("ROLE_EDITOR")',
            input: BlogPostTransitionRequest::class,
            output: false,
            name: '_api_blog_posts_item_publish',
            processor: BlogPostPublishProcessor::class,
        ),
        new Put(
            uriTemplate: '/blog_posts/{blogPostId}/archive',
            status: 200,
            denormalizationContext: [
                'groups' => ['BlogPost:transition'],
            ],
            security: 'is_granted("ROLE_EDITOR")',
            input: BlogPostTransitionRequest::class,
            output: false,
            name: '_api_blog_posts_item_archive',
            processor: BlogPostArchiveProcessor::class,
        ),
        new Delete(
            security: '(is_granted("ROLE_BLOGGER") && object.getAuthor().getUserIdentifier() === user.getUserIdentifier() and (object.getStatus() === "draft" or object.getStatus() === "rejected")) or (is_granted("ROLE_EDITOR") and object.getStatus() === "archived")',
        ),
    ],
    filters: [
        'blog_post.search_filter',
        'blog_post.order_filter',
        'blog_post.exists_filter',
        'blog_post.date_filter',
    ],
    order: ['id' => 'DESC'],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: BlogPostRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['slug'], message: 'There is already a slug with this value')]
class BlogPost implements AuthoredEntityInterface, AuthorInterface, UuidInterface
{
    use TimestampsTrait;

    public const STATUS_ARCHIVED = 'archived';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SUBMITTED = 'submitted';
    public const BLOG_POST_STATUSES = [
        self::STATUS_ARCHIVED,
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
        self::STATUS_REJECTED,
        self::STATUS_SUBMITTED,
    ];

    public const TRANSITION_ARCHIVE = 'archive';
    public const TRANSITION_PUBLISH = 'publish';
    public const TRANSITION_REJECT = 'reject';
    public const TRANSITION_SUBMIT = 'submit';

    #[ORM\ManyToOne(inversedBy: 'blogPosts')]
    #[ORM\JoinColumn(name: 'blog_category_code', referencedColumnName: 'blog_category_code', nullable: false)]
    #[Assert\NotNull]
    private ?BlogCategory $blogCategory = null;

    #[ORM\OneToMany(mappedBy: 'blogPost', targetEntity: BlogPostComment::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPostComments;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    private ?Uuid $blogPostId = null;

    #[ORM\OneToMany(mappedBy: 'blogPost', targetEntity: BlogPostImage::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPostImages;

    #[ORM\Column(length: 4000)]
    #[Assert\NotNull]
    #[Assert\Length(max: 4000)]
    private ?string $content = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $featured = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[Assert\Length(max: 1000)]
    private ?string $remarks = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotNull]
    #[Assert\Length(max: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: self::BLOG_POST_STATUSES)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $tags = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotNull]
    #[Assert\Length(max: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    #[ORM\ManyToOne(inversedBy: 'blogPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    public function __construct()
    {
        $this->setStatus(self::STATUS_DRAFT);
        $this->blogPostComments = new ArrayCollection();
        $this->blogPostImages = new ArrayCollection();
    }

    public function addBlogPostComment(BlogPostComment $blogPostComment): static
    {
        if (!$this->blogPostComments->contains($blogPostComment)) {
            $this->blogPostComments->add($blogPostComment);
            $blogPostComment->setBlogPost($this);
        }

        return $this;
    }

    public function addBlogPostImage(BlogPostImage $blogPostImage): static
    {
        if (!$this->blogPostImages->contains($blogPostImage)) {
            $this->blogPostImages->add($blogPostImage);
            $blogPostImage->setBlogPost($this);
        }

        return $this;
    }

    public function getBlogCategory(): ?BlogCategory
    {
        return $this->blogCategory;
    }

    /**
     * @return Collection<int, BlogPostComment>
     */
    public function getBlogPostComments(): Collection
    {
        return $this->blogPostComments;
    }

    public function getBlogPostId(): ?Uuid
    {
        return $this->blogPostId;
    }

    /**
     * @return Collection<int, BlogPostImage>
     */
    public function getBlogPostImages(): Collection
    {
        return $this->blogPostImages;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getFeatured(): ?int
    {
        return $this->featured;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function removeBlogPostComment(BlogPostComment $blogPostComment): static
    {
        if ($this->blogPostComments->removeElement($blogPostComment)) {
            // set the owning side to null (unless already changed)
            if ($blogPostComment->getBlogPost() === $this) {
                $blogPostComment->setBlogPost(null);
            }
        }

        return $this;
    }

    public function removeBlogPostImage(BlogPostImage $blogPostImage): static
    {
        if ($this->blogPostImages->removeElement($blogPostImage)) {
            // set the owning side to null (unless already changed)
            if ($blogPostImage->getBlogPost() === $this) {
                $blogPostImage->setBlogPost(null);
            }
        }

        return $this;
    }

    public function setBlogCategory(?BlogCategory $blogCategory): static
    {
        $this->blogCategory = $blogCategory;

        return $this;
    }

    public function setBlogPostId(Uuid $blogPostId): static
    {
        $this->blogPostId = $blogPostId;

        return $this;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setFeatured(?int $featured): static
    {
        $this->featured = $featured;

        return $this;
    }

    public function setRemarks(?string $remarks): static
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

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

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function setUuid(Uuid $uuid): void
    {
        $this->blogPostId = $uuid;
    }
}
