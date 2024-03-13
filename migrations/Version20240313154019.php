<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313154019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_status (id INT AUTO_INCREMENT NOT NULL, rented_car TINYINT(1) NOT NULL, date_rental DATE DEFAULT NULL, returned_car TINYINT(1) NOT NULL, return_date DATE DEFAULT NULL, confirmed TINYINT(1) DEFAULT NULL, reserved_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B930547771386FB0 (reserved_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(100) DEFAULT NULL, date_contact DATE NOT NULL, message LONGTEXT NOT NULL, objet VARCHAR(100) NOT NULL, status_message TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE action_status ADD CONSTRAINT FK_B930547771386FB0 FOREIGN KEY (reserved_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DB83297E7');
        $this->addSql('DROP INDEX IDX_773DE69DB83297E7 ON car');
        $this->addSql('ALTER TABLE car ADD price_decoration INT DEFAULT NULL, ADD price_driver INT DEFAULT NULL, ADD quantity VARCHAR(255) NOT NULL, CHANGE number_place number_place VARCHAR(255) NOT NULL, CHANGE reservation_id price_seat_child INT DEFAULT NULL');
        $this->addSql('ALTER TABLE invoice ADD facture_pdf VARCHAR(255) DEFAULT NULL, DROP price_ht, CHANGE price_ttc price_ttc VARCHAR(255) DEFAULT NULL, CHANGE number number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD fichier_pdf VARCHAR(255) DEFAULT NULL, ADD stripe_session_id VARCHAR(255) DEFAULT NULL, ADD status TINYINT(1) DEFAULT NULL, ADD total_price DOUBLE PRECISION DEFAULT NULL, ADD confirmed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_status DROP FOREIGN KEY FK_B930547771386FB0');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE action_status');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE car ADD reservation_id INT DEFAULT NULL, DROP price_seat_child, DROP price_decoration, DROP price_driver, DROP quantity, CHANGE number_place number_place INT NOT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_773DE69DB83297E7 ON car (reservation_id)');
        $this->addSql('ALTER TABLE reservation DROP fichier_pdf, DROP stripe_session_id, DROP status, DROP total_price, DROP confirmed');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE available_at available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE invoice ADD price_ht DOUBLE PRECISION NOT NULL, DROP facture_pdf, CHANGE price_ttc price_ttc DOUBLE PRECISION NOT NULL, CHANGE number number INT NOT NULL');
    }
}
