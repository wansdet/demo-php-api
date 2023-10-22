<?php

declare(strict_types=1);

namespace App\State\Blog\Reports;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BlogPostRepository;

final class BlogPostsAnnualAuthorsProvider implements ProviderInterface
{
    public function __construct(private readonly BlogPostRepository $blogPostRepository)
    {
    }

    /**
     * @return array<int<0, max>, array<string, mixed>>|object|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $monthlyBlogPostsByAuthorsReport = $this->blogPostRepository->findAnnualBlogPostsByAuthorsReport();

        $response = [];
        $responseYears = [];
        $previousYear = 0;

        // Create array of unique years
        foreach ($monthlyBlogPostsByAuthorsReport as $report) {
            $year = $report['year'];

            if ($previousYear !== $year) {
                $responseYears[] = [
                    'year' => $year,
                ];
                $previousYear = $year;
            }
        }

        // Create response array of objects containing blogPostAuthors array together with month and year
        foreach ($responseYears as $responseYear) {
            $year = $responseYear['year'];
            $blogPostAuthors = [];

            foreach ($monthlyBlogPostsByAuthorsReport as $report) {
                if ($report['year'] === $year) {
                    $blogPostAuthor['blogPostCount'] = $report['blogPostCount'];
                    $blogPostAuthor['author'] = $report['author'];
                    $blogPostAuthors[] = $blogPostAuthor;
                }
            }

            $response[] = [
                'blogPostAuthors' => $blogPostAuthors,
                'year' => $year,
            ];
        }

        return $response;
    }
}
