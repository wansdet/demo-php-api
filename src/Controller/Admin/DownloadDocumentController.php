<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Document;
use App\Service\Document\DocumentDownloadService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class DownloadDocumentController
{
    public function __construct(private DocumentDownloadService $documentDownloadService)
    {
    }

    public function __invoke(Document $document): BinaryFileResponse
    {
        return $this->documentDownloadService->download($document);
    }
}
