# demo-php-api

This application is a real world demonstration of Symfony REST API using
[Symfony](https://symfony.com/),
[API Platform](https://api-platform.com/),
[Doctrine](https://www.doctrine-project.org/),
[MySQL](https://www.mysql.com/),
[PHPUnit](https://phpunit.de/) and
[Behat](https://behat.org/).

See demo-mui-frontend repo for accompanying ReactJS frontend.

Uses Doctrine data fixtures and Zenstruck/Foundry bundles to seed the database.

See src/DataFixtures/UserFixtures.php for test users.

The default password for all users is Demo1234 and is set in src/Factory/UserFactory.php.

See README_LOCAL_DEVELOPMENT.md for local development with Docker integration.

Code quality is maintained with PHPStan, PHP-CS-Fixer, and PHPUnit.

## Preparation

1. Install Symfony CLI if not previously installed (https://symfony.com/download)

2. Create MySQL Database e.g. demo_php

3. Copy .env.dev.example to .env.dev.local and replace values for your environment.

4. Install dependencies
```sh
composer install
```

5. Generate the JWT SSL keys
```sh
   symfony console lexik:jwt:generate-keypair
```

6. Run composer dump-env for dev environment
```sh
composer dump-env dev
```

7. Run migrations
```sh
symfony console doctrine:migrations:migrate
```

8. Seed the database
```sh
symfony console doctrine:fixtures:load
```

## Running the application

1. Start the services
```sh
symfony server:start --no-tls
```
If you are using Docker integration:
```sh
docker-compose up -d
```
If you are using async messenger:
```sh
symfony console messenger:consume async -vv
```

2. Open http://localhost:8000/api to view API documentation

## Running tests
1. Run unit tests
```sh
php bin/phpunit
```

2. Run API tests
```sh
php vendor/bin/behat
```

## Code Quality Tools
1. php-cs-fixer.php. See php-cs-fixer.php for configuration
```sh
php vendor/bin/php-cs-fixer fix
```
2. PHPStan. See phpstan.neon for configuration
```sh
php vendor/bin/phpstan analyse
```

## License

The Demo PHP API app is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

