<?php

declare(strict_types=1);

namespace App\State\Blog\Post;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\Blog\BlogPostService;

final class PublishedBlogPostsProvider implements ProviderInterface
{
    public function __construct(
        private readonly BlogPostService $blogPostService
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $queryParams = $context['filters'] ?? [];

        return $this->blogPostService->findPublishedBlogPosts($queryParams);
    }
}
