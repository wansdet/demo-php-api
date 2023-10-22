<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BlogPost;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 *
 * @coversNothing
 */
final class BlogPostUnitTest extends TestCase
{
    private BlogPost $blogPost;

    protected function setUp(): void
    {
        $this->blogPost = new BlogPost();
    }

    public function testGetSetBlogPostId(): void
    {
        $blogPostId = Uuid::v4();
        $this->blogPost->setBlogPostId($blogPostId);
        self::assertEquals($blogPostId, $this->blogPost->getBlogPostId());
    }

    public function testGetSetContent(): void
    {
        $content = 'Blog post content';
        $this->blogPost->setContent($content);
        self::assertEquals($content, $this->blogPost->getContent());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'John Doe';
        $this->blogPost->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->blogPost->getCreatedBy());
    }

    public function testGetSetSlug(): void
    {
        $slug = 'blog-post-title';
        $this->blogPost->setSlug($slug);
        self::assertEquals($slug, $this->blogPost->getSlug());
    }

    public function testGetSetStatus(): void
    {
        $status = BlogPost::STATUS_PUBLISHED;
        $this->blogPost->setStatus($status);
        self::assertEquals($status, $this->blogPost->getStatus());
    }

    public function testGetSetTags(): void
    {
        $tags = 'blog post, tags';
        $this->blogPost->setTags($tags);
        self::assertEquals($tags, $this->blogPost->getTags());
    }

    public function testGetSetTitle(): void
    {
        $title = 'Blog post title';
        $this->blogPost->setTitle($title);
        self::assertEquals($title, $this->blogPost->getTitle());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'Jane Bloggs';
        $this->blogPost->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->blogPost->getUpdatedBy());
    }

    public function testGetSetAuthor(): void
    {
        $user = new User();
        $user->setEmail('test.user@example.com');
        $this->blogPost->setAuthor($user);
        self::assertEquals($user, $this->blogPost->getAuthor());
    }
}
