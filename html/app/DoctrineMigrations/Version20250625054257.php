<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250625054257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("ALTER TABLE dtb_member ADD auth_code VARCHAR(10) DEFAULT NULL");
        $this->addSql("ALTER TABLE dtb_member ADD auth_code_expires_at DATETIME DEFAULT NULL");
        $this->addSql("ALTER TABLE dtb_member ADD auth_code_try_count INT DEFAULT 0");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //     $this->addSql('ALTER TABLE dtb_cart CHANGE total_price total_price NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL');
    }
}
