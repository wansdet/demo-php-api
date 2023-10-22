<?php

declare(strict_types=1);

namespace App\Controller\Blog\Reports;

use App\Service\Blog\Reports\BlogPostsMonthlyAuthorsService;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class BlogPostsMonthlyAuthorsController
{
    public function __construct(private readonly BlogPostsMonthlyAuthorsService $blogPostsMonthlyAuthorsService)
    {
    }

    /**
     * @return array<int<0, max>, array<string, array<int<0, max>, array<string, mixed>>|int<0, max>>>
     */
    public function __invoke(): array
    {
        return $this->blogPostsMonthlyAuthorsService->findMonthlyBlogPostsByAuthorsReport();
    }
}
