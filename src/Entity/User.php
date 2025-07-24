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
            normalizationContext: [
                'groups' => ['User:read'],
            ],
            security: 'is_granted("ROLE_MODERATOR") or (is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier())',
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
            security: 'is_granted("ROLE_MODERATOR")',
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
        new Patch(
            normalizationContext: [
                'groups' => ['User:read'],
            ],
            denormalizationContext: [
                'groups' => ['User:update'],
            ],
            security: 'is_granted("ROLE_ADMIN")',
        ),
        new Patch(
            uriTemplate: '/user_account/{userId}',
            controller: UserAccountUpdateController::class,
            normalizationContext: [
                'groups' => ['UserAccount:read'],
            ],
            denormalizationContext: [
                'groups' => ['UserAccount:update'],
            ],
            security: 'is_granted("IS_AUTHENTICATED_FULLY") and object.getUserIdentifier() == user.getUserIdentifier()',
            name: '_api_put_users_account'
        ),
        new Patch(
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
        new Delete(
            security: 'is_granted("ROLE_ADMIN")',
        ),
    ],
    filters: [
        'user.search_filter',
        'user.order_filter',
    ],
    order: [
        'lastName' => 'ASC',
    ],
    paginationClientItemsPerPage: true,
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, UuidInterface, AuthoredEntityInterface
{
    use TimestampsTrait;

    public const ROLE_ACCOUNTS = 'ROLE_ACCOUNTS';

    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const ROLE_BLOGGER = 'ROLE_BLOGGER';

    public const ROLE_EDITOR = 'ROLE_EDITOR';

    public const ROLE_MODERATOR = 'ROLE_MODERATOR';

    public const ROLE_USER = 'ROLE_USER';

    public const USER_ROLES = [
        self::ROLE_ACCOUNTS,
        self::ROLE_ADMIN,
        self::ROLE_BLOGGER,
        self::ROLE_EDITOR,
        self::ROLE_MODERATOR,
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

    public const TITLE_MR = 'Mr';
    public const TITLE_MRS = 'Mrs';

    public const TITLE_MISS = 'Miss';

    public const TITLE_MS = 'Ms';
    public const TITLE_DR = 'Dr';
    public const TITLE_PROF = 'Prof';

    public const USER_TITLES = [
        self::TITLE_MR,
        self::TITLE_MRS,
        self::TITLE_MISS,
        self::TITLE_MS,
        self::TITLE_DR,
        self::TITLE_PROF,
    ];

    public const GENDER_FEMALE = 'female';

    public const GENDER_MALE = 'male';

    public const USER_GENDERS = [
        self::GENDER_FEMALE,
        self::GENDER_MALE,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    private ?string $email = null;

    /**
     * @var array <string>
     */
    #[ORM\Column]
    #[Assert\Choice(choices: self::USER_ROLES, multiple: true)]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\NotBlank(groups: ['UserPassword:update'])]
    private ?string $currentPassword = null;

    #[Assert\NotBlank(groups: ['UserPassword:update'])]
    #[Assert\Length(min: 8, max: 30, groups: ['UserPassword:update'])]
    private ?string $newPassword = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[ApiProperty(identifier: true)]
    private ?Uuid $userId = null;

    #[ORM\Column(length: 20)]
    #[Assert\Choice(choices: self::USER_TITLES)]
    private ?string $title = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotNull]
    #[Assert\Length(max: 50)]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotNull]
    #[Assert\Length(max: 50)]
    private ?string $lastName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $middleName = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\Choice(choices: self::USER_GENDERS)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $birthYear = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotNull]
    #[Assert\Length(max: 20)]
    private ?string $displayName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(max: 50)]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\Length(max: 500)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $customerNumber = null;

    #[ORM\Column(length: 10)]
    #[Assert\Choice(choices: self::USER_STATUSES)]
    private ?string $status = null;

    #[ORM\Column(length: 100)]
    #[Assert\Length(max: 100)]
    private ?string $createdBy = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\Length(max: 100)]
    private ?string $updatedBy = null;

    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'user', cascade: ['remove'], orphanRemoval: true)]
    private Collection $documents;

    #[ORM\OneToMany(targetEntity: BlogPost::class, mappedBy: 'author', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPosts;

    #[ORM\OneToMany(targetEntity: BlogPostComment::class, mappedBy: 'author', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPostComments;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Country $country = null;

    public function __construct()
    {
        $this->status = self::STATUS_ACTIVE;

        // On creation guarantee every user at least has ROLE_USER
        $this->roles[] = 'ROLE_USER';
        $this->documents = new ArrayCollection();
        $this->blogPosts = new ArrayCollection();
        $this->blogPostComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(string $currentPassword): static
    {
        $this->currentPassword = $currentPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): static
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserId(): ?Uuid
    {
        return $this->userId;
    }

    public function setUserId(Uuid $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): static
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function setBirthYear(?int $birthYear): static
    {
        $this->birthYear = $birthYear;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): static
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(?string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCustomerNumber(): ?int
    {
        return $this->customerNumber;
    }

    public function setCustomerNumber(?int $customerNumber): static
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function setUuid(Uuid $uuid): void
    {
        $this->userId = $uuid;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setUser($this);
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

    public function addBlogPost(BlogPost $blogPost): static
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts->add($blogPost);
            $blogPost->setAuthor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, BlogPost>
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
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

    public function addBlogPostComment(BlogPostComment $blogPostComment): static
    {
        if (!$this->blogPostComments->contains($blogPostComment)) {
            $this->blogPostComments->add($blogPostComment);
            $blogPostComment->setAuthor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, BlogPostComment>
     */
    public function getBlogPostComments(): Collection
    {
        return $this->blogPostComments;
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

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }
}
