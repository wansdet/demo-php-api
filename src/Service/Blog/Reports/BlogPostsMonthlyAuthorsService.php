<?php

declare(strict_types=1);

namespace App\Service\Blog\Reports;

use App\Entity\User;
use App\Repository\BlogPostRepository;
use App\Repository\UserRepository;

class BlogPostsMonthlyAuthorsService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly BlogPostRepository $blogPostRepository
    ) {
    }

    /**
     * @return array<int<0, max>, array<string, array<int<0, max>, array<string, mixed>>|int<0, max>>>
     */
    public function findMonthlyBlogPostsByAuthorsReport(): array
    {
        // 1. Start month and year is January 2022. Use javascript month i.e. 0 = January, the same as in the database
        $startMonth = 0;
        $startYear = 2022;

        // 2. End Date is current month and year
        $endDate = new \DateTime();
        $endMonth = (int) $endDate->format('m') - 1;
        $endYear = (int) $endDate->format('Y');

        // 3. Get all blog author
        $blogAuthors = $this->userRepository->findUsersByRole(User::ROLE_BLOGGER);

        // 4. Get all blog posts by category count for month and year
        $monthlyBlogPostsByAuthors = $this->blogPostRepository->findMonthlyBlogPostsByAuthorsReport();

        // 5. Loop through each year
        $response = [];

        for ($year = $startYear; $year <= $endYear; ++$year) {
            $currentEndMonth = $year !== $endYear ? 11 : $endMonth;

            // 5.1 Loop through each month
            for ($month = $startMonth; $month <= $currentEndMonth; ++$month) {
                $blogPostAuthors = [];
                // 5.1.1 Loop through each blog category
                foreach ($blogAuthors as $blogAuthor) {
                    $blogPostCount = 0;
                    // 5.1.2 Find blog posts by category count for current month and year
                    foreach ($monthlyBlogPostsByAuthors as $monthlyBlogPostsByAuthor) {
                        if ($monthlyBlogPostsByAuthor['month'] === $month && $monthlyBlogPostsByAuthor['year'] === $year && $blogAuthor->getName() === $monthlyBlogPostsByAuthor['author']) {
                            $blogPostCount = $monthlyBlogPostsByAuthor['blogPostCount'];

                            break;
                        }
                    }
                    // 5.1.3 Set blog post count for month and year and blog category
                    $blogPostAuthor['blogPostCount'] = $blogPostCount;
                    $blogPostAuthor['author'] = $blogAuthor->getName();
                    $blogPostAuthors[] = $blogPostAuthor;
                }

                // 5.1.4 Add result to response array
                $response[] = [
                    'blogPostAuthors' => $blogPostAuthors,
                    'month' => $month,
                    'year' => $year,
                ];
            }
        }

        return $response;
    }
}
