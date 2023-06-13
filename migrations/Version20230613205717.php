<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613205717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, index_number INT DEFAULT NULL, volume VARCHAR(255) DEFAULT NULL, short_description LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, barcode VARCHAR(255) DEFAULT NULL, cover LONGTEXT DEFAULT NULL, more_information LONGTEXT DEFAULT NULL, INDEX IDX_CBE5A33112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_book_author (book_id INT NOT NULL, book_author_id INT NOT NULL, INDEX IDX_C68F9C3916A2B381 (book_id), INDEX IDX_C68F9C39E4DBE55D (book_author_id), PRIMARY KEY(book_id, book_author_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_keyword (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_keyword_book (book_keyword_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_7552E46B8EF00FE1 (book_keyword_id), INDEX IDX_7552E46B16A2B381 (book_id), PRIMARY KEY(book_keyword_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_loan (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, client_id INT NOT NULL, start_date DATE NOT NULL, expected_end_date DATE NOT NULL, end_date DATE DEFAULT NULL, INDEX IDX_DC4E460B16A2B381 (book_id), INDEX IDX_DC4E460B19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, client_group_id INT DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, INDEX IDX_C7440455D0B2E982 (client_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_group (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES book_category (id)');
        $this->addSql('ALTER TABLE book_book_author ADD CONSTRAINT FK_C68F9C3916A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_book_author ADD CONSTRAINT FK_C68F9C39E4DBE55D FOREIGN KEY (book_author_id) REFERENCES book_author (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_keyword_book ADD CONSTRAINT FK_7552E46B8EF00FE1 FOREIGN KEY (book_keyword_id) REFERENCES book_keyword (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_keyword_book ADD CONSTRAINT FK_7552E46B16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book_loan ADD CONSTRAINT FK_DC4E460B16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_loan ADD CONSTRAINT FK_DC4E460B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455D0B2E982 FOREIGN KEY (client_group_id) REFERENCES client_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('ALTER TABLE book_book_author DROP FOREIGN KEY FK_C68F9C3916A2B381');
        $this->addSql('ALTER TABLE book_book_author DROP FOREIGN KEY FK_C68F9C39E4DBE55D');
        $this->addSql('ALTER TABLE book_keyword_book DROP FOREIGN KEY FK_7552E46B8EF00FE1');
        $this->addSql('ALTER TABLE book_keyword_book DROP FOREIGN KEY FK_7552E46B16A2B381');
        $this->addSql('ALTER TABLE book_loan DROP FOREIGN KEY FK_DC4E460B16A2B381');
        $this->addSql('ALTER TABLE book_loan DROP FOREIGN KEY FK_DC4E460B19EB6921');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455D0B2E982');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_book_author');
        $this->addSql('DROP TABLE book_author');
        $this->addSql('DROP TABLE book_category');
        $this->addSql('DROP TABLE book_keyword');
        $this->addSql('DROP TABLE book_keyword_book');
        $this->addSql('DROP TABLE book_loan');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_group');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
