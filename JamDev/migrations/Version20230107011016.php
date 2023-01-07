<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107011016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologie_projets DROP FOREIGN KEY FK_7EEEB3FE261A27D2');
        $this->addSql('ALTER TABLE technologie_projets DROP FOREIGN KEY FK_7EEEB3FE597A6CB7');
        $this->addSql('DROP TABLE technologie_projets');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technologie_projets (technologie_id INT NOT NULL, projets_id INT NOT NULL, INDEX IDX_7EEEB3FE261A27D2 (technologie_id), INDEX IDX_7EEEB3FE597A6CB7 (projets_id), PRIMARY KEY(technologie_id, projets_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE technologie_projets ADD CONSTRAINT FK_7EEEB3FE261A27D2 FOREIGN KEY (technologie_id) REFERENCES technologie (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technologie_projets ADD CONSTRAINT FK_7EEEB3FE597A6CB7 FOREIGN KEY (projets_id) REFERENCES projets (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
