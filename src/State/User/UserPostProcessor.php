<?php

declare(strict_types=1);

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;

class UserPostProcessor implements ProcessorInterface
{
    public function __construct(private readonly ProcessorInterface $persistProcessor)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $data->setCreatedBy($data->getFirstName().' '.$data->getLastName());

        $result = $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        $this->sendWelcomeEmail($data);

        return $result;
    }

    private function sendWelcomeEmail(User $user): void
    {
        // TODO: Send welcome email
    }
}
