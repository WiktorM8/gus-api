<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116142946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE regon_data ALTER regon TYPE VARCHAR(14)');
        $this->addSql('ALTER TABLE regon_data ALTER nazwa TYPE VARCHAR(60)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE regon_data ALTER regon TYPE TEXT');
        $this->addSql('ALTER TABLE regon_data ALTER regon TYPE TEXT');
        $this->addSql('ALTER TABLE regon_data ALTER nazwa TYPE TEXT');
        $this->addSql('ALTER TABLE regon_data ALTER nazwa TYPE TEXT');
    }
}
