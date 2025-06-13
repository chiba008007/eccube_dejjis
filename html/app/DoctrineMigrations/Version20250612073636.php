<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250612073636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create amazon_order_confirmations table for PunchOut SetupRequest management';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE amazon_order_confirmations (
                id INT AUTO_INCREMENT NOT NULL COMMENT 'ID',
                confirm_id VARCHAR(255) NOT NULL COMMENT 'Amazon確認ID',
                order_id VARCHAR(255) DEFAULT NULL COMMENT 'Amazon注文ID（オプション）',
                notice_date DATETIME NOT NULL COMMENT '通知日時',
                total_amount NUMERIC(12, 2) NOT NULL COMMENT '合計金額（税込）',
                total_tax NUMERIC(12, 2) NOT NULL COMMENT '税額',
                total_shipping NUMERIC(12, 2) NOT NULL COMMENT '送料',
                received_at DATETIME NOT NULL COMMENT '電文受信日時',
                raw_cxml LONGTEXT NOT NULL COMMENT '受信したcXML電文の生データ',
                created_at DATETIME NOT NULL COMMENT '登録日時',
                updated_at DATETIME NOT NULL COMMENT '更新日時',
                UNIQUE INDEX UNIQ_CONFIRM_ID (confirm_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT='Amazon ConfirmationRequest ヘッダ情報';
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE amazon_order_confirmations");
    }
}
