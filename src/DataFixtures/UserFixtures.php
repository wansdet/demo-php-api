<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['user', 'blog_post', 'all'];
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
                    'firstName' => 'Jane',
                    'lastName' => 'Richards',
                    'middleName' => 'Elizabeth',
                    'displayName' => 'janrich',
                    'jobTitle' => 'IT Support Manager',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_ADMIN],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.$beginDays.' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('607093b1-e702-4618-8ac9-52cf52afc9fb'),
                ],
                [
                    'email' => 'admin2@example.com',
                    'firstName' => 'David',
                    'lastName' => 'Williams',
                    'middleName' => '',
                    'displayName' => 'davwil',
                    'jobTitle' => 'IT Support Administrator',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_ADMIN],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.$beginDays.' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('f878ec83-5956-46c5-8678-16688378738e'),
                ],
                [
                    'email' => 'editor1@example.com',
                    'firstName' => 'Lizzie',
                    'lastName' => 'Jones',
                    'middleName' => '',
                    'displayName' => 'lizjon',
                    'jobTitle' => 'Chief Editor',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_EDITOR],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 1).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('0c9bda34-4a8a-4364-9f4c-0578dbad85e8'),
                ],
                [
                    'email' => 'editor2@example.com',
                    'firstName' => 'Kevin',
                    'lastName' => 'McDonald',
                    'middleName' => 'John',
                    'displayName' => 'kevmcd',
                    'jobTitle' => 'Editor',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_EDITOR],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 1).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('28b2915e-d054-46d4-bc0b-b674eebfad30'),
                ],
                [
                    'email' => 'moderator1@example.com',
                    'firstName' => 'Kelly',
                    'lastName' => 'Stephens',
                    'middleName' => 'Anne',
                    'displayName' => 'kelste',
                    'jobTitle' => 'Moderator',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_MODERATOR],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 2).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('98e2d981-dfb5-4258-a14f-e2bc9260345f'),
                ],
                [
                    'email' => 'moderator2@example.com',
                    'firstName' => 'Richard',
                    'lastName' => 'Harris',
                    'middleName' => '',
                    'displayName' => 'richar',
                    'jobTitle' => 'Moderator',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_MODERATOR],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 2).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('b0c7840e-b12e-4798-8ba2-6e2debf648b8'),
                ],
                [
                    'email' => 'ceo1@example.com',
                    'firstName' => 'Christopher',
                    'lastName' => 'Roberts',
                    'middleName' => 'James',
                    'displayName' => 'chrrob',
                    'jobTitle' => 'CEO',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_SALES_MANAGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 3).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('b3d288cb-219e-43a1-85f8-afb9d8f4f9ef'),
                ],
                [
                    'email' => 'ceo2@example.com',
                    'firstName' => 'Isabella',
                    'lastName' => 'Walker',
                    'middleName' => 'Grace',
                    'displayName' => 'isawal',
                    'jobTitle' => 'CEO',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_FINANCE],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 3).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('45c5f5a0-0359-495b-8166-eba359f983cc'),
                ],
                [
                    'email' => 'finance.director@example.com',
                    'firstName' => 'Katherine',
                    'lastName' => 'Sutton',
                    'middleName' => 'Emily',
                    'displayName' => 'katemsu',
                    'jobTitle' => 'Finance Director',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_FINANCE],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 4).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('3a14d373-8abf-49e7-8c11-3792f0e186db'),
                ],
                [
                    'email' => 'sales.manager1@example.com',
                    'firstName' => 'Peter',
                    'lastName' => 'Brown',
                    'middleName' => 'John',
                    'displayName' => 'petbro',
                    'jobTitle' => 'Sales Manager',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_SALES_MANAGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 4).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('b1eae402-25b3-48b4-bcbc-cc36711fa223'),
                ],
                [
                    'email' => 'salesperson1@example.com',
                    'firstName' => 'Michael',
                    'lastName' => 'Hill',
                    'middleName' => 'David',
                    'displayName' => 'michil',
                    'jobTitle' => 'Salesperson',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_SALESPERSON],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('4a1c67fd-8a0c-45ac-9884-ad45dfe04c95'),
                ],
                [
                    'email' => 'salesperson2@example.com',
                    'firstName' => 'Jessica',
                    'lastName' => 'Baker',
                    'middleName' => 'Emma',
                    'displayName' => 'jesbak',
                    'jobTitle' => 'Salesperson',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_SALESPERSON],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('9d74f473-d11c-4995-9e38-b628d17a6beb'),
                ],
                [
                    'email' => 'salesperson3@example.com',
                    'firstName' => 'William',
                    'lastName' => 'Carter',
                    'middleName' => 'James',
                    'displayName' => 'wilcar',
                    'jobTitle' => 'Salesperson',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_SALESPERSON],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('2afc7f9a-44e2-44af-b60f-0443a196f996'),
                ],
                [
                    'email' => 'salesperson4@example.com',
                    'firstName' => 'Emma',
                    'lastName' => 'Mitchell',
                    'middleName' => 'Olivia',
                    'displayName' => 'emmmit',
                    'jobTitle' => 'Salesperson',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_SALESPERSON],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('0624a344-ef98-4897-b02d-12327ca76970'),
                ],
                [
                    'email' => 'salesperson5@example.com',
                    'firstName' => 'David',
                    'lastName' => 'Turner',
                    'middleName' => 'Daniel',
                    'displayName' => 'davtur',
                    'jobTitle' => 'Salesperson',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_SALESPERSON],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('7612c461-d36f-48bd-b368-31fbbf34ebd8'),
                ],
                [
                    'email' => 'salesperson6@example.com',
                    'firstName' => 'Daniel',
                    'lastName' => 'Phillips',
                    'middleName' => 'Christopher',
                    'displayName' => 'danphi',
                    'jobTitle' => 'Salesperson',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_SALESPERSON],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('50ac1a60-8b15-40ed-9fca-410204161dd1'),
                ],
                [
                    'email' => 'blogauthor1@example.com',
                    'firstName' => 'Robert',
                    'lastName' => 'Walker',
                    'middleName' => 'Joseph',
                    'displayName' => 'robwal',
                    'jobTitle' => 'Blog Post Author',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('c8beca68-00e9-4efd-a113-a893e8afbbbe'),
                ],
                [
                    'email' => 'blogauthor2@example.com',
                    'firstName' => 'Venessa',
                    'lastName' => 'Hall',
                    'middleName' => 'Maria',
                    'displayName' => 'venhal',
                    'jobTitle' => 'Blog Post Author',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
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
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('f5662592-3363-421d-a4ce-c45b4d0d96d4'),
                ],
                [
                    'email' => 'blogauthor4@example.com',
                    'firstName' => 'Madeleine',
                    'lastName' => 'Allen',
                    'middleName' => 'Grace',
                    'displayName' => 'madall',
                    'jobTitle' => 'Blog Post Author',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('a50b013c-ad0d-422b-96b4-7b04031a8f41'),
                ],
                [
                    'email' => 'blogauthor5@example.com',
                    'firstName' => 'Bethany',
                    'lastName' => 'Harris',
                    'middleName' => 'Ann',
                    'displayName' => 'bethhar',
                    'jobTitle' => 'Blog Post Author',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_BLOGGER],
                    'status' => User::STATUS_ACTIVE,
                    'description' => $faker->paragraph($faker->numberBetween(4, 6)),
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 5).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('8a9272af-2b6f-43c2-bbb9-dcc285084342'),
                ],
                [
                    'email' => 'user1@example.com',
                    'firstName' => 'Mary',
                    'lastName' => 'Smith',
                    'middleName' => 'Jane',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 10).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('0b9cc91f-c6e1-45cc-a3ce-a4bf4c8b84b7'),
                ],
                [
                    'email' => 'user2@example.net',
                    'firstName' => 'John',
                    'lastName' => 'Richards',
                    'middleName' => 'Henry',
                    'roles' => [User::ROLE_USER],
                    'sex' => User::SEX_MALE,
                    'status' => User::STATUS_ACTIVE,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 11).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('cb980fc0-92fc-48c3-9a8c-06006be3131d'),
                ],
                [
                    'email' => 'user.3@example.org',
                    'firstName' => 'Catherine',
                    'lastName' => 'Jones',
                    'middleName' => 'Elena',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_PENDING,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 12).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('520bd486-00fe-4248-9275-74901ec1c325'),
                ],
                [
                    'email' => 'user.4@example.com',
                    'firstName' => 'Christopher',
                    'lastName' => 'Parry',
                    'middleName' => '',
                    'sex' => User::SEX_MALE,
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_ON_HOLD,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 13).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('df8c44a0-fcef-470c-9d9e-978345264a93'),
                ],
                [
                    'email' => 'user.5@example.net',
                    'firstName' => 'Theresa',
                    'lastName' => 'McDonald',
                    'middleName' => '',
                    'sex' => User::SEX_FEMALE,
                    'roles' => [User::ROLE_USER],
                    'status' => User::STATUS_SUSPENDED,
                    'createdAt' => $faker->dateTimeInInterval('-'.($beginDays - 14).' days', '+ 0 day'),
                    'createdBy' => 'SYSTEM',
                    'userId' => Uuid::fromString('12d4a5a3-701c-4a91-a61a-87c20c42bd61'),
                ],
                [
                    'email' => 'user.6@example.com',
                    'firstName' => 'Nicholas',
                    'lastName' => 'Morris',
                    'middleName' => 'Kevin',
                    'roles' => [User::ROLE_USER],
                    'sex' => User::SEX_MALE,
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
                    $sexSelect = $faker->randomElement(['male', 'female']);

                    if ('male' === $sexSelect) {
                        $firstName = $faker->firstNameMale();
                        $sex = User::SEX_MALE;
                    } else {
                        $firstName = $faker->firstNameFemale();
                        $sex = User::SEX_FEMALE;
                    }

                    $lastName = $faker->lastName();
                    $email = strtolower('user.'.$i.'@'.$faker->safeEmailDomain());

                    yield [
                        'email' => $email,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'middleName' => '',
                        'sex' => $sex,
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
