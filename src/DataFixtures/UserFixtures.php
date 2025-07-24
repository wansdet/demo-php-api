<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['user', 'place', 'all'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $beginDays = 365;

        // Create internal users
        UserFactory::createSequence(
            [
                [
                    'email' => 'admin1@example.com',
                    'title' => User::TITLE_MRS,
                    'firstName' => 'Jane',
                    'lastName' => 'Richards',
                    'middleName' => 'Elizabeth',
                    'gender' => User::GENDER_FEMALE,
                    'displayName' => 'janrich',
                    'jobTitle' => 'IT Support Manager',
                    'description' => 'Jane Richards is the IT Support Manager.',
                    'roles' => [User::ROLE_ADMIN],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.$beginDays.' days', '+ 0 day'),
                    'userId' => Uuid::fromString('607093b1-e702-4618-8ac9-52cf52afc9fb'),
                ],
                [
                    'email' => 'admin2@example.com',
                    'title' => User::TITLE_MR,
                    'firstName' => 'David',
                    'lastName' => 'Williams',
                    'middleName' => '',
                    'gender' => User::GENDER_MALE,
                    'displayName' => 'davwil',
                    'jobTitle' => 'IT Support Administrator',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'roles' => [User::ROLE_ADMIN],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.$beginDays.' days', '+ 0 day'),
                    'userId' => Uuid::fromString('f878ec83-5956-46c5-8678-16688378738e'),
                ],
                [
                    'email' => 'editor1@example.com',
                    'title' => User::TITLE_MS,
                    'firstName' => 'Lizzie',
                    'lastName' => 'Jones',
                    'middleName' => '',
                    'gender' => User::GENDER_FEMALE,
                    'displayName' => 'lizjon',
                    'jobTitle' => 'Chief Editor',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'roles' => [User::ROLE_EDITOR],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 1).' days', '+ 0 day'),
                    'userId' => Uuid::fromString('0c9bda34-4a8a-4364-9f4c-0578dbad85e8'),
                ],
                [
                    'email' => 'editor2@example.com',
                    'title' => User::TITLE_MR,
                    'firstName' => 'Kevin',
                    'lastName' => 'McDonald',
                    'middleName' => 'John',
                    'gender' => User::GENDER_MALE,
                    'displayName' => 'kevmcd',
                    'jobTitle' => 'Editor',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'roles' => [User::ROLE_EDITOR],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 1).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('28b2915e-d054-46d4-bc0b-b674eebfad30'),
                ],
                [
                    'email' => 'moderator1@example.com',
                    'title' => User::TITLE_MRS,
                    'firstName' => 'Kelly',
                    'lastName' => 'Stephens',
                    'middleName' => 'Anne',
                    'gender' => User::GENDER_FEMALE,
                    'displayName' => 'kelste',
                    'jobTitle' => 'Moderator',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'roles' => [User::ROLE_MODERATOR],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 2).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('98e2d981-dfb5-4258-a14f-e2bc9260345f'),
                ],
                [
                    'email' => 'moderator2@example.com',
                    'title' => User::TITLE_MR,
                    'firstName' => 'Richard',
                    'lastName' => 'Harris',
                    'middleName' => '',
                    'gender' => User::GENDER_MALE,
                    'displayName' => 'richar',
                    'jobTitle' => 'Moderator',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'roles' => [User::ROLE_MODERATOR],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 2).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('b0c7840e-b12e-4798-8ba2-6e2debf648b8'),
                ],
                [
                    'email' => 'blogauthor1@example.com',
                    'firstName' => 'Robert',
                    'lastName' => 'Walker',
                    'middleName' => 'Joseph',
                    'displayName' => 'robwal',
                    'jobTitle' => 'Blog Post Author',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'gender' => User::GENDER_MALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('c8beca68-00e9-4efd-a113-a893e8afbbbe'),
                ],
                [
                    'email' => 'blogauthor2@example.com',
                    'firstName' => 'Victor',
                    'lastName' => 'Hall',
                    'middleName' => 'Maria',
                    'displayName' => 'vichal',
                    'jobTitle' => 'Blog Post Author',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'gender' => User::GENDER_MALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('9e1ff95b-5871-4117-b9e3-f711a58b634f'),
                ],
                [
                    'email' => 'blogauthor3@example.com',
                    'firstName' => 'Karen',
                    'lastName' => 'Young',
                    'middleName' => 'Elizabeth',
                    'displayName' => 'karyou',
                    'jobTitle' => 'Blog Post Author',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'gender' => User::GENDER_FEMALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('f5662592-3363-421d-a4ce-c45b4d0d96d4'),
                ],
                [
                    'email' => 'blogauthor4@example.com',
                    'firstName' => 'Michael',
                    'lastName' => 'Allen',
                    'middleName' => 'Grace',
                    'displayName' => 'madall',
                    'jobTitle' => 'Blog Post Author',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'gender' => User::GENDER_MALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('a50b013c-ad0d-422b-96b4-7b04031a8f41'),
                ],
                [
                    'email' => 'blogauthor5@example.com',
                    'firstName' => 'Ben',
                    'lastName' => 'Harris',
                    'middleName' => '',
                    'displayName' => 'benhar',
                    'jobTitle' => 'Blog Post Author',
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'gender' => User::GENDER_MALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('8a9272af-2b6f-43c2-bbb9-dcc285084342'),
                ],
                [
                    'email' => 'user1@example.com',
                    'title' => User::TITLE_MRS,
                    'firstName' => 'Aaliyah',
                    'lastName' => 'Aaron',
                    'middleName' => 'Jane',
                    'gender' => User::GENDER_FEMALE,
                    'displayName' => 'aalaar',
                    'jobTitle' => 'Freelance Photographer',
                    'description' => 'Aaliyah Aaron is a freelance photographer based in London.',
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 10).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7'),
                ],
                [
                    'email' => 'user2@example.net',
                    'title' => User::TITLE_MR,
                    'firstName' => 'John',
                    'lastName' => 'Richards',
                    'middleName' => 'Henry',
                    'gender' => User::GENDER_MALE,
                    'displayName' => 'jonric',
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 11).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('cb980fc0-92fc-48c3-9a8c-06006be3131d'),
                ],
                [
                    'email' => 'user3@example.org',
                    'title' => User::TITLE_MRS,
                    'firstName' => 'Catherine',
                    'lastName' => 'Jones',
                    'middleName' => 'Elena',
                    'gender' => User::GENDER_FEMALE,
                    'displayName' => 'catjon',
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_PENDING,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 12).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('520bd486-00fe-4248-9275-74901ec1c325'),
                ],
                [
                    'email' => 'user4@example.com',
                    'title' => User::TITLE_MR,
                    'firstName' => 'Christopher',
                    'lastName' => 'Parry',
                    'middleName' => '',
                    'gender' => User::GENDER_MALE,
                    'displayName' => 'chrpar',
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_ON_HOLD,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 13).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('df8c44a0-fcef-470c-9d9e-978345264a93'),
                ],
                [
                    'email' => 'user5@example.net',
                    'title' => User::TITLE_MS,
                    'firstName' => 'Theresa',
                    'lastName' => 'McDonald',
                    'middleName' => '',
                    'gender' => User::GENDER_FEMALE,
                    'displayName' => 'thrmcd',
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_SUSPENDED,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 14).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('12d4a5a3-701c-4a91-a61a-87c20c42bd61'),
                ],
                [
                    'email' => 'user6@example.com',
                    'title' => User::TITLE_MR,
                    'firstName' => 'Nicholas',
                    'lastName' => 'Morris',
                    'middleName' => 'Kevin',
                    'gender' => User::GENDER_MALE,
                    'displayName' => 'nicmor',
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 15).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('718e62a2-5f85-4da5-9524-61df1aa989a7'),
                ],
            ]
        );

        $totalOtherUsers = 59;
        $otherUsersBeginDays = 335;

        // Create other users
        UserFactory::createSequence(
            static function () use ($faker, $otherUsersBeginDays, $totalOtherUsers) {
                foreach (range(7, $totalOtherUsers) as $i) {
                    $randomNumber = $faker->numberBetween(1, 100);

                    if ($randomNumber <= 90) {
                        $firstName = $faker->firstNameMale();
                        $title = User::TITLE_MR;
                    } else {
                        $firstName = $faker->firstNameFemale();
                        if ($randomNumber <= 95) {
                            $title = User::TITLE_MS;
                        } else {
                            $title = User::TITLE_MRS;
                        }
                    }

                    $lastName = $faker->lastName();
                    // Set displayName to 1st 3 characters of firstName + 1st 3 characters of lastName + 3 random digits
                    $displayName = strtolower(substr($firstName, 0, 3).substr($lastName, 0, 3).$faker->randomNumber(3));

                    $email = strtolower('user'.$i.'@'.$faker->safeEmailDomain());

                    yield [
                        'title' => $title,
                        'email' => $email,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'displayName' => $displayName,
                        'roles' => ['ROLE_USER'],
                        'status' => User::STATUS_ACTIVE,
                        'createdAt' => $faker->dateTimeInInterval(
                            '-'.($otherUsersBeginDays - $i).' days',
                            '+ 0 day'
                        ),
                        'createdBy' => 'SYSTEM',
                        'userId' => Uuid::v4(),
                    ];
                }
            }
        );
    }
}
