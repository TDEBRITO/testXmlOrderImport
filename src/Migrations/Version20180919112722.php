<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180919112722 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE exchange_rate (id INT AUTO_INCREMENT NOT NULL, currency_name VARCHAR(255) NOT NULL, currency_code VARCHAR(255) NOT NULL, exchange_currency VARCHAR(255) NOT NULL, exchange_value DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_order (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, date DATE NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_3B1CE6A338248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_order_product (customer_order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_4155DDE5A15A2E17 (customer_order_id), INDEX IDX_4155DDE54584665A (product_id), PRIMARY KEY(customer_order_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A338248176 FOREIGN KEY (currency_id) REFERENCES exchange_rate (id)');
        $this->addSql('ALTER TABLE customer_order_product ADD CONSTRAINT FK_4155DDE5A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_order_product ADD CONSTRAINT FK_4155DDE54584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_order DROP FOREIGN KEY FK_3B1CE6A338248176');
        $this->addSql('ALTER TABLE customer_order_product DROP FOREIGN KEY FK_4155DDE5A15A2E17');
        $this->addSql('ALTER TABLE customer_order_product DROP FOREIGN KEY FK_4155DDE54584665A');
        $this->addSql('DROP TABLE exchange_rate');
        $this->addSql('DROP TABLE customer_order');
        $this->addSql('DROP TABLE customer_order_product');
        $this->addSql('DROP TABLE product');
    }
}
