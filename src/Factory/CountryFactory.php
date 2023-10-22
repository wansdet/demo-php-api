<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Country>
 *
 * @method        Country|Proxy                     create(array|callable $attributes = [])
 * @method static Country|Proxy                     createOne(array $attributes = [])
 * @method static Country|Proxy                     find(object|array|mixed $criteria)
 * @method static Country|Proxy                     findOrCreate(array $attributes)
 * @method static Country|Proxy                     first(string $sortedField = 'id')
 * @method static Country|Proxy                     last(string $sortedField = 'id')
 * @method static Country|Proxy                     random(array $attributes = [])
 * @method static Country|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CountryRepository|RepositoryProxy repository()
 * @method static Country[]|Proxy[]                 all()
 * @method static Country[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Country[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Country[]|Proxy[]                 findBy(array $attributes)
 * @method static Country[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Country[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Country> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Country> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Country> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Country> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Country> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Country> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Country> random(array $attributes = [])
 * @phpstan-method static Proxy<Country> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Country> repository()
 * @phpstan-method static list<Proxy<Country>> all()
 * @phpstan-method static list<Proxy<Country>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Country>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Country>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Country>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Country>> randomSet(int $number, array $attributes = [])
 */
final class CountryFactory extends ModelFactory
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
        return Country::class;
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
            'countryName' => self::faker()->text(100),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => self::faker()->text(100),
            'region' => RegionFactory::new(),
            'sortOrder' => self::faker()->numberBetween(1, 32767),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(Country $country): void {})
    }
}
