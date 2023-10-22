<?php

declare(strict_types=1);

namespace App\Tests\Controller\User;

use App\Controller\User\UserAccountUpdateController;
use App\Entity\User;
use App\Service\User\UserAccountUpdateService;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class UserAccountUpdateUnitTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testUserAccountUpdateControllerInvoke(): void
    {
        // Create a mock of the UserAccountUpdateService
        $userAccountUpdateServiceMock = $this->createMock(UserAccountUpdateService::class);

        // Create a mock User entity
        $mockedUser = new User();
        $mockedUser->setEmail('joe.bloggs@example.com');

        // Set up the expectations on the service
        $userAccountUpdateServiceMock->expects(self::once())
            ->method('updateUser')
            ->with($mockedUser)
            ->willReturn($mockedUser);

        // Create an instance of the controller and inject the mock service
        $controller = new UserAccountUpdateController($userAccountUpdateServiceMock);

        // Call the __invoke method with the mock User
        $resultUser = $controller->__invoke($mockedUser);

        // Assert that the returned User matches the mock
        self::assertSame($mockedUser, $resultUser);
    }
}
