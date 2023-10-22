<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Information;
use App\Factory\InformationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class InformationFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['all'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create demo information with specified informationId for API testing
        InformationFactory::createSequence([
            [
                'informationId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da974'),
                'title' => $faker->sentence(6),
                'information' => $faker->paragraph(6),
                'informationType' => Information::TYPE_FAQ,
                'active' => true,
                'sortOrder' => 1,
                'createdBy' => 'SYSTEM',
                'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
            ],
            [
                'informationId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da975'),
                'title' => $faker->sentence(6),
                'information' => $faker->paragraph(6),
                'informationType' => Information::TYPE_FAQ,
                'active' => true,
                'sortOrder' => 2,
                'createdBy' => 'SYSTEM',
                'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
            ],
            [
                'informationId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da976'),
                'title' => $faker->sentence(6),
                'information' => $faker->paragraph(6),
                'informationType' => Information::TYPE_FAQ,
                'active' => true,
                'sortOrder' => 3,
                'createdBy' => 'SYSTEM',
                'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
            ],
            [
                'informationId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da977'),
                'title' => $faker->sentence(6),
                'information' => $faker->paragraph(6),
                'informationType' => Information::TYPE_FAQ,
                'active' => true,
                'sortOrder' => 4,
                'createdBy' => 'SYSTEM',
                'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
            ],
            [
                'informationId' => Uuid::fromString('3c2a5006-4bb7-3f5b-8711-8b111c8da978'),
                'title' => $faker->sentence(6),
                'information' => $faker->paragraph(6),
                'informationType' => Information::TYPE_FAQ,
                'active' => true,
                'sortOrder' => 5,
                'createdBy' => 'SYSTEM',
                'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
            ],
        ]);

        InformationFactory::createSequence(
            // Loop through 6 to 10 faq information
            static function () use ($faker) {
                foreach (range(6, 10) as $i) {
                    yield [
                        'informationId' => Uuid::fromString($faker->uuid()),
                        'title' => $faker->sentence(6),
                        'information' => $faker->paragraph(6),
                        'informationType' => Information::TYPE_FAQ,
                        'active' => true,
                        'sortOrder' => $i,
                        'createdBy' => 'SYSTEM',
                        'createdAt' => $faker->dateTimeInInterval('- 1 year', '+ 0 day'),
                    ];
                }
            }
        );
    }
}
