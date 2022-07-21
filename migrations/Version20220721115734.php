<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721115734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE birth_date birth_date DATETIME NOT NULL, CHANGE death_date death_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book CHANGE published_at published_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE birth_date birth_date VARCHAR(255) NOT NULL, CHANGE death_date death_date VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book CHANGE published_at published_at VARCHAR(255) NOT NULL');
    }
}
