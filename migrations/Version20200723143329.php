<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723143329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choix (id INT AUTO_INCREMENT NOT NULL, option1 VARCHAR(255) NOT NULL, option2 VARCHAR(255) NOT NULL, option3 VARCHAR(255) DEFAULT NULL, option4 VARCHAR(255) DEFAULT NULL, option5 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poll (id INT AUTO_INCREMENT NOT NULL, choix_id INT NOT NULL, resultats_id INT NOT NULL, question VARCHAR(255) NOT NULL, public TINYINT(1) NOT NULL, datetime DATETIME NOT NULL, url VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_84BCFA45D9144651 (choix_id), UNIQUE INDEX UNIQ_84BCFA45857E9313 (resultats_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultats (id INT AUTO_INCREMENT NOT NULL, res1 INT NOT NULL, res2 INT NOT NULL, res3 INT NOT NULL, res4 INT NOT NULL, res5 INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poll ADD CONSTRAINT FK_84BCFA45D9144651 FOREIGN KEY (choix_id) REFERENCES choix (id)');
        $this->addSql('ALTER TABLE poll ADD CONSTRAINT FK_84BCFA45857E9313 FOREIGN KEY (resultats_id) REFERENCES resultats (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poll DROP FOREIGN KEY FK_84BCFA45D9144651');
        $this->addSql('ALTER TABLE poll DROP FOREIGN KEY FK_84BCFA45857E9313');
        $this->addSql('DROP TABLE choix');
        $this->addSql('DROP TABLE poll');
        $this->addSql('DROP TABLE resultats');
        $this->addSql('DROP TABLE user');
    }
}
