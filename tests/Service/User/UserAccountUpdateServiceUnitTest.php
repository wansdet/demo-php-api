<?php

declare(strict_types=1);

namespace App\Tests\Service\User;

use App\Entity\User;
use App\Service\User\UserAccountUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class UserAccountUpdateServiceUnitTest extends TestCase
{
    private UserAccountUpdateService $userAccountUpdateService;

    private EntityManagerInterface $entityManagerMock;

    protected function setUp(): void
    {
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->userAccountUpdateService = new UserAccountUpdateService(
            $this->entityManagerMock
        );
    }

    /**
     * @throws \Exception
     */
    public function testUpdateUserSuccessful(): void
    {
        $user = new User();

        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $result = $this->userAccountUpdateService->updateUser($user);

        $this->assertSame($user, $result);
    }

    public function testUpdateUserFailed(): void
    {
        $user = new User();

        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush')
            ->willThrowException(new \Exception('Unable to update user.'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unable to update user.');

        $this->userAccountUpdateService->updateUser($user);
    }
}