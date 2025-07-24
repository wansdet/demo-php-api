<?php

declare(strict_types=1);

namespace App\EventSubscriber\Blog;

use App\Entity\BlogPostComment;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Workflow\Event\Event;

final class BlogPostCommentPublishingLeaveListener implements EventSubscriberInterface
{
    private const EMAIL_TEMPLATE = 'emails/blog_post_comment_status_notification.md';

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.blog_post_comment_publishing.leave' => 'onBlogPostCommentPublishingLeave',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onBlogPostCommentPublishingLeave(Event $event): void
    {
        /** @var BlogPostComment $blogPostComment */
        $blogPostComment = $event->getSubject();
        $transition = $event->getTransition();
        $author = $blogPostComment->getAuthor();
        $blogPost = $blogPostComment->getBlogPost();
        $remarks = $blogPostComment->getRemarks();

        if (null === $transition || null === $author || null === $blogPost) {
            return;
        }

        $transitionName = $transition->getName();

        if (in_array($transitionName, ['reject', 'delete'], true)) {
            $comment = $blogPostComment->getComment();
            $authorName = $author->getName();
            $recipient = $author->getEmail();
            $subject = $this->getSubject($transitionName);
            $link = $_ENV['FRONTEND_URL'].'/blog/'.$blogPost->getBlogPostId();

            if (null !== $recipient && null !== $comment) {
                $this->sendEmail($recipient, $subject, $comment, $authorName, $remarks, $link);
            }
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendEmail(string $recipient, string $subject, string $comment, string $author, string $remarks, string $link): void
    {
        $email = (new TemplatedEmail())
            ->to($recipient)
            ->subject($subject)
            ->htmlTemplate(self::EMAIL_TEMPLATE)
            ->context([
                'heading' => $subject,
                'authorEmail' => $recipient,
                'comment' => $comment,
                'author' => $author,
                'remarks' => $remarks,
                'link' => $link,
            ]);

        $this->mailer->send($email);
    }

    private function getSubject(string $transitionName): string
    {
        if ('reject' == $transitionName) {
            return 'Your comment has been rejected';
        }

        if ('delete' == $transitionName) {
            return 'Your comment has been deleted';
        }

        return '';
    }
}
