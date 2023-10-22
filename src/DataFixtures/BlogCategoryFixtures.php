<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\BlogCategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogCategoryFixtures extends Fixture implements FixtureGroupInterface
{
    use DataFixturesTrait;

    /**
     * @var array<int, mixed>
     */
    private array $blogCategories = [
        [
            'blogCategoryCode' => 'COOKERY',
            'blogCategoryName' => 'Cookery',
            'active' => true,
            'sortOrder' => 1,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'FASHION',
            'blogCategoryName' => 'Fashion',
            'active' => true,
            'sortOrder' => 2,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'FOOD',
            'blogCategoryName' => 'Food',
            'active' => true,
            'sortOrder' => 3,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'HOME',
            'blogCategoryName' => 'Home',
            'active' => true,
            'sortOrder' => 4,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'LEISURE',
            'blogCategoryName' => 'Leisure',
            'active' => true,
            'sortOrder' => 5,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'TECHNOLOGY',
            'blogCategoryName' => 'Technology',
            'active' => true,
            'sortOrder' => 6,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'TRANSPORT',
            'blogCategoryName' => 'Transport',
            'active' => true,
            'sortOrder' => 7,
            'createdBy' => 'SYSTEM',
        ],
        [
            'blogCategoryCode' => 'TRAVEL',
            'blogCategoryName' => 'Travel',
            'active' => true,
            'sortOrder' => 8,
            'createdBy' => 'SYSTEM',
        ],
    ];

    public static function getGroups(): array
    {
        return ['all', 'blog_post'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        BlogCategoryFactory::createSequence(
            function () use ($faker) {
                foreach ($this->blogCategories as $blogCategory) {
                    yield [
                        'blogCategoryCode' => $blogCategory['blogCategoryCode'],
                        'blogCategoryName' => $blogCategory['blogCategoryName'],
                        'active' => $blogCategory['active'],
                        'sortOrder' => $blogCategory['sortOrder'],
                        'createdBy' => $blogCategory['createdBy'],
                        'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
                    ];
                }
            }
        );
    }
}
