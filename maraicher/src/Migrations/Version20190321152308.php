<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321152308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE serre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rotation ADD serre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rotation ADD CONSTRAINT FK_297C98F1CE732E2E FOREIGN KEY (serre_id) REFERENCES serre (id)');
        $this->addSql('CREATE INDEX IDX_297C98F1CE732E2E ON rotation (serre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rotation DROP FOREIGN KEY FK_297C98F1CE732E2E');
        $this->addSql('DROP TABLE serre');
        $this->addSql('DROP INDEX IDX_297C98F1CE732E2E ON rotation');
        $this->addSql('ALTER TABLE rotation DROP serre_id');
    }
}
