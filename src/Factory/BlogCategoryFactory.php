<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\BlogCategory;
use App\Repository\BlogCategoryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BlogCategory>
 *
 * @method        BlogCategory|Proxy                     create(array|callable $attributes = [])
 * @method static BlogCategory|Proxy                     createOne(array $attributes = [])
 * @method static BlogCategory|Proxy                     find(object|array|mixed $criteria)
 * @method static BlogCategory|Proxy                     findOrCreate(array $attributes)
 * @method static BlogCategory|Proxy                     first(string $sortedField = 'id')
 * @method static BlogCategory|Proxy                     last(string $sortedField = 'id')
 * @method static BlogCategory|Proxy                     random(array $attributes = [])
 * @method static BlogCategory|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BlogCategoryRepository|RepositoryProxy repository()
 * @method static BlogCategory[]|Proxy[]                 all()
 * @method static BlogCategory[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static BlogCategory[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static BlogCategory[]|Proxy[]                 findBy(array $attributes)
 * @method static BlogCategory[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static BlogCategory[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<BlogCategory> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<BlogCategory> createOne(array $attributes = [])
 * @phpstan-method static Proxy<BlogCategory> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<BlogCategory> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<BlogCategory> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogCategory> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogCategory> random(array $attributes = [])
 * @phpstan-method static Proxy<BlogCategory> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<BlogCategory> repository()
 * @phpstan-method static list<Proxy<BlogCategory>> all()
 * @phpstan-method static list<Proxy<BlogCategory>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<BlogCategory>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<BlogCategory>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<BlogCategory>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<BlogCategory>> randomSet(int $number, array $attributes = [])
 */
final class BlogCategoryFactory extends ModelFactory
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
        return BlogCategory::class;
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
            'blogCategoryName' => self::faker()->text(30),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => self::faker()->text(100),
            'sortOrder' => self::faker()->numberBetween(1, 32767),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(BlogCategory $blogCategory): void {})
    }
}
