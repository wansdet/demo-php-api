<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019120559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_category (blog_category_code VARCHAR(30) NOT NULL, active TINYINT(1) NOT NULL, blog_category_name VARCHAR(30) NOT NULL, created_by VARCHAR(100) NOT NULL, sort_order SMALLINT NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(blog_category_code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_post (id INT AUTO_INCREMENT NOT NULL, blog_category_code VARCHAR(30) NOT NULL, author_id INT NOT NULL, blog_post_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', content VARCHAR(4000) NOT NULL, created_by VARCHAR(100) NOT NULL, featured SMALLINT DEFAULT NULL, slug VARCHAR(255) NOT NULL, status VARCHAR(20) NOT NULL, tags VARCHAR(255) DEFAULT NULL, title VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BA5AE01DA77FBEAF (blog_post_id), UNIQUE INDEX UNIQ_BA5AE01D989D9B62 (slug), INDEX IDX_BA5AE01D8F0880B3 (blog_category_code), INDEX IDX_BA5AE01DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_post_comment (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT NOT NULL, author_id INT NOT NULL, blog_post_comment_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', comment VARCHAR(1000) NOT NULL, created_by VARCHAR(100) NOT NULL, rating SMALLINT DEFAULT NULL, status VARCHAR(20) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F3400AD869E80851 (blog_post_comment_id), INDEX IDX_F3400AD8A77FBEAF (blog_post_id), INDEX IDX_F3400AD8F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_post_image (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT NOT NULL, created_by VARCHAR(100) NOT NULL, filename VARCHAR(255) DEFAULT NULL, title VARCHAR(50) DEFAULT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_B4E0AA59A77FBEAF (blog_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (country_code VARCHAR(2) NOT NULL, region_code VARCHAR(20) NOT NULL, active TINYINT(1) NOT NULL, country_name VARCHAR(100) NOT NULL, created_by VARCHAR(100) NOT NULL, sort_order SMALLINT NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5373C966AEB327AF (region_code), PRIMARY KEY(country_code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, path VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D8698A76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, created_by VARCHAR(100) NOT NULL, information VARCHAR(1000) NOT NULL, information_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', information_type VARCHAR(30) NOT NULL, sort_order SMALLINT NOT NULL, sub_title VARCHAR(100) DEFAULT NULL, title VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_297918832EF03101 (information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (region_code VARCHAR(20) NOT NULL, active TINYINT(1) NOT NULL, created_by VARCHAR(100) NOT NULL, region_name VARCHAR(20) NOT NULL, sort_order SMALLINT NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(region_code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, created_by VARCHAR(100) NOT NULL, description VARCHAR(500) DEFAULT NULL, display_name VARCHAR(20) DEFAULT NULL, dob DATE DEFAULT NULL, email VARCHAR(180) NOT NULL, first_name VARCHAR(50) NOT NULL, job_title VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) NOT NULL, middle_name VARCHAR(50) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, sex VARCHAR(20) DEFAULT NULL, status VARCHAR(10) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D8F0880B3 FOREIGN KEY (blog_category_code) REFERENCES blog_category (blog_category_code)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog_post_comment ADD CONSTRAINT FK_F3400AD8A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id)');
        $this->addSql('ALTER TABLE blog_post_comment ADD CONSTRAINT FK_F3400AD8F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog_post_image ADD CONSTRAINT FK_B4E0AA59A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966AEB327AF FOREIGN KEY (region_code) REFERENCES region (region_code)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D8F0880B3');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01DF675F31B');
        $this->addSql('ALTER TABLE blog_post_comment DROP FOREIGN KEY FK_F3400AD8A77FBEAF');
        $this->addSql('ALTER TABLE blog_post_comment DROP FOREIGN KEY FK_F3400AD8F675F31B');
        $this->addSql('ALTER TABLE blog_post_image DROP FOREIGN KEY FK_B4E0AA59A77FBEAF');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C966AEB327AF');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A76ED395');
        $this->addSql('DROP TABLE blog_category');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE blog_post_comment');
        $this->addSql('DROP TABLE blog_post_image');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE information');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
