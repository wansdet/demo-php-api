<?php

declare(strict_types=1);

namespace App\Tests\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\State\User\UserPostProcessor;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class UserPostProcessorUnitTest extends TestCase
{
    private ProcessorInterface $persistProcessor;

    private UserPostProcessor $userPostProcessor;

    public function testProcessSuccessful(): void
    {
        $this->persistProcessor = $this->createMock(ProcessorInterface::class);
        $this->userPostProcessor = new UserPostProcessor($this->persistProcessor);

        $user = new User();

        $this->persistProcessor->expects(self::once())
            ->method('process')
            ->with($user, $this->createMock(Operation::class), [], [])
            ->willReturn($user);

        $result = $this->userPostProcessor->process($user, $this->createMock(Operation::class), [], []);

        self::assertInstanceOf(User::class, $result);
    }
}
