<?php

declare(strict_types=1);

namespace App\Message;

class DocumentReadyNotification
{
    private int $userId;
    private string $subject;
    private string $content;

    public function __construct(int $userId, string $subject, string $content)
    {
        $this->userId = $userId;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
