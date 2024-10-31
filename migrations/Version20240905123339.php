<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905123339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, cour_id INT NOT NULL, zone_id INT NOT NULL, date DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_D499BFF6B7942F03 (cour_id), INDEX IDX_D499BFF69F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF69F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE planing DROP FOREIGN KEY FK_1E375CC49F2C3FAB');
        $this->addSql('ALTER TABLE planing DROP FOREIGN KEY FK_1E375CC4B7942F03');
        $this->addSql('DROP TABLE planing');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE planing (id INT AUTO_INCREMENT NOT NULL, cour_id INT NOT NULL, zone_id INT NOT NULL, date DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_1E375CC49F2C3FAB (zone_id), INDEX IDX_1E375CC4B7942F03 (cour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE planing ADD CONSTRAINT FK_1E375CC49F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE planing ADD CONSTRAINT FK_1E375CC4B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6B7942F03');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF69F2C3FAB');
        $this->addSql('DROP TABLE planning');
    }
}
