<?php

declare(strict_types=1);

namespace App\Tests\Service\User;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\User;
use App\Service\User\PasswordChangeService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @internal
 *
 * @coversNothing
 */
final class PasswordChangeServiceUnitTest extends TestCase
{
    private PasswordChangeService $passwordChangeService;
    private UserPasswordHasherInterface $passwordHasherMock;
    private EntityManagerInterface $entityManagerMock;

    protected function setUp(): void
    {
        $this->passwordHasherMock = $this->createMock(UserPasswordHasherInterface::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->passwordChangeService = new PasswordChangeService(
            $this->entityManagerMock,
            $this->passwordHasherMock
        );
    }

    public function testChangePasswordSuccessful(): void
    {
        $user = new User();
        $user->setCurrentPassword('old_password');
        $user->setNewPassword('new_password');

        $this->passwordHasherMock
            ->expects($this->once())
            ->method('isPasswordValid')
            ->with($user, 'old_password')
            ->willReturn(true);

        $this->passwordHasherMock
            ->expects($this->once())
            ->method('hashPassword')
            ->with($user, 'new_password')
            ->willReturn('hashed_new_password');

        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $user = $this->passwordChangeService->changePassword($user);

        $this->assertSame('hashed_new_password', $user->getPassword());
    }

    public function testChangePasswordThrowsValidationExceptionForInvalidCurrentPassword(): void
    {
        $user = new User();
        $user->setCurrentPassword('wrong_password');
        $user->setNewPassword('new_password');

        $this->passwordHasherMock
            ->expects($this->once())
            ->method('isPasswordValid')
            ->with($user, 'wrong_password')
            ->willReturn(false);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The provided current password is incorrect.');

        $this->passwordChangeService->changePassword($user);
    }

    public function testChangePasswordThrowsValidationExceptionForSameNewPassword(): void
    {
        $user = new User();
        $user->setCurrentPassword('same_password');
        $user->setNewPassword('same_password');

        $this->passwordHasherMock
            ->expects($this->once())
            ->method('isPasswordValid')
            ->with($user, 'same_password')
            ->willReturn(true);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The new password cannot be the same as the current password.');

        $this->passwordChangeService->changePassword($user);
    }
}
