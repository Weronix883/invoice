<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928173049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_rental_history_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE invoice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE invoice (id INT NOT NULL, buyer VARCHAR(255) NOT NULL, supplier VARCHAR(255) NOT NULL, net DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, gross DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE position (id INT NOT NULL, invoice_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, net DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, gross DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_462CE4F52989F1FD ON position (invoice_id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F52989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_rental_history DROP CONSTRAINT fk_fd8f0fb771868b2e');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_rental_history');
        $this->addSql('DROP TABLE book_of_guests');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE invoice_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE position_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_rental_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, borrowed BOOLEAN NOT NULL, rental_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, category VARCHAR(255) NOT NULL, creation_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, removed BOOLEAN NOT NULL, remove_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book_rental_history (id INT NOT NULL, book_id_id INT NOT NULL, rental_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, return_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_fd8f0fb771868b2e ON book_rental_history (book_id_id)');
        $this->addSql('CREATE TABLE book_of_guests (id INT NOT NULL, guest_name VARCHAR(255) NOT NULL, guest_surname VARCHAR(255) NOT NULL, date_of_visit TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, comment TEXT NOT NULL)');
        $this->addSql('ALTER TABLE book_rental_history ADD CONSTRAINT fk_fd8f0fb771868b2e FOREIGN KEY (book_id_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F52989F1FD');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE position');
    }
}
