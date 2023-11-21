<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116151645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE regon_data ALTER nazwa TYPE VARCHAR(120)');
        $this->addSql('ALTER TABLE regon_data ALTER wojewodztwo TYPE VARCHAR(40)');
        $this->addSql('ALTER TABLE regon_data ALTER powiat TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE regon_data ALTER gmina TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE regon_data ALTER ulica TYPE VARCHAR(70)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE regon_data ALTER nazwa TYPE VARCHAR(60)');
        $this->addSql('ALTER TABLE regon_data ALTER wojewodztwo TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE regon_data ALTER powiat TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE regon_data ALTER gmina TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE regon_data ALTER ulica TYPE VARCHAR(40)');
    }
}
