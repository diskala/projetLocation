<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114194304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC3C6F69F');
        $this->addSql('DROP INDEX UNIQ_C53D045FC3C6F69F ON image');
        $this->addSql('ALTER TABLE image CHANGE car_id cars_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8702F506 FOREIGN KEY (cars_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F8702F506 ON image (cars_id)');
        $this->addSql('ALTER TABLE invoice ADD number INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP number');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8702F506');
        $this->addSql('DROP INDEX IDX_C53D045F8702F506 ON image');
        $this->addSql('ALTER TABLE image CHANGE cars_id car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045FC3C6F69F ON image (car_id)');
    }
}
