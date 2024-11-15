<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113140101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0B7942F03');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B7942F03');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, coach_id INT NOT NULL, zone_id INT NOT NULL, notifcation_id INT DEFAULT NULL, title VARCHAR(20) NOT NULL, description LONGTEXT NOT NULL, available_places INT NOT NULL, start_datetime DATETIME NOT NULL, duration NUMERIC(10, 0) NOT NULL, INDEX IDX_169E6FB93C105691 (coach_id), INDEX IDX_169E6FB99F2C3FAB (zone_id), INDEX IDX_169E6FB978BA0164 (notifcation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB93C105691 FOREIGN KEY (coach_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB99F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB978BA0164 FOREIGN KEY (notifcation_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF69F2C3FAB');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6B7942F03');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F78BA0164');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F9F2C3FAB');
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FA76ED395');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE cour');
        $this->addSql('DROP INDEX IDX_8F91ABF0B7942F03 ON avis');
        $this->addSql('ALTER TABLE avis CHANGE cour_id course_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0591CC992 ON avis (course_id)');
        $this->addSql('DROP INDEX IDX_42C84955B7942F03 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP reservation_date, DROP reservation_time, CHANGE cour_id course_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_42C84955591CC992 ON reservation (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0591CC992');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955591CC992');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, cour_id INT NOT NULL, zone_id INT NOT NULL, date DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_D499BFF6B7942F03 (cour_id), INDEX IDX_D499BFF69F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cour (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, zone_id INT NOT NULL, notifcation_id INT DEFAULT NULL, title VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, disponible TINYINT(1) NOT NULL, nombre_place_disponible INT NOT NULL, calendrier DATETIME NOT NULL, duration NUMERIC(10, 0) NOT NULL, INDEX IDX_A71F964FA76ED395 (user_id), INDEX IDX_A71F964F9F2C3FAB (zone_id), INDEX IDX_A71F964F78BA0164 (notifcation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF69F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F78BA0164 FOREIGN KEY (notifcation_id) REFERENCES notification (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB93C105691');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB99F2C3FAB');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB978BA0164');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP INDEX IDX_8F91ABF0591CC992 ON avis');
        $this->addSql('ALTER TABLE avis CHANGE course_id cour_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8F91ABF0B7942F03 ON avis (cour_id)');
        $this->addSql('DROP INDEX IDX_42C84955591CC992 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD reservation_date DATE NOT NULL, ADD reservation_time TIME NOT NULL, DROP created_at, DROP updated_at, CHANGE course_id cour_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B7942F03 FOREIGN KEY (cour_id) REFERENCES cour (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_42C84955B7942F03 ON reservation (cour_id)');
    }
}
