<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class BlogCategoryUnitTest extends TestCase
{
    private BlogCategory $blogCategory;

    protected function setUp(): void
    {
        $this->blogCategory = new BlogCategory();
    }

    public function testGetAddRemoveBlogPosts(): void
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('Test Blog post Title');
        $blogPost->setContent('Test blog post content');
        $blogPost->setCreatedBy('Test User');
        $blogPost->setUpdatedBy('Test User');

        $this->blogCategory->addBlogPost($blogPost);
        self::assertInstanceOf(ArrayCollection::class, $this->blogCategory->getBlogPosts());
        self::assertEquals(1, $this->blogCategory->getBlogPosts()->count());

        $this->blogCategory->removeBlogPost($blogPost);
        self::assertEquals(0, $this->blogCategory->getBlogPosts()->count());
    }

    public function testGetSetActive(): void
    {
        $active = true;
        $this->blogCategory->setActive($active);
        self::assertEquals($active, $this->blogCategory->isActive());
    }

    public function testGetSetBlogCategoryCode(): void
    {
        $blogCategoryCode = 'COOKERY';
        $this->blogCategory->setBlogCategoryCode($blogCategoryCode);
        self::assertEquals($blogCategoryCode, $this->blogCategory->getBlogCategoryCode());
    }

    public function testGetSetBlogCategoryName(): void
    {
        $blogCategoryName = 'Leisure';
        $this->blogCategory->setBlogCategoryName($blogCategoryName);
        self::assertEquals($blogCategoryName, $this->blogCategory->getBlogCategoryName());
    }

    public function testGetSetCreatedBy(): void
    {
        $createdBy = 'Test User';
        $this->blogCategory->setCreatedBy($createdBy);
        self::assertEquals($createdBy, $this->blogCategory->getCreatedBy());
    }

    public function testGetSetSortOrder(): void
    {
        $sortOrder = 6;
        $this->blogCategory->setSortOrder($sortOrder);
        self::assertEquals($sortOrder, $this->blogCategory->getSortOrder());
    }

    public function testGetSetUpdatedBy(): void
    {
        $updatedBy = 'Test User';
        $this->blogCategory->setUpdatedBy($updatedBy);
        self::assertEquals($updatedBy, $this->blogCategory->getUpdatedBy());
    }
}
