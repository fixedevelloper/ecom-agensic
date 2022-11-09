<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108201625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, billing_id INT DEFAULT NULL, shipping_id INT DEFAULT NULL, payment_method VARCHAR(255) DEFAULT NULL, payment_method_title VARCHAR(255) DEFAULT NULL, customer_id INT DEFAULT NULL, set_paid TINYINT(1) DEFAULT NULL, INDEX IDX_BA388B73B025C87 (billing_id), INDEX IDX_BA388B74887F3F8 (shipping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B73B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B74887F3F8 FOREIGN KEY (shipping_id) REFERENCES shipping (id)');
        $this->addSql('ALTER TABLE line_item ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line_item ADD CONSTRAINT FK_9456D6C71AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_9456D6C71AD5CDBF ON line_item (cart_id)');
        $this->addSql('ALTER TABLE shipping_line ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE shipping_line ADD CONSTRAINT FK_40A822F41AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_40A822F41AD5CDBF ON shipping_line (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_item DROP FOREIGN KEY FK_9456D6C71AD5CDBF');
        $this->addSql('ALTER TABLE shipping_line DROP FOREIGN KEY FK_40A822F41AD5CDBF');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B73B025C87');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B74887F3F8');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP INDEX IDX_9456D6C71AD5CDBF ON line_item');
        $this->addSql('ALTER TABLE line_item DROP cart_id');
        $this->addSql('DROP INDEX IDX_40A822F41AD5CDBF ON shipping_line');
        $this->addSql('ALTER TABLE shipping_line DROP cart_id');
    }
}
