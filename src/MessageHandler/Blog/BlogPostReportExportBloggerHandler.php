<?php

namespace App\MessageHandler\Blog;

use App\Message\Blog\BlogPostReportExportBlogger;
use App\Message\DocumentReadyNotification;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final class BlogPostReportExportBloggerHandler
{
    use BlogPostReportExportTrait;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MessageBusInterface $bus,
        private readonly ParameterBagInterface $parameterBag,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(BlogPostReportExportBlogger $blogPostReportExportBlogger): void
    {
        $user = $this->userRepository->find($blogPostReportExportBlogger->getUserId());
        $criteria = ['author' => $user];
        $this->generateBlogPostReport(
            $blogPostReportExportBlogger->getUserId(),
            $criteria,
            $this->parameterBag,
            $this->entityManager,
        );

        $subject = 'Blog Post Report';
        $content = 'Your blog post report is ready for download.';
        $this->bus->dispatch(new DocumentReadyNotification($blogPostReportExportBlogger->getUserId(), $subject, $content));
    }
}
