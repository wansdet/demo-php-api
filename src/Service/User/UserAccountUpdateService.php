<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserAccountUpdateService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function updateUser(User $user): User
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception('Unable to update user.');
        }

        return $user;
    }
}
