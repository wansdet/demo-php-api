<?php

declare(strict_types=1);

namespace App\Service\User;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordChangeService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordEncoder,
    ) {
    }

    public function changePassword(User $user): User
    {
        if (!$this->passwordEncoder->isPasswordValid($user, $user->getCurrentPassword())) {
            throw new ValidationException('The provided current password is incorrect.');
        }

        if ($user->getNewPassword() === $user->getCurrentPassword()) {
            throw new ValidationException('The new password cannot be the same as the current password.');
        }

        $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getNewPassword()));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
