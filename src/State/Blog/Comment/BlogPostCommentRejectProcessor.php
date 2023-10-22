<?php

declare(strict_types=1);

namespace App\State\Blog\Comment;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Blog\BlogPostCommentTransitionRequest;
use App\Entity\BlogPostComment;
use App\Entity\User;
use App\Exception\WorkflowException;
use App\Repository\BlogPostCommentRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class BlogPostCommentRejectProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly BlogPostCommentRepository $blogPostCommentRepository,
        private readonly WorkflowInterface $blogPostCommentPublishing,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    /**
     * @param BlogPostCommentTransitionRequest $data
     *
     * @throws WorkflowException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $blogPostCommentId = $uriVariables['blogPostCommentId'];
        $blogPostComment = $this->blogPostCommentRepository->findOneBy(['blogPostCommentId' => $blogPostCommentId]);

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        try {
            $remarks = $data->remarks ?? '';
            $blogPostComment->setRemarks($remarks);
            $this->blogPostCommentPublishing->apply($blogPostComment, BlogPostComment::TRANSITION_REJECT);
            $blogPostComment->setUpdatedBy($user->getName());
            $this->blogPostCommentRepository->save($blogPostComment);
        } catch (\Exception $e) {
            throw new WorkflowException('Blog post comment cannot be rejected. Please contact the administrator.');
        }
    }
}
