<?php

declare(strict_types=1);

namespace App\MessageHandler\Blog;

use App\Entity\BlogPostComment;
use App\Entity\User;
use App\Message\Blog\BlogPostCommentNotification;
use App\Repository\BlogPostCommentRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BlogPostCommentNotificationHandler
{
    public function __construct(
        private readonly BlogPostCommentRepository $blogPostCommentRepository,
        private readonly MailerInterface $mailer,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(BlogPostCommentNotification $notification): void
    {
        /** @var BlogPostComment $blogPostComment */
        $blogPostComment = $this->blogPostCommentRepository->find($notification->getBlogPostCommentId());

        if (null == $blogPostComment) {
            throw new \RuntimeException('Blog post comment not found');
        }

        $blogPost = $blogPostComment->getBlogPost();

        if (null == $blogPost) {
            throw new \RuntimeException('Blog post not found');
        }

        $recipient = $_ENV['EMAIL_BLOG_POST_COMMENT_REVIEWER'];
        $subject = sprintf(
            'New comment posted on blog post: "%s"',
            $blogPost->getSlug()
        );
        $comment = $blogPostComment->getComment();

        /** @var User $author */
        $author = $blogPostComment->getAuthor();

        if (null == $author) {
            throw new \RuntimeException('Author not found');
        }

        $authorName = $author->getName();
        $authorEmail = $author->getEmail();
        $link = $_ENV['APP_URL'].'/admin/blog/post/comment/'.$blogPostComment->getId().'/manage';
        $template = 'emails/blog_post_comment_status_notification.md';

        $email = (new TemplatedEmail())
            ->to($recipient)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context([
                'heading' => $subject,
                'authorEmail' => $authorEmail,
                'comment' => $comment,
                'author' => $authorName,
                'link' => $link,
            ]);

        $this->mailer->send($email);
    }
}
