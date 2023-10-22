<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\Entity\User;
use App\Factory\BlogPostCommentFactory;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class BlogPostCommentFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
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
            BlogPostFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['all'];
    }

    public function load(ObjectManager $manager): void
    {
        /** @var UserRepository $authorRepository */
        $authorRepository = $manager->getRepository(User::class);
        $blogPostsUsers = $authorRepository->findUsersByRole(User::ROLE_USER);

        // Create demo blogPost post comments with specified blogPostCommentId for API testing
        BlogPostCommentFactory::createSequence([
            [
                'blogPostCommentId' => Uuid::fromString('564ed8cb-59d2-3bf6-a2b2-213b8f096c8a'),
                'comment' => 'Demo blog post comment. '.$this->faker->paragraph(),
                'rating' => 10,
                'status' => BlogPostComment::STATUS_PUBLISHED,
                'createdAt' => $this->faker->dateTimeInInterval('- 290 day', '+ 0 day'),
                'createdBy' => 'Mary Smith',
                'blogPost' => $manager->getRepository(BlogPost::class)->findOneBy(['blogPostId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da974')]),
                'author' => $authorRepository->findOneBy(['email' => 'user1@example.com']),
            ],
            [
                'blogPostCommentId' => Uuid::fromString('6578142c-b69a-3a05-8115-5f781b49b124'),
                'comment' => 'Demo blog post comment for API testing.',
                'rating' => 10,
                'status' => BlogPostComment::STATUS_PUBLISHED,
                'createdAt' => $this->faker->dateTimeInInterval('- 290 day', '+ 0 day'),
                'createdBy' => 'John Richards',
                'blogPost' => $manager->getRepository(BlogPost::class)->findOneBy(['blogPostId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da974')]),
                'author' => $authorRepository->findOneBy(['email' => 'user2@example.net']),
            ],
            [
                'blogPostCommentId' => Uuid::fromString('28b86172-470c-38a4-8ca5-8d27e07ef9be'),
                'comment' => 'Demo blog post comment for API testing with status PUBLISHED.',
                'rating' => 8,
                'status' => BlogPostComment::STATUS_PUBLISHED,
                'createdAt' => $this->faker->dateTimeInInterval('- 290 day', '+ 0 day'),
                'createdBy' => 'Catherine Jones',
                'blogPost' => $manager->getRepository(BlogPost::class)->findOneBy(['blogPostId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da974')]),
                'author' => $authorRepository->findOneBy(['email' => 'user.3@example.org']),
            ],
            [
                'blogPostCommentId' => Uuid::fromString('224ca37a-e8a3-3397-9c86-044fa9b44075'),
                'comment' => 'Demo blog post comment for API testing with status REJECTED.',
                'rating' => 8,
                'status' => BlogPostComment::STATUS_REJECTED,
                'createdAt' => $this->faker->dateTimeInInterval('- 290 day', '+ 0 day'),
                'createdBy' => 'Christopher Parry',
                'blogPost' => $manager->getRepository(BlogPost::class)->findOneBy(['blogPostId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da974')]),
                'author' => $authorRepository->findOneBy(['email' => 'user.4@example.com']),
            ],
        ]);

        // $blogPosts = $manager->getRepository(BlogPost::class)->findBy(['featured' => null]);
        $blogPosts = $manager->getRepository(BlogPost::class)->findAll();
        $totalBlogPosts = count($blogPosts);

        // Loop through all blogPosts and add comments
        $blogPostCounter = 0;
        foreach ($blogPosts as $blogPost) {
            ++$blogPostCounter;
            $totalComments = $this->faker->numberBetween(0, 3);

            $addDays = 2;
            foreach (range(1, $totalComments) as $i) {
                if ($blogPostCounter === $totalBlogPosts && $i === $totalComments) {
                    $status = BlogPostComment::STATUS_REJECTED;
                } else {
                    $status = BlogPostComment::STATUS_PUBLISHED;
                }

                $author = $blogPostsUsers[array_rand($blogPostsUsers)];
                $blogPostCreatedAt = $blogPost->getCreatedAt();
                $currentDate = new \DateTimeImmutable();
                $interval = $currentDate->diff($blogPostCreatedAt);
                $daysAgo = $interval->days;
                $createdAt = $this->faker->dateTimeInInterval('- '.$daysAgo.' day', '+ '.$addDays.' day');

                $comment = [
                    'blogPostCommentId' => Uuid::fromString($this->faker->uuid()),
                    'comment' => $this->faker->paragraph(),
                    'rating' => $this->faker->numberBetween(7, 10),
                    'status' => $status,
                    'createdAt' => $createdAt,
                    'createdBy' => $author->getName(),
                    'blogPost' => $blogPost,
                    'author' => $author,
                ];

                BlogPostCommentFactory::new()->create($comment);
            }
        }
    }
}
