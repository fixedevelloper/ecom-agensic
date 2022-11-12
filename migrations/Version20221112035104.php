<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221112035104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD company VARCHAR(255) DEFAULT NULL, ADD address_1 VARCHAR(255) DEFAULT NULL, ADD address_2 VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD state VARCHAR(255) DEFAULT NULL, ADD postcode VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD date_created DATETIME DEFAULT NULL, ADD date_modified DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD date_created DATETIME DEFAULT NULL, ADD date_modified DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD date_created DATETIME DEFAULT NULL, ADD date_modified DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE shipping ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD company VARCHAR(255) DEFAULT NULL, ADD address_1 VARCHAR(255) DEFAULT NULL, ADD address_2 VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD state VARCHAR(255) DEFAULT NULL, ADD postcode VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shop ADD date_created DATETIME DEFAULT NULL, ADD date_modified DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE shop_order ADD date_created DATETIME DEFAULT NULL, ADD date_modified DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE variation ADD date_created DATETIME DEFAULT NULL, ADD date_modified DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing DROP first_name, DROP last_name, DROP company, DROP address_1, DROP address_2, DROP city, DROP state, DROP postcode, DROP country, DROP email');
        $this->addSql('ALTER TABLE image DROP date_created, DROP date_modified');
        $this->addSql('ALTER TABLE `order` DROP date_created, DROP date_modified');
        $this->addSql('ALTER TABLE product DROP date_created, DROP date_modified');
        $this->addSql('ALTER TABLE shipping DROP first_name, DROP last_name, DROP company, DROP address_1, DROP address_2, DROP city, DROP state, DROP postcode, DROP country, DROP email');
        $this->addSql('ALTER TABLE shop DROP date_created, DROP date_modified');
        $this->addSql('ALTER TABLE shop_order DROP date_created, DROP date_modified');
        $this->addSql('ALTER TABLE variation DROP date_created, DROP date_modified');
    }
}
