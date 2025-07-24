<?php

declare(strict_types=1);

namespace App\Service\User;

use ApiPlatform\Validator\Exception\ValidationException;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class PasswordChangeService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordEncoder,
    ) {
    }

    public function changePassword(User $user): User
    {
        if (!$this->passwordEncoder->isPasswordValid($user, $user->getCurrentPassword())) {
            $violations = new ConstraintViolationList([
                new ConstraintViolation(
                    'The provided current password is incorrect.',
                    null,
                    [],
                    null,
                    null,
                    null
                ),
            ]);
            throw new ValidationException($violations);
        }

        if ($user->getNewPassword() === $user->getCurrentPassword()) {
            $violations = new ConstraintViolationList([
                new ConstraintViolation(
                    'The new password cannot be the same as the current password.',
                    null,
                    [],
                    null,
                    null,
                    null
                ),
            ]);
            throw new ValidationException($violations);
        }

        $user->setPassword($this->passwordEncoder->hashPassword($user, $user->getNewPassword()));
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
