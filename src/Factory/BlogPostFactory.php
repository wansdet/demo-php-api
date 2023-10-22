<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BlogPost>
 *
 * @method        BlogPost|Proxy                     create(array|callable $attributes = [])
 * @method static BlogPost|Proxy                     createOne(array $attributes = [])
 * @method static BlogPost|Proxy                     find(object|array|mixed $criteria)
 * @method static BlogPost|Proxy                     findOrCreate(array $attributes)
 * @method static BlogPost|Proxy                     first(string $sortedField = 'id')
 * @method static BlogPost|Proxy                     last(string $sortedField = 'id')
 * @method static BlogPost|Proxy                     random(array $attributes = [])
 * @method static BlogPost|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BlogPostRepository|RepositoryProxy repository()
 * @method static BlogPost[]|Proxy[]                 all()
 * @method static BlogPost[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static BlogPost[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static BlogPost[]|Proxy[]                 findBy(array $attributes)
 * @method static BlogPost[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static BlogPost[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<BlogPost> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<BlogPost> createOne(array $attributes = [])
 * @phpstan-method static Proxy<BlogPost> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<BlogPost> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<BlogPost> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogPost> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogPost> random(array $attributes = [])
 * @phpstan-method static Proxy<BlogPost> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<BlogPost> repository()
 * @phpstan-method static list<Proxy<BlogPost>> all()
 * @phpstan-method static list<Proxy<BlogPost>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<BlogPost>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<BlogPost>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<BlogPost>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<BlogPost>> randomSet(int $number, array $attributes = [])
 */
final class BlogPostFactory extends ModelFactory
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
        return BlogPost::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'blogPostId' => null, // TODO add UUID type manually
            'content' => self::faker()->text(4000),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => self::faker()->text(100),
            'slug' => self::faker()->text(255),
            'status' => self::faker()->text(20),
            'title' => self::faker()->text(50),
            'author' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(BlogPost $blogPost): void {})
    }
}
