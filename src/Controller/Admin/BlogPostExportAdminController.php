<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Message\Blog\BlogPostReportExportAdmin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class BlogPostExportAdminController extends AbstractController
{
    /**
     * @throws \Exception
     * @throws ExceptionInterface
     */
    public function __invoke(MessageBusInterface $bus): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (null == $user->getId()) {
            throw new \Exception('User not found.');
        }

        $bus->dispatch(new BlogPostReportExportAdmin($user->getId()));

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
