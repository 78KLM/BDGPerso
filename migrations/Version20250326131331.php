<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250326131331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voitures DROP FOREIGN KEY FK_8B58301BC31BA576');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE couleur');
        $this->addSql('DROP INDEX IDX_8B58301BC31BA576 ON voitures');
        $this->addSql('ALTER TABLE voitures CHANGE couleur_id etat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voitures ADD CONSTRAINT FK_8B58301BD5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_8B58301BD5E86FF ON voitures (etat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voitures DROP FOREIGN KEY FK_8B58301BD5E86FF');
        $this->addSql('CREATE TABLE couleur (id INT AUTO_INCREMENT NOT NULL, nom_couleur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP INDEX IDX_8B58301BD5E86FF ON voitures');
        $this->addSql('ALTER TABLE voitures CHANGE etat_id couleur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voitures ADD CONSTRAINT FK_8B58301BC31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id)');
        $this->addSql('CREATE INDEX IDX_8B58301BC31BA576 ON voitures (couleur_id)');
    }
}
