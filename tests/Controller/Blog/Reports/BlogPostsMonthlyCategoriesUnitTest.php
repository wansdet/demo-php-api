<?php

declare(strict_types=1);

namespace App\Tests\Controller\Blog\Reports;

use App\Controller\Blog\Reports\BlogPostsMonthlyCategoriesController;
use App\Service\Blog\Reports\BlogPostsMonthlyCategoriesService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class BlogPostsMonthlyCategoriesUnitTest extends TestCase
{
    public function testBlogPostsMonthlyCategoriesControllerInvoke(): void
    {
        $serviceMock = $this->createMock(BlogPostsMonthlyCategoriesService::class);
        $serviceMock->expects(self::once())
            ->method('findMonthlyBlogPostsByCategoriesReport')
            ->willReturn(['mocked' => 'data']);

        $controller = new BlogPostsMonthlyCategoriesController($serviceMock);

        $result = $controller->__invoke();

        self::assertSame(['mocked' => 'data'], $result);
    }
}
