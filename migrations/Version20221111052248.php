<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111052248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, speciality_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, address2 VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, countrycode VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, phone2 VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_AC6A4CA23B5A08D7 (speciality_id), UNIQUE INDEX UNIQ_AC6A4CA2F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_order (id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, parent_order_id INT DEFAULT NULL, total DOUBLE PRECISION NOT NULL, total_tax DOUBLE PRECISION NOT NULL, prices_include_tax TINYINT(1) DEFAULT NULL, discount_total DOUBLE PRECISION DEFAULT NULL, discount_tax DOUBLE PRECISION DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_323FC9CA4D16C4DD (shop_id), INDEX IDX_323FC9CA1252C1E9 (parent_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_order_line (id INT AUTO_INCREMENT NOT NULL, shop_order_id INT DEFAULT NULL, lineorder_id INT DEFAULT NULL, INDEX IDX_E69663C7562797AE (shop_order_id), UNIQUE INDEX UNIQ_E69663C74C730D22 (lineorder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality_shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA23B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality_shop (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2F2C56620 FOREIGN KEY (compte_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shop_order ADD CONSTRAINT FK_323FC9CA4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE shop_order ADD CONSTRAINT FK_323FC9CA1252C1E9 FOREIGN KEY (parent_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE shop_order_line ADD CONSTRAINT FK_E69663C7562797AE FOREIGN KEY (shop_order_id) REFERENCES shop_order (id)');
        $this->addSql('ALTER TABLE shop_order_line ADD CONSTRAINT FK_E69663C74C730D22 FOREIGN KEY (lineorder_id) REFERENCES line_item (id)');
        $this->addSql('ALTER TABLE line_item ADD CONSTRAINT FK_9456D6C74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_9456D6C74584665A ON line_item (product_id)');
        $this->addSql('ALTER TABLE product ADD shop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4D16C4DD ON product (shop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4D16C4DD');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA23B5A08D7');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2F2C56620');
        $this->addSql('ALTER TABLE shop_order DROP FOREIGN KEY FK_323FC9CA4D16C4DD');
        $this->addSql('ALTER TABLE shop_order DROP FOREIGN KEY FK_323FC9CA1252C1E9');
        $this->addSql('ALTER TABLE shop_order_line DROP FOREIGN KEY FK_E69663C7562797AE');
        $this->addSql('ALTER TABLE shop_order_line DROP FOREIGN KEY FK_E69663C74C730D22');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_order');
        $this->addSql('DROP TABLE shop_order_line');
        $this->addSql('DROP TABLE speciality_shop');
        $this->addSql('ALTER TABLE line_item DROP FOREIGN KEY FK_9456D6C74584665A');
        $this->addSql('DROP INDEX IDX_9456D6C74584665A ON line_item');
        $this->addSql('DROP INDEX IDX_D34A04AD4D16C4DD ON product');
        $this->addSql('ALTER TABLE product DROP shop_id');
    }
}
