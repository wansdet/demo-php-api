<?php

declare(strict_types=1);

namespace App\Tests\State\User;

use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use App\Repository\UserRepository;
use App\State\User\UserAccountProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @internal
 *
 * @coversNothing
 */
class UserAccountProviderUnitTest extends TestCase
{
    private UserRepository $userRepository;

    private TokenStorageInterface $tokenStorage;

    public function testProvideSuccessful(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->tokenStorage = $this->createMock(TokenStorageInterface::class);

        $this->tokenStorage->expects(self::once())
            ->method('getToken')
            ->willReturn($this->createMock(TokenInterface::class));

        $this->userRepository->expects(self::once())
            ->method('findOneBy')
            ->willReturn($this->createMock(User::class));

        $userAccountProvider = new UserAccountProvider($this->userRepository, $this->tokenStorage);

        $result = $userAccountProvider->provide($this->createMock(Operation::class), [], []);

        self::assertInstanceOf(User::class, $result);
    }

    public function testProvideFail(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->tokenStorage = $this->createMock(TokenStorageInterface::class);

        $this->tokenStorage->expects(self::once())
            ->method('getToken')
            ->willReturn(null);

        $this->userRepository->expects(self::never())
            ->method('findOneBy');

        $userAccountProvider = new UserAccountProvider($this->userRepository, $this->tokenStorage);

        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionMessage('Null token.');

        $userAccountProvider->provide($this->createMock(Operation::class), [], []);
    }

}

/*
 * public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new AccessDeniedException('Null token.');
        }

        return $this->userRepository->findOneBy(['email' => $token->getUserIdentifier()]);
    }
 */