<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611023644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create amazon_order_requests table for PunchOut SetupRequest management';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE amazon_order_requests (
                id INT AUTO_INCREMENT PRIMARY KEY COMMENT '主キー',
                payload_id VARCHAR(255) COMMENT 'cXMLルートのpayloadID',
                order_id VARCHAR(255) COMMENT 'OrderRequestHeaderのorderID',
                buyer_id VARCHAR(255) COMMENT '発注者（From/Credential/Identity）',
                total_amount DECIMAL(15,2) COMMENT '注文合計金額（OrderRequestHeader/Total/Money）',
                currency VARCHAR(8) COMMENT '注文通貨（OrderRequestHeader/Total/Money/currency）',
                status VARCHAR(32) DEFAULT 'new' COMMENT '処理状況（new/processed/error等）',
                raw_cxml LONGTEXT NOT NULL COMMENT '受信した生cXML電文',
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'レコード作成日時',
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'レコード更新日時'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Amazon Business OrderRequest受信履歴';
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE amazon_order_requests");
    }
}
