<?php

declare(strict_types=1);

namespace App\Dto\Blog;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class BlogPostTransitionRequest
{
    #[Groups(['BlogPost:transition'])]
    #[Assert\Length(max: 1000)]
    public string $remarks = '';
}
