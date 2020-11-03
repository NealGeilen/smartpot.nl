<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103200959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pot ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pot ADD CONSTRAINT FK_1EBD730F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1EBD730F7E3C61F9 ON pot (owner_id)');
        $this->addSql('ALTER TABLE user ADD api_token VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pot DROP FOREIGN KEY FK_1EBD730F7E3C61F9');
        $this->addSql('DROP INDEX IDX_1EBD730F7E3C61F9 ON pot');
        $this->addSql('ALTER TABLE pot DROP owner_id');
        $this->addSql('ALTER TABLE user DROP api_token');
    }
}
