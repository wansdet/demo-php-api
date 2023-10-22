<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\BlogPostComment;
use App\Repository\BlogPostCommentRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BlogPostComment>
 *
 * @method        BlogPostComment|Proxy                     create(array|callable $attributes = [])
 * @method static BlogPostComment|Proxy                     createOne(array $attributes = [])
 * @method static BlogPostComment|Proxy                     find(object|array|mixed $criteria)
 * @method static BlogPostComment|Proxy                     findOrCreate(array $attributes)
 * @method static BlogPostComment|Proxy                     first(string $sortedField = 'id')
 * @method static BlogPostComment|Proxy                     last(string $sortedField = 'id')
 * @method static BlogPostComment|Proxy                     random(array $attributes = [])
 * @method static BlogPostComment|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BlogPostCommentRepository|RepositoryProxy repository()
 * @method static BlogPostComment[]|Proxy[]                 all()
 * @method static BlogPostComment[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static BlogPostComment[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static BlogPostComment[]|Proxy[]                 findBy(array $attributes)
 * @method static BlogPostComment[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static BlogPostComment[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<BlogPostComment> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<BlogPostComment> createOne(array $attributes = [])
 * @phpstan-method static Proxy<BlogPostComment> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<BlogPostComment> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<BlogPostComment> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogPostComment> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<BlogPostComment> random(array $attributes = [])
 * @phpstan-method static Proxy<BlogPostComment> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<BlogPostComment> repository()
 * @phpstan-method static list<Proxy<BlogPostComment>> all()
 * @phpstan-method static list<Proxy<BlogPostComment>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<BlogPostComment>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<BlogPostComment>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<BlogPostComment>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<BlogPostComment>> randomSet(int $number, array $attributes = [])
 */
final class BlogPostCommentFactory extends ModelFactory
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
        return BlogPostComment::class;
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
            'blogPostCommentId' => null, // TODO add UUID type manually
            'comment' => self::faker()->text(1000),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => self::faker()->text(100),
            'status' => self::faker()->text(20),
            'author' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
        // ->afterInstantiate(function(BlogPostComment $blogPostComment): void {})
    }
}
