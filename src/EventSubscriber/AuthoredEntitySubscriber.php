<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\AuthoredEntityInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class AuthoredEntitySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setAuthored', EventPriorities::PRE_WRITE],
        ];
    }

    public function setAuthored(ViewEvent $event): void
    {
        /** @var AuthoredEntityInterface $entity */
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof AuthoredEntityInterface || !\in_array($method, [Request::METHOD_POST, Request::METHOD_PUT], true)) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            return;
        }

        /** @var User $author */
        $author = $this->userRepository->findOneBy(['email' => $token->getUserIdentifier()]);

        if (Request::METHOD_POST === $method) {
            // var_dump('AuthoredEntitySubscriber: POST');
            $entity->setCreatedBy($author->getName());
        }

        if (Request::METHOD_PUT === $method) {
            // var_dump('AuthoredEntitySubscriber: PUT');
            $entity->setUpdatedBy($author->getName());
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
    }
}
