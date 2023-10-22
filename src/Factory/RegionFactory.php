<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Region;
use App\Repository\RegionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Region>
 *
 * @method        Region|Proxy                     create(array|callable $attributes = [])
 * @method static Region|Proxy                     createOne(array $attributes = [])
 * @method static Region|Proxy                     find(object|array|mixed $criteria)
 * @method static Region|Proxy                     findOrCreate(array $attributes)
 * @method static Region|Proxy                     first(string $sortedField = 'id')
 * @method static Region|Proxy                     last(string $sortedField = 'id')
 * @method static Region|Proxy                     random(array $attributes = [])
 * @method static Region|Proxy                     randomOrCreate(array $attributes = [])
 * @method static RegionRepository|RepositoryProxy repository()
 * @method static Region[]|Proxy[]                 all()
 * @method static Region[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Region[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Region[]|Proxy[]                 findBy(array $attributes)
 * @method static Region[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Region[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Region> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Region> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Region> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Region> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Region> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Region> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Region> random(array $attributes = [])
 * @phpstan-method static Proxy<Region> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Region> repository()
 * @phpstan-method static list<Proxy<Region>> all()
 * @phpstan-method static list<Proxy<Region>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Region>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Region>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Region>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Region>> randomSet(int $number, array $attributes = [])
 */
final class RegionFactory extends ModelFactory
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

    protected static function getClass(): string
    {
        return Region::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'active' => self::faker()->boolean(),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => self::faker()->text(100),
            'regionName' => self::faker()->text(20),
            'sortOrder' => self::faker()->numberBetween(1, 32767),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(Region $region): void {})
    }
}
