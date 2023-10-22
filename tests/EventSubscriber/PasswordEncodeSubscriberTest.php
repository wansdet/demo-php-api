<?php

declare(strict_types=1);

namespace App\Tests\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\User;
use App\EventSubscriber\PasswordEncodeSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @internal
 *
 * @coversNothing
 */
final class PasswordEncodeSubscriberTest extends TestCase
{
    public function testEncodePasswordDoesNotModifyNonUserEntities(): void
    {
        $nonUserEntity = new \stdClass();

        $event = new ViewEvent(
            $this->createMock(HttpKernelInterface::class),
            $this->createMock(Request::class),
            0,
            $nonUserEntity
        );

        // Create a mock for a class that implements UserPasswordHasherInterface
        $passwordEncoder = $this->createMock(UserPasswordHasherInterface::class);

        // Now you can use the 'expects' method on the $passwordEncoder mock
        $passwordEncoder
            ->expects(self::never())
            ->method('hashPassword');

        $subscriber = new PasswordEncodeSubscriber($passwordEncoder);
        $subscriber->encodePassword($event);
    }

    public function testEncodePasswordDoesNotModifyUserOnNonPostRequest(): void
    {
        $user = new User();
        $user->setPassword('password');

        $event = new ViewEvent(
            $this->createMock(HttpKernelInterface::class),
            $this->createMock(Request::class),
            0,
            $user
        );

        // Create a mock for a class that implements UserPasswordHasherInterface
        $passwordEncoder = $this->createMock(UserPasswordHasherInterface::class);

        // Now you can use the 'expects' method on the $passwordEncoder mock
        $passwordEncoder
            ->expects(self::never())
            ->method('hashPassword');

        $subscriber = new PasswordEncodeSubscriber($passwordEncoder);
        $subscriber->encodePassword($event);

        self::assertSame('password', $user->getPassword());
    }

    public function testEncodePasswordModifiesUserOnPostRequest(): void
    {
        $user = new User();
        $user->setPassword('password');

        $request = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'POST']);

        $event = new ViewEvent(
            $this->createMock(HttpKernelInterface::class),
            $request,
            0,
            $user
        );

        // Create a mock for a class that implements UserPasswordHasherInterface
        $passwordEncoder = $this->createMock(UserPasswordHasherInterface::class);

        // Now you can use the 'expects' method on the $passwordEncoder mock
        $passwordEncoder
            ->expects(self::once())
            ->method('hashPassword')
            ->with($user, 'password')
            ->willReturn('hashed_password');

        $subscriber = new PasswordEncodeSubscriber($passwordEncoder);
        $subscriber->encodePassword($event);

        self::assertSame('hashed_password', $user->getPassword());
    }

    public function testGetSubscribedEventsReturnsExpectedEvents(): void
    {
        $expectedEvents = [
            'kernel.view' => ['encodePassword', EventPriorities::PRE_WRITE],
        ];

        self::assertSame($expectedEvents, PasswordEncodeSubscriber::getSubscribedEvents());
    }
}
