<?php

declare(strict_types=1);

namespace App\Message\Blog;

class BlogPostReportExportAdmin
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
