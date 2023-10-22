<?php

declare(strict_types=1);

namespace App\Message\Blog;

final class BlogPostCommentNotification
{
    private int $blogPostCommentId;

    public function __construct(int $blogPostCommentId)
    {
        $this->blogPostCommentId = $blogPostCommentId;
    }

    public function getBlogPostCommentId(): int
    {
        return $this->blogPostCommentId;
    }
}
