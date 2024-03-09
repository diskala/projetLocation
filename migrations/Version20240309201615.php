<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240309201615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_status (id INT AUTO_INCREMENT NOT NULL, reserved_id INT DEFAULT NULL, rented_car TINYINT(1) NOT NULL, date_rental DATE DEFAULT NULL, returned_car TINYINT(1) NOT NULL, return_date DATE DEFAULT NULL, confirmed TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_B930547771386FB0 (reserved_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, city VARCHAR(100) NOT NULL, departement VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, brand VARCHAR(100) NOT NULL, model VARCHAR(100) NOT NULL, category VARCHAR(100) NOT NULL, energy VARCHAR(100) NOT NULL, power VARCHAR(100) NOT NULL, gear_box VARCHAR(100) NOT NULL, number_place VARCHAR(255) NOT NULL, price_day DOUBLE PRECISION NOT NULL, price_dpkm DOUBLE PRECISION NOT NULL, price_km_unlimited DOUBLE PRECISION NOT NULL, stock INT NOT NULL, bail DOUBLE PRECISION NOT NULL, available TINYINT(1) NOT NULL, price_seat_child INT DEFAULT NULL, price_decoration INT DEFAULT NULL, price_driver INT DEFAULT NULL, quantity VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_773DE69D3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(100) DEFAULT NULL, date_contact DATE NOT NULL, message LONGTEXT NOT NULL, objet VARCHAR(100) NOT NULL, status_message TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, image1 VARCHAR(255) NOT NULL, image2 VARCHAR(255) DEFAULT NULL, image3 VARCHAR(255) DEFAULT NULL, image4 VARCHAR(255) DEFAULT NULL, image5 VARCHAR(255) DEFAULT NULL, image6 VARCHAR(255) DEFAULT NULL, image7 VARCHAR(255) DEFAULT NULL, image8 VARCHAR(255) DEFAULT NULL, image9 VARCHAR(255) DEFAULT NULL, image10 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, reserve_id INT DEFAULT NULL, price_ttc VARCHAR(255) DEFAULT NULL, number VARCHAR(255) NOT NULL, facture_pdf VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_906517445913AEBF (reserve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, car_id INT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, bail TINYINT(1) DEFAULT NULL, option_driver TINYINT(1) DEFAULT NULL, opt_child_seat TINYINT(1) DEFAULT NULL, decoration TINYINT(1) DEFAULT NULL, day_date DATE DEFAULT NULL, priceunlimited_km TINYINT(1) DEFAULT NULL, fichier_pdf VARCHAR(255) DEFAULT NULL, stripe_session_id VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, total_price DOUBLE PRECISION DEFAULT NULL, confirmed TINYINT(1) DEFAULT NULL, INDEX IDX_42C8495567B3B43D (users_id), INDEX IDX_42C84955C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, address VARCHAR(255) NOT NULL, phone VARCHAR(100) NOT NULL, birth_date DATE DEFAULT NULL, date_driving_licence DATE DEFAULT NULL, campany VARCHAR(100) DEFAULT NULL, siret VARCHAR(13) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_status ADD CONSTRAINT FK_B930547771386FB0 FOREIGN KEY (reserved_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517445913AEBF FOREIGN KEY (reserve_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_status DROP FOREIGN KEY FK_B930547771386FB0');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3DA5256D');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517445913AEBF');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495567B3B43D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C3C6F69F');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE action_status');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
