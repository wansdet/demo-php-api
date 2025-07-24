<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Region;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Region>
 */
final class RegionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Region::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'active' => self::faker()->boolean(),
            'briefDescription' => self::faker()->text(500),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => "SYSTEM",
            'longDescription' => self::faker()->text(),
            'name' => self::faker()->text(20),
            'shortDescription' => self::faker()->text(2000),
            'sortOrder' => self::faker()->numberBetween(1, 32767),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Region $region): void {})
        ;
    }
}
