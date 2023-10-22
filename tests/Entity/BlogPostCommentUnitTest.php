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
final class BlogPostCommentUnitTest extends TestCase
{
    private BlogPostComment $blogPostComment;

    protected function setUp(): void
    {
        $this->blogPostComment = new BlogPostComment();
    }

    public function testGetSetBlogPost(): void
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('Blog post title');
        $this->blogPostComment->setBlogPost($blogPost);
        self::assertEquals($blogPost, $this->blogPostComment->getBlogPost());
    }

    public function testGetSetBlogPostCommentId(): void
    {
        $blogPostCommentId = Uuid::v4();
        $this->blogPostComment->setBlogPostCommentId($blogPostCommentId);
        self::assertEquals($blogPostCommentId, $this->blogPostComment->getBlogPostCommentId());
    }

    public function testGetSetComment(): void
    {
        $comment = 'Blog post comment';
        $this->blogPostComment->setComment($comment);
        self::assertEquals($comment, $this->blogPostComment->getComment());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'David Smith';
        $this->blogPostComment->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->blogPostComment->getCreatedBy());
    }

    public function testGetSetRating(): void
    {
        $rating = 8;
        $this->blogPostComment->setRating($rating);
        self::assertEquals($rating, $this->blogPostComment->getRating());
    }

    public function testGetSetStatus(): void
    {
        $status = BlogPostComment::STATUS_PUBLISHED;
        $this->blogPostComment->setStatus($status);
        self::assertEquals($status, $this->blogPostComment->getStatus());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'Chris Jones';
        $this->blogPostComment->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->blogPostComment->getUpdatedBy());
    }

    public function testGetSetAuthor(): void
    {
        $user = new User();
        $user->setEmail('test.user@example.com');
        $this->blogPostComment->setAuthor($user);
        self::assertEquals($user, $this->blogPostComment->getAuthor());
    }
}
