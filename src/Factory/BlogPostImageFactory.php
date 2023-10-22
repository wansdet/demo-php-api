<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\BlogPostImage;
use App\Repository\BlogPostImageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BlogPostImage>
 *
 * @method        BlogPostImage|Proxy                     create(array|callable $attributes = [])
 * @method static BlogPostImage|Proxy                     createOne(array $attributes = [])
 * @method static BlogPostImage|Proxy                     find(object|array|mixed $criteria)
 * @method static BlogPostImage|Proxy                     findOrCreate(array $attributes)
 * @method static BlogPostImage|Proxy                     first(string $sortedField = 'id')
 * @method static BlogPostImage|Proxy                     last(string $sortedField = 'id')
 * @method static BlogPostImage|Proxy                     random(array $attributes = [])
 * @method static BlogPostImage|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BlogPostImageRepository|RepositoryProxy repository()
 * @method static BlogPostImage[]|Proxy[]                 all()
 * @method static BlogPostImage[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static BlogPostImage[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static BlogPostImage[]|Proxy[]                 findBy(array $attributes)
 * @method static BlogPostImage[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static BlogPostImage[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<BlogPostImage> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<BlogPostImage> createOne(array $attributes = [])
 * @phpstan-method static Proxy<BlogPostImage> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<BlogPostImage> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<BlogPostImage> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogPostImage> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogPostImage> random(array $attributes = [])
 * @phpstan-method static Proxy<BlogPostImage> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<BlogPostImage> repository()
 * @phpstan-method static list<Proxy<BlogPostImage>> all()
 * @phpstan-method static list<Proxy<BlogPostImage>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<BlogPostImage>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<BlogPostImage>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<BlogPostImage>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<BlogPostImage>> randomSet(int $number, array $attributes = [])
 */
final class BlogPostImageFactory extends ModelFactory
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
        return BlogPostImage::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'blogPost' => BlogPostFactory::new(),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => self::faker()->text(100),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(BlogPostImage $blogPostImage): void {})
    }
}
