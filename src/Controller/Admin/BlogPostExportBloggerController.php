<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Message\Blog\BlogPostReportExportBlogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class BlogPostExportBloggerController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function __invoke(MessageBusInterface $bus): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (null == $user->getId()) {
            throw new \Exception('User not found.');
        } else {
            $bus->dispatch(new BlogPostReportExportBlogger($user->getId()));
        }

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
