<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Information;
use App\Repository\InformationRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Information>
 *
 * @method        Information|Proxy                     create(array|callable $attributes = [])
 * @method static Information|Proxy                     createOne(array $attributes = [])
 * @method static Information|Proxy                     find(object|array|mixed $criteria)
 * @method static Information|Proxy                     findOrCreate(array $attributes)
 * @method static Information|Proxy                     first(string $sortedField = 'id')
 * @method static Information|Proxy                     last(string $sortedField = 'id')
 * @method static Information|Proxy                     random(array $attributes = [])
 * @method static Information|Proxy                     randomOrCreate(array $attributes = [])
 * @method static InformationRepository|RepositoryProxy repository()
 * @method static Information[]|Proxy[]                 all()
 * @method static Information[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Information[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Information[]|Proxy[]                 findBy(array $attributes)
 * @method static Information[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Information[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Information> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Information> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Information> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Information> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Information> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Information> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Information> random(array $attributes = [])
 * @phpstan-method static Proxy<Information> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Information> repository()
 * @phpstan-method static list<Proxy<Information>> all()
 * @phpstan-method static list<Proxy<Information>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Information>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Information>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Information>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Information>> randomSet(int $number, array $attributes = [])
 */
final class InformationFactory extends ModelFactory
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
        return Information::class;
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
            'createdBy' => self::faker()->text(100),
            'information' => self::faker()->text(1000),
            'sortOrder' => self::faker()->numberBetween(1, 32767),
            'title' => self::faker()->text(100),
            'informationType' => self::faker()->text(30),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(Information $information): void {})
    }
}
