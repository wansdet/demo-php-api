<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\BlogPostComment;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BlogPostComment>
 */
final class BlogPostCommentFactory extends PersistentProxyObjectFactory
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
        return BlogPostComment::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'author' => UserFactory::new(),
            'blogPost' => BlogPostFactory::new(),
            'blogPostCommentId' => null, // TODO add UUID type manually
            'comment' => self::faker()->text(1000),
            'createdAt' => self::faker()->dateTime(),
            'createdBy' => "SYSTEM",
            'status' => self::faker()->text(20),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(BlogPostComment $blogPostComment): void {})
        ;
    }
}
