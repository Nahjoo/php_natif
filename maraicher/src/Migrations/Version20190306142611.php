<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190306142611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE legume (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, variete VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rotation (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, legume_id INT DEFAULT NULL, tache_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_297C98F19F2C3FAB (zone_id), INDEX IDX_297C98F125F18E37 (legume_id), INDEX IDX_297C98F1D2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rotation ADD CONSTRAINT FK_297C98F19F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE rotation ADD CONSTRAINT FK_297C98F125F18E37 FOREIGN KEY (legume_id) REFERENCES legume (id)');
        $this->addSql('ALTER TABLE rotation ADD CONSTRAINT FK_297C98F1D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rotation DROP FOREIGN KEY FK_297C98F125F18E37');
        $this->addSql('ALTER TABLE rotation DROP FOREIGN KEY FK_297C98F1D2235D39');
        $this->addSql('ALTER TABLE rotation DROP FOREIGN KEY FK_297C98F19F2C3FAB');
        $this->addSql('DROP TABLE legume');
        $this->addSql('DROP TABLE rotation');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE zone');
    }
}
