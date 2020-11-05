<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105134513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pot_log DROP FOREIGN KEY FK_67E45AF643F8423C');
        $this->addSql('DROP INDEX IDX_67E45AF643F8423C ON pot_log');
        $this->addSql('ALTER TABLE pot_log CHANGE pot_id_id pot_id INT NOT NULL');
        $this->addSql('ALTER TABLE pot_log ADD CONSTRAINT FK_67E45AF6DCDF6717 FOREIGN KEY (pot_id) REFERENCES pot (id)');
        $this->addSql('CREATE INDEX IDX_67E45AF6DCDF6717 ON pot_log (pot_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pot_log DROP FOREIGN KEY FK_67E45AF6DCDF6717');
        $this->addSql('DROP INDEX IDX_67E45AF6DCDF6717 ON pot_log');
        $this->addSql('ALTER TABLE pot_log CHANGE pot_id pot_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE pot_log ADD CONSTRAINT FK_67E45AF643F8423C FOREIGN KEY (pot_id_id) REFERENCES pot (id)');
        $this->addSql('CREATE INDEX IDX_67E45AF643F8423C ON pot_log (pot_id_id)');
    }
}
