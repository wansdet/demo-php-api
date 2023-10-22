<?php

declare(strict_types=1);

namespace App\State\Document;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Repository\DocumentRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class DocumentDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private ParameterBagInterface $parameterBag,
        private TokenStorageInterface $tokenStorage,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        $document = $data;

        if ($user !== $document->getUser()) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        // Delete the document from the filesystem
        /** @var string|null $rootPath */
        $rootPath = $this->parameterBag->get('kernel.project_dir');
        $file = $rootPath.$document->getPath().$document->getFilename();
        unlink($file);

        // Delete the document from the database
        $this->documentRepository->delete($document);
    }
}
