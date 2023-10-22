<?php

declare(strict_types=1);

namespace App\Service\Document;

use App\Entity\Document;
use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class DocumentDownloadService
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function download(Document $document): BinaryFileResponse
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user instanceof User) {
            throw new \Exception('User not found');
        }

        if ($user !== $document->getUser()) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        $filename = $document->getFilename();
        $path = $document->getPath();
        /** @var string|null $rootPath */
        $rootPath = $this->parameterBag->get('kernel.project_dir');

        if (null === $filename || null === $path || null === $rootPath) {
            throw new \InvalidArgumentException('Document filename or path not found');
        }

        $file = $rootPath.$path.$filename;

        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($file);

        $response = new BinaryFileResponse($file);
        $response->headers->set('Content-Type', $mimeType);

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        return $response;
    }
}
