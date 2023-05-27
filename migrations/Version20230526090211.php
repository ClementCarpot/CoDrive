<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526090211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD prix NUMERIC(4, 0) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD heure_depart TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD date_depart DATE NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD vehicule VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP role');
        $this->addSql('ALTER TABLE utilisateur ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ALTER nom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateur ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ALTER prenom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateur ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE utilisateur RENAME COLUMN mot_de_passe TO password');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateur ADD role VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP roles');
        $this->addSql('ALTER TABLE utilisateur ALTER email TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE utilisateur ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ALTER nom TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE utilisateur ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ALTER prenom TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE utilisateur RENAME COLUMN password TO mot_de_passe');
        $this->addSql('ALTER TABLE annonce DROP prix');
        $this->addSql('ALTER TABLE annonce DROP heure_depart');
        $this->addSql('ALTER TABLE annonce DROP date_depart');
        $this->addSql('ALTER TABLE annonce DROP vehicule');
    }
}
