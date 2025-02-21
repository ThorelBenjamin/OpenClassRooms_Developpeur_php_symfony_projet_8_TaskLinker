<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220223106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etiquette ADD projet_id INT NOT NULL');
        $this->addSql('ALTER TABLE etiquette ADD CONSTRAINT FK_1E0E195AC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_1E0E195AC18272 ON etiquette (projet_id)');
        $this->addSql('ALTER TABLE tache ADD statut_id INT NOT NULL, ADD employe_id INT NOT NULL');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720751B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_93872075F6203804 ON tache (statut_id)');
        $this->addSql('CREATE INDEX IDX_938720751B65292 ON tache (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etiquette DROP FOREIGN KEY FK_1E0E195AC18272');
        $this->addSql('DROP INDEX IDX_1E0E195AC18272 ON etiquette');
        $this->addSql('ALTER TABLE etiquette DROP projet_id');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075F6203804');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_938720751B65292');
        $this->addSql('DROP INDEX IDX_93872075F6203804 ON tache');
        $this->addSql('DROP INDEX IDX_938720751B65292 ON tache');
        $this->addSql('ALTER TABLE tache DROP statut_id, DROP employe_id');
    }
}
