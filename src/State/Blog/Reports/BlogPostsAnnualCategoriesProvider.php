<?php

declare(strict_types=1);

namespace App\State\Blog\Reports;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BlogPostRepository;

final class BlogPostsAnnualCategoriesProvider implements ProviderInterface
{
    public function __construct(private readonly BlogPostRepository $blogPostRepository)
    {
    }

    /**
     * @return array<int<0, max>, array<string, mixed>>|object|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $monthlyBlogPostsByCategoriesReport = $this->blogPostRepository->findAnnualBlogPostsByCategoriesReport();

        $response = [];
        $responseYears = [];
        $previousYear = 0;

        // Create array of unique years
        foreach ($monthlyBlogPostsByCategoriesReport as $report) {
            $year = $report['year'];

            if ($previousYear !== $year) {
                $responseYears[] = [
                    'year' => $year,
                ];
                $previousYear = $year;
            }
        }

        // Create response array of objects containing blogPostCategories array together with month and year
        foreach ($responseYears as $responseYear) {
            $year = $responseYear['year'];
            $blogPostCategories = [];

            foreach ($monthlyBlogPostsByCategoriesReport as $report) {
                if ($report['year'] === $year) {
                    $blogPostCategory['blogPostCount'] = $report['blogPostCount'];
                    $blogPostCategory['blogCategoryName'] = $report['blogCategoryName'];
                    $blogPostCategories[] = $blogPostCategory;
                }
            }

            $response[] = [
                'blogPostCategories' => $blogPostCategories,
                'year' => $year,
            ];
        }

        return $response;
    }
}
