<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\Entity\Country;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 *
 * @coversNothing
 */
final class UserUnitTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testGetId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testSetGetEmail(): void
    {
        $email = 'test@email.com';
        $this->user->setEmail($email);
        $this->assertEquals($email, $this->user->getEmail());
    }

    public function testSetGetRoles(): void
    {
        $roles = [User::ROLE_USER, User::ROLE_EDITOR];
        $this->user->setRoles($roles);
        $this->assertEquals($roles, $this->user->getRoles());
    }

    public function testSetGetPassword(): void
    {
        $password = 'password';
        $this->user->setPassword($password);
        $this->assertEquals($password, $this->user->getPassword());
    }

    public function testSetGetCurrentPassword(): void
    {
        $currentPassword = 'current password';
        $this->user->setCurrentPassword($currentPassword);
        $this->assertEquals($currentPassword, $this->user->getCurrentPassword());
    }

    public function testSetGetNewPassword(): void
    {
        $newPassword = 'new password';
        $this->user->setNewPassword($newPassword);
        $this->assertEquals($newPassword, $this->user->getNewPassword());
    }

    public function testSetGetUserId(): void
    {
        $userId = Uuid::v4();
        $this->user->setUserId($userId);
        $this->assertEquals($userId, $this->user->getUserId());
    }

    public function testGetUserIdentifier(): void
    {
        $email = 'dave@eaxmple.com';
        $this->user->setEmail($email);
        self::assertEquals($email, $this->user->getUserIdentifier());
    }

    public function testSetGetTitle(): void
    {
        $title = User::TITLE_MR;
        $this->user->setTitle($title);
        $this->assertEquals($title, $this->user->getTitle());
    }

    public function testSetGetFirstName(): void
    {
        $firstName = 'John';
        $this->user->setFirstName($firstName);
        $this->assertEquals($firstName, $this->user->getFirstName());
    }

    public function testSetGetLastName(): void
    {
        $lastName = 'Doe';
        $this->user->setLastName($lastName);
        $this->assertEquals($lastName, $this->user->getLastName());
    }

    public function testSetGetMiddleName(): void
    {
        $middleName = 'Smith';
        $this->user->setMiddleName($middleName);
        $this->assertEquals($middleName, $this->user->getMiddleName());
    }

    public function testSetGetGender(): void
    {
        $gender = User::GENDER_MALE;
        $this->user->setGender($gender);
        $this->assertEquals($gender, $this->user->getGender());
    }

    public function testSetGetBirthYear(): void
    {
        $birthYear = 1990;
        $this->user->setBirthYear($birthYear);
        $this->assertEquals($birthYear, $this->user->getBirthYear());
    }

    public function testSetGetDisplayName(): void
    {
        $displayName = 'johndoe';
        $this->user->setDisplayName($displayName);
        $this->assertEquals($displayName, $this->user->getDisplayName());
    }

    public function testSetGetJobTitle(): void
    {
        $jobTitle = 'Software Engineer';
        $this->user->setJobTitle($jobTitle);
        $this->assertEquals($jobTitle, $this->user->getJobTitle());
    }

    public function testSetGetDescription(): void
    {
        $description = 'User description';
        $this->user->setDescription($description);
        $this->assertEquals($description, $this->user->getDescription());
    }

    public function testSetGetCustomerNumber(): void
    {
        $customerNumber = 123456;
        $this->user->setCustomerNumber($customerNumber);
        $this->assertEquals($customerNumber, $this->user->getCustomerNumber());
    }

    public function testSetGetStatus(): void
    {
        $status = User::STATUS_ACTIVE;
        $this->user->setStatus($status);
        $this->assertEquals($status, $this->user->getStatus());
    }

    public function testSetGetCreatedBy(): void
    {
        $createdBy = 'user12';
        $this->user->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $this->user->getCreatedBy());
    }

    public function testSetGetCreatedAt(): void
    {
        $createdAt = new \DateTimeImmutable();
        $this->user->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $this->user->getCreatedAt());
    }

    public function testSetGetUpdatedBy(): void
    {
        $updatedBy = 'user13';
        $this->user->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $this->user->getUpdatedBy());
    }

    public function testSetGetUpdatedAt(): void
    {
        $updatedAt = new \DateTimeImmutable();
        $this->user->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $this->user->getUpdatedAt());
    }

    public function testAddRemoveBlogPost(): void
    {
        $blogPost = new BlogPost();
        $blogPost->setBlogPostId(Uuid::v4());
        $this->user->addBlogPost($blogPost);
        self::assertCount(1, $this->user->getBlogPosts());
        self::assertEquals($this->user, $blogPost->getAuthor());
        $this->user->removeBlogPost($blogPost);
        self::assertCount(0, $this->user->getBlogPosts());
        self::assertNull($blogPost->getAuthor());
    }

    public function testAddRemoveBlogPostComment(): void
    {
        $blogPostComment = new BlogPostComment();
        $blogPostComment->setBlogPostCommentId(Uuid::v4());
        $this->user->addBlogPostComment($blogPostComment);
        self::assertCount(1, $this->user->getBlogPostComments());
        self::assertEquals($this->user, $blogPostComment->getAuthor());
        $this->user->removeBlogPostComment($blogPostComment);
        self::assertCount(0, $this->user->getBlogPostComments());
        self::assertNull($blogPostComment->getAuthor());
    }

    public function testSetGetCountry(): void
    {
        $country = new Country();
        $country->setId('GB');
        $this->user->setCountry($country);
        $this->assertEquals($country, $this->user->getCountry());
    }
}
