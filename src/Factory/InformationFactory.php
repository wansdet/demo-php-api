<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Information;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Information>
 */
final class InformationFactory extends PersistentProxyObjectFactory
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
        return Information::class;
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
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => "SYSTEM",
            'information' => self::faker()->text(1000),
            'informationId' => null, // TODO add UUID type manually
            'informationType' => self::faker()->text(30),
            'sortOrder' => self::faker()->numberBetween(1, 32767),
            'title' => self::faker()->text(100),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Information $information): void {})
        ;
    }
}
