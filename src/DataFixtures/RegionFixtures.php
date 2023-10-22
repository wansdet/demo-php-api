<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\RegionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RegionFixtures extends Fixture implements FixtureGroupInterface
{
    use DataFixturesTrait;

    /**
     * @var array<int, mixed>
     */
    private array $regions = [
        [
            'regionCode' => 'AFRICA',
            'regionName' => 'Africa',
            'active' => true,
            'sortOrder' => 1,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'ASIA',
            'regionName' => 'Asia',
            'active' => true,
            'sortOrder' => 2,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'CARIBBEAN',
            'regionName' => 'Caribbean',
            'active' => true,
            'sortOrder' => 3,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'EUROPE',
            'regionName' => 'Europe',
            'active' => true,
            'sortOrder' => 4,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'MIDDLE_EAST',
            'regionName' => 'Middle East',
            'active' => true,
            'sortOrder' => 5,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'OCEANIA',
            'regionName' => 'Oceania',
            'active' => true,
            'sortOrder' => 6,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'NORTH_AMERICA',
            'regionName' => 'North America',
            'active' => true,
            'sortOrder' => 7,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'CENTRAL_AMERICA',
            'regionName' => 'Central America',
            'active' => true,
            'sortOrder' => 8,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'SOUTH_AMERICA',
            'regionName' => 'South America',
            'active' => true,
            'sortOrder' => 9,
            'createdBy' => 'SYSTEM',
        ],
        [
            'regionCode' => 'ANTARCTICA',
            'regionName' => 'Antarctica',
            'active' => true,
            'sortOrder' => 10,
            'createdBy' => 'SYSTEM',
        ],
    ];

    public static function getGroups(): array
    {
        return ['region', 'country', 'user', 'blog_post', 'all'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        RegionFactory::createSequence(
            function () use ($faker) {
                foreach ($this->regions as $region) {
                    yield [
                        'regionCode' => $region['regionCode'],
                        'regionName' => $region['regionName'],
                        'active' => $region['active'],
                        'sortOrder' => $region['sortOrder'],
                        'createdBy' => $region['createdBy'],
                        'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
                    ];
                }
            }
        );
    }
}
