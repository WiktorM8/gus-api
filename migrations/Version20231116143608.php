<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116143608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE regon_data_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE RegonData_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE RegonData (id INT NOT NULL, regon VARCHAR(14) NOT NULL, nazwa VARCHAR(60) NOT NULL, wojewodztwo VARCHAR(20) NOT NULL, powiat VARCHAR(30) NOT NULL, gmina VARCHAR(30) NOT NULL, miejscowosc VARCHAR(43) NOT NULL, kod_pocztowy VARCHAR(6) NOT NULL, ulica VARCHAR(40) NOT NULL, typ VARCHAR(2) NOT NULL, silos_id SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE regon_data');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE RegonData_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE regon_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE regon_data (id INT NOT NULL, regon VARCHAR(14) NOT NULL, nazwa VARCHAR(60) NOT NULL, wojewodztwo VARCHAR(20) NOT NULL, powiat VARCHAR(30) NOT NULL, gmina VARCHAR(30) NOT NULL, miejscowosc VARCHAR(43) NOT NULL, kod_pocztowy VARCHAR(6) NOT NULL, ulica VARCHAR(40) NOT NULL, typ VARCHAR(2) NOT NULL, silos_id SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE RegonData');
    }
}
