<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration description: Change in database fields name so they will be in english :)
 */
final class Version20231129070342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE regon_data ADD county VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE regon_data ADD commune VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE regon_data DROP powiat');
        $this->addSql('ALTER TABLE regon_data DROP gmina');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN nazwa TO name');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN wojewodztwo TO voivodeship');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN miejscowosc TO town');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN kod_pocztowy TO postal_code');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN ulica TO street');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN typ TO type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE regon_data ADD powiat VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE regon_data ADD gmina VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE regon_data DROP county');
        $this->addSql('ALTER TABLE regon_data DROP commune');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN name TO nazwa');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN voivodeship TO wojewodztwo');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN town TO miejscowosc');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN postal_code TO kod_pocztowy');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN street TO ulica');
        $this->addSql('ALTER TABLE regon_data RENAME COLUMN type TO typ');
    }
}
