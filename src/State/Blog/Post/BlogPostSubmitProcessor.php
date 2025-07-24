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
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class BlogPostSubmitProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly BlogPostRepository $blogPostRepository,
        #[Target('blog_publishing')]
        private WorkflowInterface $blogPublishingStateMachine,
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

        if ($this->blogPublishingStateMachine->can($blogPost, BlogPost::TRANSITION_SUBMIT)) {
            var_dump('Can submit');
            //$this->blogPublishing->apply($blogPost, 'submit');
            $remarks = $data->remarks ?? '';
            $blogPost->setRemarks($remarks);
            //$this->blogPublishingStateMachine->apply($blogPost, BlogPost::TRANSITION_SUBMIT);
            $blogPost->setStatus(BlogPost::STATUS_SUBMITTED);
            $blogPost->setUpdatedBy($user->getName());
            $this->blogPostRepository->save($blogPost);
        } else {
            throw new WorkflowException('Blog post cannot be submitted. Please contact the administrator.');
        }
    }
}
