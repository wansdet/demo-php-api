<?php

declare(strict_types=1);

namespace App\Service\Blog\Reports;

use App\Repository\BlogCategoryRepository;
use App\Repository\BlogPostRepository;

class BlogPostsMonthlyCategoriesService
{
    public function __construct(
        private readonly BlogCategoryRepository $blogCategoryRepository,
        private readonly BlogPostRepository $blogPostRepository
    ) {
    }

    /**
     * @return array<int<0, max>, array<string, array<int<0, max>, array<string, mixed>>|int<0, max>>>
     */
    public function findMonthlyBlogPostsByCategoriesReport(): array
    {
        // 1. Start month and year is January 2022. Use javascript month i.e. 0 = January, the same as in the database
        $startMonth = 0;
        $startYear = 2022;

        // 2. End Date is current month and year
        $endDate = new \DateTime();
        $endMonth = (int) $endDate->format('m') - 1;
        $endYear = (int) $endDate->format('Y');

        // 3. Get all blog categories
        $blogCategories = $this->blogCategoryRepository->findAll();

        // 4. Get all blog posts by category count for month and year
        $monthlyBlogPostsByCategories = $this->blogPostRepository->findMonthlyBlogPostsByCategoriesReport();

        // 5. Loop through each year
        $response = [];

        for ($year = $startYear; $year <= $endYear; ++$year) {
            $currentEndMonth = $year !== $endYear ? 11 : $endMonth;

            // 5.1 Loop through each month
            for ($month = $startMonth; $month <= $currentEndMonth; ++$month) {
                $blogPostCategories = [];
                // 5.1.1 Loop through each blog category
                foreach ($blogCategories as $blogCategory) {
                    $blogPostCount = 0;
                    // 5.1.2 Find blog posts by category count for current month and year
                    foreach ($monthlyBlogPostsByCategories as $monthlyBlogPostsByCategory) {
                        if ($monthlyBlogPostsByCategory['month'] === $month && $monthlyBlogPostsByCategory['year'] === $year && $blogCategory->getBlogCategoryName() === $monthlyBlogPostsByCategory['blogCategoryName']) {
                            $blogPostCount = $monthlyBlogPostsByCategory['blogPostCount'];

                            break;
                        }
                    }
                    // 5.1.3 Set blog post count for month and year and blog category
                    $blogPostCategory['blogPostCount'] = $blogPostCount;
                    $blogPostCategory['blogCategoryName'] = $blogCategory->getBlogCategoryName();
                    $blogPostCategories[] = $blogPostCategory;
                }

                // 5.1.4 Add result to response array
                $response[] = [
                    'blogPostCategories' => $blogPostCategories,
                    'month' => $month,
                    'year' => $year,
                ];
            }
        }

        return $response;
    }
}
