<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313151101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rotation ADD planche_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rotation ADD CONSTRAINT FK_297C98F1DA8652A8 FOREIGN KEY (planche_id) REFERENCES planche (id)');
        $this->addSql('CREATE INDEX IDX_297C98F1DA8652A8 ON rotation (planche_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rotation DROP FOREIGN KEY FK_297C98F1DA8652A8');
        $this->addSql('DROP INDEX IDX_297C98F1DA8652A8 ON rotation');
        $this->addSql('ALTER TABLE rotation DROP planche_id');
    }
}
