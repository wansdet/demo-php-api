<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BlogPost;
use App\Entity\BlogPostImage;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class BlogPostImageUnitTest extends TestCase
{
    private BlogPostImage $blogPostImage;

    protected function setUp(): void
    {
        $this->blogPostImage = new BlogPostImage();
    }

    public function testGetSetBlogPost(): void
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('Blog post title');
        $this->blogPostImage->setBlogPost($blogPost);
        self::assertEquals($blogPost, $this->blogPostImage->getBlogPost());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'Meghan Johnson';
        $this->blogPostImage->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->blogPostImage->getCreatedBy());
    }

    public function testGetSetFilename(): void
    {
        $filename = 'blog-post-image-title.jpg';
        $this->blogPostImage->setFilename($filename);
        self::assertEquals($filename, $this->blogPostImage->getFilename());
    }

    public function testGetSetTitle(): void
    {
        $title = 'Blog post image title';
        $this->blogPostImage->setTitle($title);
        self::assertEquals($title, $this->blogPostImage->getTitle());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'Katie Moore';
        $this->blogPostImage->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->blogPostImage->getUpdatedBy());
    }
}
