<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605060009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create dtb_punchout_session table for PunchOut SetupRequest management';
    }

    public function up(Schema $schema): void
    {

        $this->addSql("
            CREATE TABLE dtb_punchout_session (
                id INT AUTO_INCREMENT NOT NULL,
                buyer_cookie VARCHAR(255) NOT NULL,
                request_xml LONGTEXT NOT NULL,
                user_email VARCHAR(255) DEFAULT NULL,
                user_first_name VARCHAR(255) DEFAULT NULL,
                user_last_name VARCHAR(255) DEFAULT NULL,
                start_date DATETIME DEFAULT NULL,
                country VARCHAR(32) DEFAULT NULL,
                business_unit VARCHAR(64) DEFAULT NULL,
                ship_to_json LONGTEXT DEFAULT NULL,
                expire_at DATETIME DEFAULT NULL,
                is_used TINYINT(1) DEFAULT 0,
                create_date DATETIME NOT NULL,
                update_date DATETIME NOT NULL,
                UNIQUE INDEX UNIQ_punchout_session_buyer_cookie (buyer_cookie),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ");

        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('DROP TABLE plg_api_debug_plugin_config');
        // $this->addSql('ALTER TABLE dtb_cart CHANGE total_price total_price NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_cart_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_customer CHANGE buy_total buy_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\'');
        // $this->addSql('ALTER TABLE dtb_order CHANGE subtotal subtotal NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE discount discount NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE tax tax NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE total total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE payment_total payment_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_order_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_payment CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE dtb_punchout_session");

        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE plg_api_debug_plugin_config (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_bin` ENGINE = InnoDB COMMENT = \'\' ');
        // $this->addSql('ALTER TABLE dtb_cart CHANGE total_price total_price NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_cart_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0.00\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_customer CHANGE buy_total buy_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\'');
        // $this->addSql('ALTER TABLE dtb_order CHANGE subtotal subtotal NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE discount discount NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE delivery_fee_total delivery_fee_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE tax tax NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE total total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL, CHANGE payment_total payment_total NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_order_item CHANGE price price NUMERIC(12, 2) DEFAULT \'0.00\' NOT NULL');
        // $this->addSql('ALTER TABLE dtb_payment CHANGE charge charge NUMERIC(12, 2) UNSIGNED DEFAULT \'0.00\'');
    }
}
