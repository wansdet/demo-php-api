<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordEncoder,
    ) {
        parent::__construct();
    }

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => "SYSTEM",
            'displayName' => self::faker()->text(20),
            'email' => self::faker()->text(180),
            'firstName' => self::faker()->text(50),
            'lastName' => self::faker()->text(50),
            'password' => self::faker()->text(255),
            'roles' => [],
            'status' => self::faker()->text(10),
            'title' => self::faker()->text(20),
            'userId' => null, // TODO add UUID type manually
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        // return $this// ->afterInstantiate(function(User $user): void {});
        return $this
            ->afterInstantiate(function (User $user) {
                $user->setPassword($this->passwordEncoder->hashPassword($user, 'Demo1234'));
            })
        ;
    }
}
