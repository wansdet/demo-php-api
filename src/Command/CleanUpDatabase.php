<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use App\Entity\Information;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:clean-up-database')]
class CleanUpDatabase extends Command
{
    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Clean up the database for automated tests';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to clean up the database for automated tests');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*
        $output->writeln([
            '',
            'Clean up the database for automated tests',
            '=========================================',
            '',
        ]);
        */

        if ('prod' === $_ENV['APP_ENV']) {
            $output->writeln([
                'This command is only available in dev and test environments.',
                '',
            ]);

            return Command::SUCCESS;
        }

        // Blog category
        $this->entityManager->getConnection()->executeQuery('DELETE FROM blog_category WHERE blog_category_code = "TEST_BLOG_CATEGORY"');
        $this->entityManager->getConnection()->executeQuery('DELETE FROM blog_category WHERE blog_category_code = "NEW_POST_BLOG_CATEGORY"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_category SET blog_category_name = "Technology", sort_order = 6, active = 1 WHERE blog_category_code = "TECHNOLOGY"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_category SET blog_category_name = "Travel", sort_order = 8, active = 1 WHERE blog_category_code = "TRAVEL"');

        // Blog post
        $this->entityManager->getConnection()->executeQuery('DELETE FROM blog_post WHERE title = "Create blog post for Automation testing"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_post SET status = "published" WHERE slug = "welcome-to-the-demo-blog-post-automation-testing-published"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_post SET status = "draft" WHERE slug = "welcome-to-the-demo-blog-post-automation-testing-draft"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_post SET status = "rejected" WHERE slug = "welcome-to-the-demo-blog-post-automation-testing-rejected"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_post SET status = "submitted" WHERE slug = "welcome-to-the-demo-blog-post-automation-testing-submitted"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_post SET status = "archived" WHERE slug = "welcome-to-the-demo-blog-post-automation-testing-archived"');

        $blogPost = $this->entityManager->getRepository(BlogPost::class)->findOneBy(['blogPostId' => 'af1b8f69-7074-39bc-9f2b-1250500be882']);

        if ($blogPost) {
            $blogPost->setTitle('Demo blog post for updates');
            $blogPost->setSlug('welcome-to-the-demo-blog-post-automation-testing');
            $blogPost->setContent('Welcome to the demo blog post for Automation Testing. Nulla asperiores consectetur doloribus molestias omnis in. Id nobis aut quo beatae incidunt totam. Doloribus neque officia a iste voluptatem ut. Quia molestias cumque vitae eum hic minus ullam. Non qui corrupti ipsam. Et et at voluptatibus ut dolores eos odit. Est sit vel ad ipsum et.\n\nFacere et temporibus id quia eos. Quia hic dolor ab voluptas doloribus repellat. Nobis cupiditate cum corrupti pariatur qui aut. Quidem non possimus et et dolor saepe quisquam. Voluptatem eum veniam velit porro temporibus ipsam odio exercitationem. Assumenda debitis autem dolor. Ut quis delectus suscipit at aspernatur vel. Et architecto voluptates ut reiciendis. Est et deserunt aut. Placeat aperiam eos in est hic.\n\nDolorem tempora iure libero quia. Id facere cumque iusto provident ut aut. Eos officiis eos culpa provident quo ut nulla. Labore quae autem sed reiciendis dicta. Corporis ipsam ut et consectetur cumque enim numquam. Cumque quasi ducimus quia eligendi voluptates expedita esse. Accusantium tempore laborum consequuntur numquam nisi sapiente aut. Minima corrupti eaque id sed fuga. Ad nam et illum consequatur rerum. Et vel voluptatibus aperiam aspernatur.\n\nQuae ea voluptates iste hic. Architecto et asperiores aut voluptatum. Magni voluptatem sunt labore porro illum reprehenderit rerum. Qui aut deserunt quo. Delectus illum aut praesentium accusantium accusamus. Perferendis quod ipsa aliquid consequatur consequatur. Molestiae aut modi sed doloribus pariatur maxime.\n\nDolor quidem harum sint dolorem qui nihil aperiam. Quia ipsa doloribus aut odio qui veritatis quia non. Totam et dolorem harum qui doloribus sunt quaerat. Doloribus qui voluptas facilis sed. Architecto est ipsam qui nam doloremque eligendi. Aut quidem facilis rem et est odit debitis. Quia rerum ut ut deserunt. Placeat architecto reiciendis qui unde. Molestias repudiandae ratione aut dolor.\n\nVel consectetur non expedita provident ut qui. Aperiam hic laudantium in quis pariatur. Libero dolor quis accusamus culpa. Quia et sunt atque quia et ut. Est vel rem ab fugit perspiciatis aspernatur nihil.\n\nPossimus consequatur harum sapiente adipisci repellat. Beatae iure dolorum porro nesciunt consequatur et eligendi. Temporibus rerum minima aut fugit. Nulla voluptas reprehenderit enim porro rerum. Consequatur voluptates dignissimos harum eaque harum similique. Dolore earum atque quisquam. Occaecati libero enim qui consequatur ut sit voluptatem. Quis blanditiis aut vero velit quia doloremque. Neque illum et magni delectus et sed quia ut.');
            $blogPost->setStatus(BlogPost::STATUS_PUBLISHED);
            $blogPost->setFeatured(null);
        }

        // Blog post comment
        $this->entityManager->getConnection()->executeQuery('DELETE FROM blog_post_comment WHERE comment = "Create blog post comment for Automation Testing"');
        $this->entityManager->getConnection()->executeQuery('UPDATE blog_post_comment SET status = "published" WHERE comment = "Demo blog post comment for Automation Testing with status PUBLISHED."');
        $blogPostComment = $this->entityManager->getRepository(BlogPostComment::class)->findOneBy(['blogPostCommentId' => '6578142c-b69a-3a05-8115-5f781b49b124']);

        if ($blogPostComment) {
            $blogPostComment->setComment('Demo blog post comment for Automation Testing.');
        }

        // Country
        $this->entityManager->getConnection()->executeQuery('DELETE FROM country WHERE id = "XX"');
        $this->entityManager->getConnection()->executeQuery('UPDATE country SET name = "Argentina" WHERE id = "AR"');
        $this->entityManager->getConnection()->executeQuery('UPDATE country SET name = "Bahamas" WHERE id = "BS"');

        // Information
        $this->entityManager->getConnection()->executeQuery('DELETE FROM information WHERE title = "Create information for Automation Testing"');
        $information = $this->entityManager->getRepository(Information::class)->findOneBy(['informationId' => '3c2a5006-4bb7-3f5b-8711-8b111c8da976']);

        if ($information) {
            $information->setTitle('Vitae deserunt nemo et ducimus aut optio rem.');
            $information->setInformation('Illo totam voluptas qui consectetur nihil minus non. Voluptate sequi deleniti est eaque dignissimos doloribus nulla. Qui eveniet illum quibusdam vel. Sed eius et dignissimos hic. Ut minima eius illum hic iusto.');
            $information->setInformationType(Information::TYPE_FAQ);
            $information->setActive(true);
            $information->setSortOrder(3);
        }

        // Region
        $this->entityManager->getConnection()->executeQuery('DELETE FROM region WHERE id = "NEW_REGION"');
        $this->entityManager->getConnection()->executeQuery('UPDATE region SET name = "Africa", sort_order = 1, active = 1 WHERE id = "AFRICA"');
        $this->entityManager->getConnection()->executeQuery('UPDATE region SET name = "Europe", sort_order = 4, active = 1 WHERE id = "EUROPE"');

        // User
        $this->entityManager->getConnection()->executeQuery('DELETE FROM user WHERE email = "create.user@example.com"');
        $this->entityManager->getConnection()->executeQuery('UPDATE user SET status="active", middle_name=null, job_title=null, description=null WHERE email="user2@example.net"');

        $this->entityManager->flush();


        $output->writeln([
            'Database cleaned up successfully.',
            '',
        ]);



        return Command::SUCCESS;
    }
}
