<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514053932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dtb_cart CHANGE total_price total_price NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_cart_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_customer CHANGE buy_total buy_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\'');
        $this->addSql('ALTER TABLE dtb_order CHANGE subtotal subtotal NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE discount discount NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE tax tax NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE total total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE payment_total payment_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_order_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_payment CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0\'');
        $this->addSql('ALTER TABLE hello ADD comment VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dtb_cart CHANGE total_price total_price NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_cart_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_customer CHANGE buy_total buy_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\'');
        $this->addSql('ALTER TABLE dtb_order CHANGE subtotal subtotal NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE discount discount NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE tax tax NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE total total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE payment_total payment_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_order_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0.00\' NOT NULL');
        $this->addSql('ALTER TABLE dtb_payment CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\'');
        $this->addSql('ALTER TABLE hello DROP comment');
    }
}
