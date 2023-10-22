<?php

declare(strict_types=1);

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserAccountProvider implements ProviderInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new AccessDeniedException('Null token.');
        }

        return $this->userRepository->findOneBy(['email' => $token->getUserIdentifier()]);
    }
}
