<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502132537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE blog_category (blog_category_code VARCHAR(30) NOT NULL, active TINYINT(1) NOT NULL, blog_category_name VARCHAR(30) NOT NULL, created_by VARCHAR(100) NOT NULL, sort_order SMALLINT NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(blog_category_code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE blog_post (id INT AUTO_INCREMENT NOT NULL, blog_category_code VARCHAR(30) NOT NULL, author_id INT NOT NULL, blog_post_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', content VARCHAR(4000) NOT NULL, created_by VARCHAR(100) NOT NULL, featured SMALLINT DEFAULT NULL, slug VARCHAR(255) NOT NULL, status VARCHAR(20) NOT NULL, tags VARCHAR(255) DEFAULT NULL, title VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BA5AE01DA77FBEAF (blog_post_id), UNIQUE INDEX UNIQ_BA5AE01D989D9B62 (slug), INDEX IDX_BA5AE01D8F0880B3 (blog_category_code), INDEX IDX_BA5AE01DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE blog_post_comment (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT NOT NULL, author_id INT NOT NULL, blog_post_comment_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', comment VARCHAR(1000) NOT NULL, created_by VARCHAR(100) NOT NULL, rating SMALLINT DEFAULT NULL, status VARCHAR(20) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F3400AD869E80851 (blog_post_comment_id), INDEX IDX_F3400AD8A77FBEAF (blog_post_id), INDEX IDX_F3400AD8F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE blog_post_image (id INT AUTO_INCREMENT NOT NULL, blog_post_id INT NOT NULL, created_by VARCHAR(100) NOT NULL, filename VARCHAR(255) DEFAULT NULL, title VARCHAR(50) DEFAULT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_B4E0AA59A77FBEAF (blog_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE country (id VARCHAR(2) NOT NULL, region_id VARCHAR(20) NOT NULL, name VARCHAR(100) NOT NULL, active TINYINT(1) NOT NULL, sort_order SMALLINT NOT NULL, created_by VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_5373C96698260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, path VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D8698A76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, created_by VARCHAR(100) NOT NULL, information VARCHAR(1000) NOT NULL, information_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', information_type VARCHAR(30) NOT NULL, sort_order SMALLINT NOT NULL, sub_title VARCHAR(100) DEFAULT NULL, title VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_297918832EF03101 (information_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE region (id VARCHAR(20) NOT NULL, name VARCHAR(20) NOT NULL, brief_description VARCHAR(500) NOT NULL, short_description VARCHAR(2000) NOT NULL, long_description LONGTEXT NOT NULL, active TINYINT(1) NOT NULL, sort_order SMALLINT NOT NULL, created_by VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, country_id VARCHAR(2) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', title VARCHAR(20) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, middle_name VARCHAR(50) DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, birth_year SMALLINT DEFAULT NULL, display_name VARCHAR(20) NOT NULL, job_title VARCHAR(50) DEFAULT NULL, description VARCHAR(500) DEFAULT NULL, customer_number INT DEFAULT NULL, status VARCHAR(10) NOT NULL, created_by VARCHAR(100) NOT NULL, updated_by VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A76ED395 (user_id), UNIQUE INDEX UNIQ_8D93D649D5499347 (display_name), INDEX IDX_8D93D649F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D8F0880B3 FOREIGN KEY (blog_category_code) REFERENCES blog_category (blog_category_code)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post_comment ADD CONSTRAINT FK_F3400AD8A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post_comment ADD CONSTRAINT FK_F3400AD8F675F31B FOREIGN KEY (author_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post_image ADD CONSTRAINT FK_B4E0AA59A77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE country ADD CONSTRAINT FK_5373C96698260155 FOREIGN KEY (region_id) REFERENCES region (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D8F0880B3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01DF675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post_comment DROP FOREIGN KEY FK_F3400AD8A77FBEAF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post_comment DROP FOREIGN KEY FK_F3400AD8F675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE blog_post_image DROP FOREIGN KEY FK_B4E0AA59A77FBEAF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE country DROP FOREIGN KEY FK_5373C96698260155
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F92F3E70
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blog_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blog_post
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blog_post_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE blog_post_image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE country
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE document
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE information
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE region
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
