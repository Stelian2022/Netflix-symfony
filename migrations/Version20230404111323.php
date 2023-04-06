<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404111323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_full DROP mpaa, DROP rating, DROP popularity, DROP poster_flag, CHANGE title title VARCHAR(255) NOT NULL, CHANGE genres genres VARCHAR(255) NOT NULL, CHANGE plot plot LONGTEXT NOT NULL, CHANGE directors directors VARCHAR(255) NOT NULL, CHANGE cast cast LONGTEXT NOT NULL, CHANGE runtime runtime INT NOT NULL, CHANGE modified modified DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE created created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE slug writers VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_full ADD mpaa VARCHAR(25) DEFAULT NULL, ADD rating SMALLINT NOT NULL, ADD popularity INT DEFAULT NULL, ADD poster_flag TINYINT(1) DEFAULT 0 NOT NULL, CHANGE title title TEXT NOT NULL, CHANGE genres genres VARCHAR(255) DEFAULT NULL, CHANGE plot plot TEXT DEFAULT NULL, CHANGE directors directors VARCHAR(255) DEFAULT NULL, CHANGE cast cast VARCHAR(255) DEFAULT NULL, CHANGE runtime runtime INT DEFAULT NULL, CHANGE modified modified DATETIME NOT NULL, CHANGE created created DATETIME DEFAULT NULL, CHANGE writers slug VARCHAR(255) NOT NULL');
    }
}
