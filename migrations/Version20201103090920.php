<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103090920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pot (id INT AUTO_INCREMENT NOT NULL, added_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pot_log (id INT AUTO_INCREMENT NOT NULL, pot_id_id INT NOT NULL, luminosity INT NOT NULL, humidity INT NOT NULL, temperature INT NOT NULL, soil_moisture_top INT NOT NULL, soil_moisture_middel INT NOT NULL, soil_moisture_bottom INT NOT NULL, ph INT NOT NULL, resevoir INT NOT NULL, INDEX IDX_67E45AF643F8423C (pot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pot_log ADD CONSTRAINT FK_67E45AF643F8423C FOREIGN KEY (pot_id_id) REFERENCES pot (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pot_log DROP FOREIGN KEY FK_67E45AF643F8423C');
        $this->addSql('DROP TABLE pot');
        $this->addSql('DROP TABLE pot_log');
    }
}
