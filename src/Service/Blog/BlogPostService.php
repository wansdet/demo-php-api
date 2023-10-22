<?php

declare(strict_types=1);

namespace App\Service\Blog;

use App\Entity\BlogPost;
use App\Entity\User;
use App\Repository\BlogPostRepository;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class BlogPostService
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository,
        private readonly TokenStorageInterface $tokenStorage,
    ) {
    }

    /**
     * @return array<BlogPost>
     *
     * @throws \Exception
     */
    public function findBlogPostsByAuthor(): array
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new UnauthorizedHttpException('Missing token');
        }

        /** @var User $author */
        $author = $token->getUser();

        if (!$author instanceof User) {
            throw new \Exception('User not found');
        }

        $criteria = ['author' => $author];
        $orderBy = ['createdAt' => 'DESC'];

        return $this->blogPostRepository->findBy($criteria, $orderBy);
    }

    /**
     * @return array<BlogPost>
     */
    public function findFeaturedBlogPosts(): array
    {
        return $this->blogPostRepository->findFeaturedBlogPosts();
    }

    /**
     * @param array<string, mixed> $criteria
     *
     * @return array<BlogPost>
     */
    public function findPublishedBlogPosts(array $criteria = []): array
    {
        $criteria = array_merge($criteria);

        return $this->blogPostRepository->findPublishedBlogPosts($criteria);
    }
}
