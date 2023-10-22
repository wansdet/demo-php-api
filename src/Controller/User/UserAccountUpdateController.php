<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Service\User\UserAccountUpdateService;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UserAccountUpdateController
{
    public function __construct(private readonly UserAccountUpdateService $userAccountUpdateService)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(User $user): User
    {
        return $this->userAccountUpdateService->updateUser($user);
    }
}
