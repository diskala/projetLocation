<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207160103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_status ADD invoice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action_status ADD CONSTRAINT FK_B93054772989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B93054772989F1FD ON action_status (invoice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_status DROP FOREIGN KEY FK_B93054772989F1FD');
        $this->addSql('DROP INDEX UNIQ_B93054772989F1FD ON action_status');
        $this->addSql('ALTER TABLE action_status DROP invoice_id');
    }
}
