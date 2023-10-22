<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
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

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'bchambers';
        $this->user->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->user->getCreatedBy());
    }

    public function testGetSetCurrentPassword(): void
    {
        $currentPassword = 'current password';
        $this->user->setCurrentPassword($currentPassword);
        self::assertEquals($currentPassword, $this->user->getCurrentPassword());
    }

    public function testGetSetDisplayName(): void
    {
        $displayName = 'aanderson';
        $this->user->setDisplayName($displayName);
        self::assertEquals($displayName, $this->user->getDisplayName());
    }

    public function testGetSetDob(): void
    {
        $dob = new \DateTime();
        $this->user->setDob($dob);
        self::assertEquals($dob, $this->user->getDob());
    }

    public function testGetSetEmail(): void
    {
        $email = 'test.user@example.com';
        $this->user->setEmail($email);
        self::assertEquals($email, $this->user->getEmail());
    }

    public function testGetSetFirstName(): void
    {
        $firstName = 'Alana';
        $this->user->setFirstName($firstName);
        self::assertEquals($firstName, $this->user->getFirstName());
    }

    public function testGetSetLastName(): void
    {
        $lastName = 'Anderson';
        $this->user->setLastName($lastName);
        self::assertEquals($lastName, $this->user->getLastName());
    }

    public function testGetSetMiddleName(): void
    {
        $middleName = 'Jane';
        $this->user->setMiddleName($middleName);
        self::assertEquals($middleName, $this->user->getMiddleName());
    }

    public function testGetSetNewPassword(): void
    {
        $newPassword = 'new password';
        $this->user->setNewPassword($newPassword);
        self::assertEquals($newPassword, $this->user->getNewPassword());
    }

    public function testGetSetPassword(): void
    {
        $password = 'password';
        $this->user->setPassword($password);
        self::assertEquals($password, $this->user->getPassword());
    }

    public function testGetSetRoles(): void
    {
        $roles = ['ROLE_EDITOR'];
        $this->user->setRoles($roles);
        self::assertEquals($roles, $this->user->getRoles());
    }

    public function testGetSetSex(): void
    {
        $sex = 'female';
        $this->user->setSex($sex);
        self::assertEquals($sex, $this->user->getSex());
    }

    public function testGetSetStatus(): void
    {
        $status = 'active';
        $this->user->setStatus($status);
        self::assertEquals($status, $this->user->getStatus());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'cdaniels';
        $this->user->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->user->getUpdatedBy());
    }

    public function testGetSetUserId(): void
    {
        $userId = Uuid::v4();
        $this->user->setUserId($userId);
        self::assertEquals($userId, $this->user->getUserId());
    }

    public function testGetUserIdentifier(): void
    {
        $email = 'dave@eaxmple.com';
        $this->user->setEmail($email);
        self::assertEquals($email, $this->user->getUserIdentifier());
    }
}
