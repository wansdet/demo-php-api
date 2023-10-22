<?php

declare(strict_types=1);

namespace App\Tests\Controller\Blog\Reports;

use App\Controller\Blog\Reports\BlogPostsMonthlyAuthorsController;
use App\Service\Blog\Reports\BlogPostsMonthlyAuthorsService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class BlogPostsMonthlyAuthorsUnitTest extends TestCase
{
    public function testBlogPostsMonthlyAuthorsControllerInvoke(): void
    {
        $serviceMock = $this->createMock(BlogPostsMonthlyAuthorsService::class);
        $serviceMock->expects(self::once())
            ->method('findMonthlyBlogPostsByAuthorsReport')
            ->willReturn(['mocked' => 'data']);

        $controller = new BlogPostsMonthlyAuthorsController($serviceMock);

        $result = $controller->__invoke();

        self::assertSame(['mocked' => 'data'], $result);
    }
}
