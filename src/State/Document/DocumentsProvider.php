<?php

declare(strict_types=1);

namespace App\State\Document;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class DocumentsProvider implements ProviderInterface
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private TokenStorageInterface $tokenStorage
    ) {
    }

    /**
     * @throws \Exception
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new UnauthorizedHttpException('Missing token');
        }

        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        $criteria = ['user' => $user];
        $orderBy = ['createdAt' => 'DESC'];

        return $this->documentRepository->findBy($criteria, $orderBy);
    }
}
