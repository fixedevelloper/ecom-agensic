<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221107125916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT DEFAULT NULL, visible TINYINT(1) NOT NULL, variation TINYINT(1) DEFAULT NULL, options JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, display VARCHAR(255) DEFAULT NULL, parent INT NOT NULL, menu_order INT DEFAULT NULL, count INT DEFAULT NULL, INDEX IDX_64C19C13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, billing_id INT DEFAULT NULL, shipping_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, is_paying_customer TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_81398E093B025C87 (billing_id), UNIQUE INDEX UNIQ_81398E094887F3F8 (shipping_id), UNIQUE INDEX UNIQ_81398E09F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_meta_data (customer_id INT NOT NULL, meta_data_id INT NOT NULL, INDEX IDX_95A8783A9395C3F3 (customer_id), INDEX IDX_95A8783A7E8EBEDE (meta_data_id), PRIMARY KEY(customer_id, meta_data_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, src VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_item (id INT AUTO_INCREMENT NOT NULL, order_line_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, product_id INT DEFAULT NULL, variation_id INT DEFAULT NULL, quantity INT NOT NULL, tax_class VARCHAR(255) DEFAULT NULL, subtotal DOUBLE PRECISION DEFAULT NULL, subtotal_tax DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, total_tax DOUBLE PRECISION DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9456D6C7BB01DC09 (order_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line_item_meta_data (line_item_id INT NOT NULL, meta_data_id INT NOT NULL, INDEX IDX_679A438A7CBD339 (line_item_id), INDEX IDX_679A4387E8EBEDE (meta_data_id), PRIMARY KEY(line_item_id, meta_data_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_data (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, billing_id INT DEFAULT NULL, shipping_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, order_key VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, discount_total DOUBLE PRECISION DEFAULT NULL, discount_tax DOUBLE PRECISION DEFAULT NULL, shipping_total DOUBLE PRECISION DEFAULT NULL, shipping_tax DOUBLE PRECISION DEFAULT NULL, cart_tax DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION NOT NULL, total_tax DOUBLE PRECISION NOT NULL, prices_include_tax TINYINT(1) DEFAULT NULL, customer_id INT NOT NULL, customer_ip_address VARCHAR(255) NOT NULL, customer_note VARCHAR(255) NOT NULL, payment_method VARCHAR(255) NOT NULL, payment_method_title VARCHAR(255) NOT NULL, date_paid DATETIME DEFAULT NULL, date_completed DATETIME DEFAULT NULL, cart_hash VARCHAR(255) DEFAULT NULL, fee_lines JSON DEFAULT NULL, coupon_lines JSON DEFAULT NULL, refunds JSON DEFAULT NULL, INDEX IDX_F52993983B025C87 (billing_id), INDEX IDX_F52993984887F3F8 (shipping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, featured TINYINT(1) DEFAULT NULL, catalog_visibility VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, tax_status VARCHAR(255) DEFAULT NULL, tax_class VARCHAR(255) DEFAULT NULL, shipping_required TINYINT(1) DEFAULT NULL, shipping_taxable TINYINT(1) DEFAULT NULL, on_sale TINYINT(1) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, regular_price DOUBLE PRECISION DEFAULT NULL, sale_price DOUBLE PRECISION DEFAULT NULL, total_sales INT NOT NULL, manage_stock TINYINT(1) NOT NULL, stock_quantity INT NOT NULL, in_stock TINYINT(1) NOT NULL, weight VARCHAR(255) DEFAULT NULL, average_rating VARCHAR(255) DEFAULT NULL, rating_count INT NOT NULL, parent_id INT NOT NULL, menu_order INT DEFAULT NULL, tags JSON DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (product_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (product_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_64617F034584665A (product_id), INDEX IDX_64617F033DA5256D (image_id), PRIMARY KEY(product_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribute (product_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_94DA59764584665A (product_id), INDEX IDX_94DA5976B6E62EFA (attribute_id), PRIMARY KEY(product_id, attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_meta_data (product_id INT NOT NULL, meta_data_id INT NOT NULL, INDEX IDX_50F536AD4584665A (product_id), INDEX IDX_50F536AD7E8EBEDE (meta_data_id), PRIMARY KEY(product_id, meta_data_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_line (id INT AUTO_INCREMENT NOT NULL, order_shipping_id INT DEFAULT NULL, method_title VARCHAR(255) DEFAULT NULL, method_id INT DEFAULT NULL, instance_id INT DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, total_tax DOUBLE PRECISION DEFAULT NULL, taxes JSON DEFAULT NULL, meta_data JSON DEFAULT NULL, INDEX IDX_40A822F453358C7E (order_shipping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, isactivate TINYINT(1) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variation (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, regular_price DOUBLE PRECISION NOT NULL, sale_price DOUBLE PRECISION NOT NULL, date_on_sale_from DATE DEFAULT NULL, date_on_sale_to DATE DEFAULT NULL, on_sale TINYINT(1) DEFAULT NULL, visible TINYINT(1) DEFAULT NULL, purchasable TINYINT(1) DEFAULT NULL, tax_status VARCHAR(255) NOT NULL, tax_class VARCHAR(255) NOT NULL, manage_stock TINYINT(1) DEFAULT NULL, stock_quantity INT NOT NULL, in_stock TINYINT(1) DEFAULT NULL, shipping_class VARCHAR(255) DEFAULT NULL, shipping_class_id INT DEFAULT NULL, length INT DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, INDEX IDX_629B33EA3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variation_attribute (variation_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_EE59DA225182BFD8 (variation_id), INDEX IDX_EE59DA22B6E62EFA (attribute_id), PRIMARY KEY(variation_id, attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variation_meta_data (variation_id INT NOT NULL, meta_data_id INT NOT NULL, INDEX IDX_2A76B5F95182BFD8 (variation_id), INDEX IDX_2A76B5F97E8EBEDE (meta_data_id), PRIMARY KEY(variation_id, meta_data_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E093B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E094887F3F8 FOREIGN KEY (shipping_id) REFERENCES shipping (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09F2C56620 FOREIGN KEY (compte_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE customer_meta_data ADD CONSTRAINT FK_95A8783A9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_meta_data ADD CONSTRAINT FK_95A8783A7E8EBEDE FOREIGN KEY (meta_data_id) REFERENCES meta_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_item ADD CONSTRAINT FK_9456D6C7BB01DC09 FOREIGN KEY (order_line_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE line_item_meta_data ADD CONSTRAINT FK_679A438A7CBD339 FOREIGN KEY (line_item_id) REFERENCES line_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE line_item_meta_data ADD CONSTRAINT FK_679A4387E8EBEDE FOREIGN KEY (meta_data_id) REFERENCES meta_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993983B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984887F3F8 FOREIGN KEY (shipping_id) REFERENCES shipping (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F033DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_meta_data ADD CONSTRAINT FK_50F536AD4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_meta_data ADD CONSTRAINT FK_50F536AD7E8EBEDE FOREIGN KEY (meta_data_id) REFERENCES meta_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shipping_line ADD CONSTRAINT FK_40A822F453358C7E FOREIGN KEY (order_shipping_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE variation ADD CONSTRAINT FK_629B33EA3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE variation_attribute ADD CONSTRAINT FK_EE59DA225182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variation_attribute ADD CONSTRAINT FK_EE59DA22B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variation_meta_data ADD CONSTRAINT FK_2A76B5F95182BFD8 FOREIGN KEY (variation_id) REFERENCES variation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variation_meta_data ADD CONSTRAINT FK_2A76B5F97E8EBEDE FOREIGN KEY (meta_data_id) REFERENCES meta_data (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C13DA5256D');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E093B025C87');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E094887F3F8');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09F2C56620');
        $this->addSql('ALTER TABLE customer_meta_data DROP FOREIGN KEY FK_95A8783A9395C3F3');
        $this->addSql('ALTER TABLE customer_meta_data DROP FOREIGN KEY FK_95A8783A7E8EBEDE');
        $this->addSql('ALTER TABLE line_item DROP FOREIGN KEY FK_9456D6C7BB01DC09');
        $this->addSql('ALTER TABLE line_item_meta_data DROP FOREIGN KEY FK_679A438A7CBD339');
        $this->addSql('ALTER TABLE line_item_meta_data DROP FOREIGN KEY FK_679A4387E8EBEDE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993983B025C87');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984887F3F8');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F033DA5256D');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA59764584665A');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA5976B6E62EFA');
        $this->addSql('ALTER TABLE product_meta_data DROP FOREIGN KEY FK_50F536AD4584665A');
        $this->addSql('ALTER TABLE product_meta_data DROP FOREIGN KEY FK_50F536AD7E8EBEDE');
        $this->addSql('ALTER TABLE shipping_line DROP FOREIGN KEY FK_40A822F453358C7E');
        $this->addSql('ALTER TABLE variation DROP FOREIGN KEY FK_629B33EA3DA5256D');
        $this->addSql('ALTER TABLE variation_attribute DROP FOREIGN KEY FK_EE59DA225182BFD8');
        $this->addSql('ALTER TABLE variation_attribute DROP FOREIGN KEY FK_EE59DA22B6E62EFA');
        $this->addSql('ALTER TABLE variation_meta_data DROP FOREIGN KEY FK_2A76B5F95182BFD8');
        $this->addSql('ALTER TABLE variation_meta_data DROP FOREIGN KEY FK_2A76B5F97E8EBEDE');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_meta_data');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE line_item');
        $this->addSql('DROP TABLE line_item_meta_data');
        $this->addSql('DROP TABLE meta_data');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('DROP TABLE product_meta_data');
        $this->addSql('DROP TABLE shipping');
        $this->addSql('DROP TABLE shipping_line');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE variation');
        $this->addSql('DROP TABLE variation_attribute');
        $this->addSql('DROP TABLE variation_meta_data');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
