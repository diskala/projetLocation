<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240126190649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_status (id INT AUTO_INCREMENT NOT NULL, reserved_id INT DEFAULT NULL, rented_car TINYINT(1) NOT NULL, date_rental DATE NOT NULL, returned_car TINYINT(1) NOT NULL, return_date DATE NOT NULL, UNIQUE INDEX UNIQ_B930547771386FB0 (reserved_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_status ADD CONSTRAINT FK_B930547771386FB0 FOREIGN KEY (reserved_id) REFERENCES reservation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_status DROP FOREIGN KEY FK_B930547771386FB0');
        $this->addSql('DROP TABLE action_status');
    }
}
