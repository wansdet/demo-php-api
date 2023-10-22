<?php

declare(strict_types=1);

namespace App\State\Blog\Post;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Blog\BlogPostTransitionRequest;
use App\Entity\BlogPost;
use App\Entity\User;
use App\Exception\WorkflowException;
use App\Repository\BlogPostRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class BlogPostSubmitProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository,
        private readonly WorkflowInterface $blogPublishing,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    /**
     * @param BlogPostTransitionRequest $data
     *
     * @throws WorkflowException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $blogPostId = $uriVariables['blogPostId'];
        $blogPost = $this->blogPostRepository->findOneBy(['blogPostId' => $blogPostId]);

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        try {
            $remarks = $data->remarks ?? '';
            $blogPost->setRemarks($remarks);
            $this->blogPublishing->apply($blogPost, BlogPost::TRANSITION_SUBMIT);
            $blogPost->setUpdatedBy($user->getName());
            $this->blogPostRepository->save($blogPost);
        } catch (\Exception $e) {
            throw new WorkflowException('Blog post cannot be submitted. Please contact the administrator.');
        }
    }
}
