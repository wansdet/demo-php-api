<?php

declare(strict_types=1);

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Repository\UserRepository;

class BlogAuthorsProvider implements ProviderInterface
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->userRepository->findUsersByRole(User::ROLE_BLOGGER);
    }
}
