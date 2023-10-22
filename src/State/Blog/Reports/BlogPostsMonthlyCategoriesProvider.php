<?php

declare(strict_types=1);

namespace App\State\Blog\Reports;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\BlogPostRepository;

final class BlogPostsMonthlyCategoriesProvider implements ProviderInterface
{
    public function __construct(private readonly BlogPostRepository $blogPostRepository)
    {
    }

    /**
     * @return array<int<0, max>, array<string, mixed>>|object|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {
        $monthlyBlogPostsByCategoriesReport = $this->blogPostRepository->findMonthlyBlogPostsByCategoriesReport();

        $response = [];
        $responseMonthYear = [];
        $previousMonth = 0;

        // Create array of unique month and year combinations
        foreach ($monthlyBlogPostsByCategoriesReport as $report) {
            $month = $report['month'] - 1;
            $year = $report['year'];

            if ($previousMonth !== $month) {
                $responseMonthYear[] = [
                    'month' => $month,
                    'year' => $year,
                ];
                $previousMonth = $month;
            }
        }

        // Create response array of objects containing blogPostCategories array together with month and year
        foreach ($responseMonthYear as $monthYear) {
            $month = $monthYear['month'];
            $year = $monthYear['year'];
            $blogPostCategories = [];

            foreach ($monthlyBlogPostsByCategoriesReport as $report) {
                if ($report['month'] - 1 === $month && $report['year'] === $year) {
                    $blogPostCategory['blogPostCount'] = $report['blogPostCount'];
                    $blogPostCategory['blogCategoryName'] = $report['blogCategoryName'];
                    $blogPostCategories[] = $blogPostCategory;
                }
            }

            $response[] = [
                'blogPostCategories' => $blogPostCategories,
                'month' => $month,
                'year' => $year,
            ];
        }

        return $response;
    }
}
