<?php

declare(strict_types=1);

namespace App\Dto\Blog;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class BlogPostCommentTransitionRequest
{
    #[Groups(['BlogPostComment:transition'])]
    #[Assert\Length(max: 255)]
    public string $remarks = '';
}
