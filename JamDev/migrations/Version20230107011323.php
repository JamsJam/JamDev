<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107011323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projets_technologie (projets_id INT NOT NULL, technologie_id INT NOT NULL, INDEX IDX_1B42517B597A6CB7 (projets_id), INDEX IDX_1B42517B261A27D2 (technologie_id), PRIMARY KEY(projets_id, technologie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projets_technologie ADD CONSTRAINT FK_1B42517B597A6CB7 FOREIGN KEY (projets_id) REFERENCES projets (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projets_technologie ADD CONSTRAINT FK_1B42517B261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projets_technologie DROP FOREIGN KEY FK_1B42517B597A6CB7');
        $this->addSql('ALTER TABLE projets_technologie DROP FOREIGN KEY FK_1B42517B261A27D2');
        $this->addSql('DROP TABLE projets_technologie');
    }
}
