<?php

declare(strict_types=1);

namespace App\Tests\Controller\User;

use App\Controller\User\PasswordChangeController;
use App\Entity\User;
use App\Service\User\PasswordChangeService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class PasswordChangeUnitTest extends TestCase
{
    public function testPasswordChangeControllerInvoke(): void
    {
        // Create a mock of the PasswordChangeService
        $passwordChangeServiceMock = $this->createMock(PasswordChangeService::class);

        // Create a mock User entity
        $mockedUser = new User();
        $mockedUser->setEmail('test@example.com');

        // Set up the expectations on the service
        $passwordChangeServiceMock->expects(self::once())
            ->method('changePassword')
            ->with($mockedUser)
            ->willReturn($mockedUser);

        // Create an instance of the controller and inject the mock service
        $controller = new PasswordChangeController($passwordChangeServiceMock);

        // Call the __invoke method with the mock User
        $resultUser = $controller->__invoke($mockedUser);

        // Assert that the returned User matches the mock
        self::assertSame($mockedUser, $resultUser);
    }
}
