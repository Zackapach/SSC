<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830122115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forfait ADD user_profil_id INT NOT NULL, CHANGE name name LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE forfait ADD CONSTRAINT FK_BBB5C48227BE5D9C FOREIGN KEY (user_profil_id) REFERENCES user_profil (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BBB5C48227BE5D9C ON forfait (user_profil_id)');
        $this->addSql('ALTER TABLE reservation ADD reservation_time TIME NOT NULL, CHANGE reservation_date reservation_date DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP reservation_time, CHANGE reservation_date reservation_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE forfait DROP FOREIGN KEY FK_BBB5C48227BE5D9C');
        $this->addSql('DROP INDEX UNIQ_BBB5C48227BE5D9C ON forfait');
        $this->addSql('ALTER TABLE forfait DROP user_profil_id, CHANGE name name VARCHAR(50) NOT NULL');
    }
}
