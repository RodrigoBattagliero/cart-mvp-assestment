<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504204048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, amount INTEGER NOT NULL, product_id INTEGER NOT NULL, CONSTRAINT FK_BA388B74584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B74584665A ON cart (product_id)');
        $this->addSql('CREATE TABLE delivery_rules (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rule VARCHAR(255) NOT NULL, params CLOB DEFAULT NULL, value DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE offer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL, amount INTEGER NOT NULL, pay DOUBLE PRECISION NOT NULL, product_id INTEGER NOT NULL, CONSTRAINT FK_29D6873E4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E4584665A ON offer (product_id)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD77153098 ON product (code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE delivery_rules');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE product');
    }
}
