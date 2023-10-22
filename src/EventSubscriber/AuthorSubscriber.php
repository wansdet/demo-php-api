<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\AuthorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuthorSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setAuthor', EventPriorities::PRE_WRITE],
        ];
    }

    public function setAuthor(ViewEvent $event): void
    {
        /** @var AuthorInterface $entity */
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof AuthorInterface || Request::METHOD_POST !== $method) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return;
        }

        // var_export('AuthorSubscriber');

        /** @var User $author */
        $author = $this->userRepository->findOneBy(['email' => $token->getUserIdentifier()]);

        $entity->setAuthor($author);
    }
}
