<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use App\Service\User\PasswordChangeService;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class PasswordChangeController
{
    public function __construct(private readonly PasswordChangeService $passwordChangeService)
    {
    }

    public function __invoke(User $user): User
    {
        return $this->passwordChangeService->changePassword($user);
    }
}
