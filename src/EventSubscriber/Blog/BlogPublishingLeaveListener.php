<?php

declare(strict_types=1);

namespace App\EventSubscriber\Blog;

use App\Entity\BlogPost;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Workflow\Event\Event;

final class BlogPublishingLeaveListener implements EventSubscriberInterface
{
    private const EMAIL_TEMPLATE = 'emails/blog_post_status_notification.md';

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.blog_publishing.leave' => 'onBlogPublishingLeave',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onBlogPublishingLeave(Event $event): void
    {
        /** @var BlogPost $blogPost */
        $blogPost = $event->getSubject();
        $transition = $event->getTransition();
        $author = $blogPost->getAuthor();
        $title = $blogPost->getTitle();
        $remarks = $blogPost->getRemarks();

        if (null === $transition || null === $author) {
            return;
        }

        $transitionName = $transition->getName();
        // var_dump('transitionName: '.$transitionName);

        if ('submit' === $transitionName) {
            $recipient = $_ENV['EMAIL_BLOG_POST_REVIEWER'];
            $subject = $this->getSubject($transitionName);
            $authorName = $author->getName();
            $link = $_ENV['FRONTEND_URL'].'/admin/blog-posts/blog-posts-list';

            if (null !== $recipient && null !== $title) {
                $this->sendEmail($recipient, $subject, $title, $authorName, $remarks, $link);
            }
        }

        if (in_array($transitionName, ['publish', 'reject', 'archive'], true)) {
            $recipient = $author->getEmail();
            $subject = $this->getSubject($transitionName);
            $authorName = $author->getName();
            $link = $_ENV['FRONTEND_URL'].'/admin/blog-posts/blogger-blog-posts-list';
            if (null !== $recipient && null !== $title) {
                $this->sendEmail($recipient, $subject, $title, $authorName, $remarks, $link);
            }
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendEmail(string $recipient, string $subject, string $title, string $author, string $remarks, string $link): void
    {
        $email = (new TemplatedEmail())
            ->to($recipient)
            ->subject($subject)
            ->htmlTemplate(self::EMAIL_TEMPLATE)
            ->context([
                'heading' => $subject,
                'recipient' => $recipient,
                'title' => $title,
                'author' => $author,
                'remarks' => $remarks,
                'link' => $link,
            ]);

        $this->mailer->send($email);
    }

    private function getSubject(string $transitionName): string
    {
        if ('submit' == $transitionName) {
            return 'Blog Post Submitted for Review';
        }

        if ('publish' == $transitionName) {
            return 'Blog Post Published';
        }

        if ('reject' == $transitionName) {
            return 'Blog Post Rejected';
        }

        if ('archive' == $transitionName) {
            return 'Blog Post Archived';
        }

        return '';
    }
}
