<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use App\Entity\User;
use App\Factory\BlogPostFactory;
use App\Repository\BlogCategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class BlogPostFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use DataFixturesTrait;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->seed(1234);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            BlogCategoryFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['blog_post', 'all'];
    }

    public function load(ObjectManager $manager): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = $manager->getRepository(User::class);
        $blogPostsUsers = $userRepository->findUsersByRole(User::ROLE_BLOGGER);

        /** @var BlogCategoryRepository $blogCategoryRepository */
        $blogCategoryRepository = $manager->getRepository(BlogCategory::class);
        $blogCategories = $blogCategoryRepository->findAll();

        BlogPostFactory::createSequence(
            function () use ($blogCategories, &$blogPostsUsers) {
                $totalBlogPosts = 293;
                $startDay = 300;
                $featuredTotal = 14;
                $featured = 10;

                foreach (range(1, $totalBlogPosts) as $i) {
                    $author = $blogPostsUsers[array_rand($blogPostsUsers)];
                    $blogCategory = $blogCategories[array_rand($blogCategories)];
                    $date = '-'.($startDay - $i).' days';

                    // var_dump('$i: '.$i.' :: $featuredTotal: '.$featuredTotal.' :: $featured: '.$featured);

                    $status = match ($i) {
                        286 => BlogPost::STATUS_ARCHIVED,
                        287 => BlogPost::STATUS_SUBMITTED,
                        288 => BlogPost::STATUS_REJECTED,
                        289 => BlogPost::STATUS_DRAFT,
                        default => BlogPost::STATUS_PUBLISHED,
                    };

                    $blogPost = [
                        'blogPostId' => Uuid::fromString($this->faker->uuid()),
                        'title' => $this->faker->sentence($this->faker->numberBetween(5, 7)),
                        'content' => $this->generateParagraphs(),
                        'status' => $status,
                        'slug' => $this->faker->slug(),
                        'featured' => $totalBlogPosts - $featuredTotal < $i ? $featured : null,
                        'createdAt' => $this->faker->dateTimeInInterval($date, '+ 0 day'),
                        'createdBy' => $author->getName(),
                        'author' => $author,
                        'blogCategory' => $blogCategory,
                    ];

                    yield $blogPost;

                    if ($totalBlogPosts - $featured < $i && BlogPost::STATUS_PUBLISHED == $status) {
                        --$featured;
                    }
                }
            }
        );

        // Create demo blogPost posts with specified blogPostId for Automation Testing
        BlogPostFactory::createSequence([
            [
                'blogPostId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da974'),
                'title' => 'Demo blog post',
                'content' => 'Welcome to the demo blog post. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_PUBLISHED,
                'slug' => 'welcome-to-the-demo-blog-post',
                'createdAt' => $this->faker->dateTimeInInterval('- 7 day', '+ 0 day'),
                'createdBy' => 'Robert Walker',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor1@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'TRAVEL']),
            ],
            [
                'blogPostId' => Uuid::fromString('af1b8f69-7074-39bc-9f2b-1250500be882'),
                'title' => 'Demo blog post for updates',
                'content' => 'Welcome to the demo blog post for Automation Testing. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_PUBLISHED,
                'slug' => 'welcome-to-the-demo-blog-post-automation-testing',
                'createdAt' => $this->faker->dateTimeInInterval('- 6 day', '+ 0 day'),
                'createdBy' => 'Victor Hall',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor2@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'COOKERY']),
            ],
            [
                'blogPostId' => Uuid::fromString('05f74dba-4759-3109-9de2-bc99004f914d'),
                'title' => 'Demo blog post with status ARCHIVED',
                'content' => 'Welcome to the demo blog post for Automation Testing with status ARCHIVED. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_ARCHIVED,
                'slug' => 'welcome-to-the-demo-blog-post-automation-testing-archived',
                'createdAt' => $this->faker->dateTimeInInterval('- 5 day', '+ 0 day'),
                'createdBy' => 'Robert Walker',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor1@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'TRAVEL']),
            ],
            [
                'blogPostId' => Uuid::fromString('dd5b3dfe-7756-3280-a439-7d33f22e859b'),
                'title' => 'Demo blog post with status PUBLISHED',
                'content' => 'Welcome to the demo blog post for Automation Testing with status PUBLISHED. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_PUBLISHED,
                'slug' => 'welcome-to-the-demo-blog-post-automation-testing-published',
                'createdAt' => $this->faker->dateTimeInInterval('- 4 day', '+ 0 day'),
                'createdBy' => 'Victor Hall',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor2@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'FOOD']),
            ],
            [
                'blogPostId' => Uuid::fromString('43f0cf60-26a9-3794-8407-862b5ed13745'),
                'title' => 'Demo blog post with status REJECTED',
                'content' => 'Welcome to the demo blog post for Automation Testing with status REJECTED. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_REJECTED,
                'slug' => 'welcome-to-the-demo-blog-post-automation-testing-rejected',
                'createdAt' => $this->faker->dateTimeInInterval('- 3 day', '+ 0 day'),
                'createdBy' => 'Karen Young',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor3@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'FASHION']),
            ],
            [
                'blogPostId' => Uuid::fromString('7a55a08e-29ea-3fd1-9d71-dea3cac6e8e0'),
                'title' => 'Demo blog post with status SUBMITTED',
                'content' => 'Welcome to the demo blog post for Automation Testing with status SUBMITTED. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_SUBMITTED,
                'slug' => 'welcome-to-the-demo-blog-post-automation-testing-submitted',
                'createdAt' => $this->faker->dateTimeInInterval('- 2 day', '+ 0 day'),
                'createdBy' => 'Michael Allen',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor4@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'TECHNOLOGY']),
            ],
            [
                'blogPostId' => Uuid::fromString('4619273a-eed3-38ae-95c9-3ee4007722a2'),
                'title' => 'Demo blog post with status DRAFT',
                'content' => 'Welcome to the demo blog post for Automation Testing with status DRAFT. '.$this->generateParagraphs(),
                'status' => BlogPost::STATUS_DRAFT,
                'slug' => 'welcome-to-the-demo-blog-post-automation-testing-draft',
                'createdAt' => $this->faker->dateTimeInInterval('- 1 day', '+ 0 day'),
                'createdBy' => 'Ben Harris',
                'author' => $userRepository->findOneBy(['email' => 'blogauthor5@example.com']),
                'blogCategory' => $blogCategoryRepository->findOneBy(['blogCategoryCode' => 'HOME']),
            ],
        ]);
    }
}
