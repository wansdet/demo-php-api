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
use App\Controller\User\PasswordChangeController;
use App\Controller\User\UserAccountUpdateController;
use App\Repository\UserRepository;
use App\State\User\BlogAuthorsProvider;
use App\State\User\UserAccountProvider;
use App\State\User\UserPostProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(
            security: 'is_granted("ROLE_MODERATOR") or is_granted("ROLE_SALESPERSON") or is_granted("ROLE_FINANCE") or (is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier())',
        ),
        new Get(
            uriTemplate: '/user_account',
            normalizationContext: [
                'groups' => ['UserAccount:read'],
            ],
            security: 'is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier()',
            name: '_api_get_users_account',
            provider: UserAccountProvider::class,
        ),
        new GetCollection(
            normalizationContext: [
                'groups' => ['UserCollection:read'],
            ],
            security: 'is_granted("ROLE_MODERATOR") or is_granted("ROLE_SALESPERSON") or is_granted("ROLE_FINANCE")',
        ),
        new GetCollection(
            uriTemplate: '/users/blogs/authors',
            normalizationContext: [
                'groups' => ['UserPublic:read'],
            ],
            name: '_api_users_blog_authors',
            provider: BlogAuthorsProvider::class,
        ),
        new Post(
            denormalizationContext: [
                'groups' => ['User:write'],
            ],
            processor: UserPostProcessor::class,
        ),
        new Put(
            denormalizationContext: [
                'groups' => ['User:update'],
            ],
            security: 'is_granted("ROLE_ADMIN") or (is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier())',
        ),
        new Put(
            uriTemplate: '/user_account/{userId}',
            controller: UserAccountUpdateController::class,
            normalizationContext: [
                'groups' => ['UserAccount:read'],
            ],
            denormalizationContext: [
                'groups' => ['UserAccount:update'],
            ],
            security: 'is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier()',
            name: '_api_put_users_account',
        ),
        new Put(
            uriTemplate: '/user_password_change/{userId}',
            controller: PasswordChangeController::class,
            normalizationContext: [
                'groups' => ['UserAccount:read'],
            ],
            denormalizationContext: [
                'groups' => ['UserPassword:update'],
            ],
            security: 'is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier()',
            name: '_api_put_users_password_change',
        ),
        new Patch(
            denormalizationContext: [
                'groups' => ['User:update'],
            ],
            security: 'is_granted("ROLE_ADMIN") or (is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier())',
        ),
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    normalizationContext: [
        'groups' => ['User:read'],
    ],
    filters: [
        'user.search_filter',
        'user.order_filter',
    ],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, AuthoredEntityInterface, UuidInterface
{
    use TimestampsTrait;

    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const ROLE_BLOGGER = 'ROLE_BLOGGER';

    public const ROLE_EDITOR = 'ROLE_EDITOR';

    public const ROLE_FINANCE = 'ROLE_FINANCE';

    public const ROLE_MODERATOR = 'ROLE_MODERATOR';

    public const ROLE_SALES_MANAGER = 'ROLE_SALES_MANAGER';

    public const ROLE_SALESPERSON = 'ROLE_SALESPERSON';

    public const ROLE_USER = 'ROLE_USER';

    public const SEX_FEMALE = 'female';

    public const SEX_MALE = 'male';

    public const SEX_NOT_SPECIFIED = 'not_specified';

    public const SEXES = [
        self::SEX_NOT_SPECIFIED,
        self::SEX_FEMALE,
        self::SEX_MALE,
    ];

    public const USER_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_EDITOR,
        self::ROLE_MODERATOR,
        self::ROLE_BLOGGER,
        self::ROLE_FINANCE,
        self::ROLE_SALES_MANAGER,
        self::ROLE_SALESPERSON,
        self::ROLE_USER,
    ];

    public const STATUS_ACTIVE = 'active';

    public const STATUS_ON_HOLD = 'on_hold';

    public const STATUS_PENDING = 'pending';

    public const STATUS_SUSPENDED = 'suspended';

    public const USER_STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_ON_HOLD,
        self::STATUS_PENDING,
        self::STATUS_SUSPENDED,
    ];

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: BlogPostComment::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPostComments;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: BlogPost::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPosts;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[Assert\NotBlank(groups: ['UserPassword:update'])]
    private ?string $currentPassword = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\Length(max: 500)]
    private ?string $description = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $displayName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dob = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Document::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $documents;

    #[ORM\Column(length: 180)]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $firstName = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotNull]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $middleName = null;

    #[Assert\NotBlank(groups: ['UserPassword:update'])]
    #[Assert\Length(min: 8, max: 30, groups: ['UserPassword:update'])]
    private ?string $newPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\Length(max: 255)]
    private ?string $remarks = null;

    /**
     * @var array <string>
     */
    #[ORM\Column]
    #[Assert\Choice(choices: self::USER_ROLES, multiple: true)]
    private array $roles = [];

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\Choice(choices: self::SEXES)]
    private ?string $sex = null;

    #[ORM\Column(length: 10)]
    #[Assert\Choice(choices: self::USER_STATUSES)]
    private ?string $status = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    private ?Uuid $userId = null;

    public function __construct()
    {
        $this->status = self::STATUS_ACTIVE;

        // On creation guarantee every user at least has ROLE_USER
        $this->roles[] = 'ROLE_USER';
        $this->blogPosts = new ArrayCollection();
        $this->blogPostComments = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function addBlogPost(BlogPost $blogPost): static
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts->add($blogPost);
            $blogPost->setAuthor($this);
        }

        return $this;
    }

    public function addBlogPostComment(BlogPostComment $blogPostComment): static
    {
        if (!$this->blogPostComments->contains($blogPostComment)) {
            $this->blogPostComments->add($blogPostComment);
            $blogPostComment->setAuthor($this);
        }

        return $this;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setUser($this);
        }

        return $this;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection<int, BlogPostComment>
     */
    public function getBlogPostComments(): Collection
    {
        return $this->blogPostComments;
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

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getName(): ?string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function getUserId(): ?Uuid
    {
        return $this->userId;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function removeBlogPost(BlogPost $blogPost): static
    {
        if ($this->blogPosts->removeElement($blogPost)) {
            // set the owning side to null (unless already changed)
            if ($blogPost->getAuthor() === $this) {
                $blogPost->setAuthor(null);
            }
        }

        return $this;
    }

    public function removeBlogPostComment(BlogPostComment $blogPostComment): static
    {
        if ($this->blogPostComments->removeElement($blogPostComment)) {
            // set the owning side to null (unless already changed)
            if ($blogPostComment->getAuthor() === $this) {
                $blogPostComment->setAuthor(null);
            }
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getUser() === $this) {
                $document->setUser(null);
            }
        }

        return $this;
    }

    public function setCreatedBy(string $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function setCurrentPassword(?string $currentPassword): static
    {
        $this->currentPassword = $currentPassword;

        return $this;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setDisplayName(?string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function setDob(?\DateTimeInterface $dob): static
    {
        $this->dob = $dob;

        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setJobTitle(?string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setMiddleName(?string $middleName): static
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function setNewPassword(?string $newPassword): static
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function setRemarks(?string $remarks): static
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function setSex(?string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function setUpdatedBy(?string $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function setUserId(Uuid $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function setUuid(Uuid $uuid): void
    {
        $this->userId = $uuid;
    }
}
