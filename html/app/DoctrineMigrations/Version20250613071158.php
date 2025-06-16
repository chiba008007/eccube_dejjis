<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613071158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create amazon_ship_notices table for PunchOut SetupRequest management';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE amazon_ship_notices (
                id INT AUTO_INCREMENT NOT NULL COMMENT 'ID',
                shipment_id VARCHAR(64) NOT NULL COMMENT 'Amazon配送通知ID（shipmentID）',
                notice_date DATETIME NOT NULL COMMENT '通知日時',
                shipment_date DATETIME DEFAULT NULL COMMENT '出荷日',
                delivery_date DATETIME DEFAULT NULL COMMENT '納品予定日',
                shipment_type VARCHAR(32) DEFAULT NULL COMMENT '出荷タイプ（例：actual）',
                carrier_name VARCHAR(64) DEFAULT NULL COMMENT '配送会社名',
                tracking_number VARCHAR(64) DEFAULT NULL COMMENT '送り状番号（ShipmentIdentifier）',
                package_range_begin INT DEFAULT NULL COMMENT '荷物番号（開始）',
                package_range_end INT DEFAULT NULL COMMENT '荷物番号（終了）',
                order_id VARCHAR(64) NOT NULL COMMENT '注文ID（AmazonのorderID）',
                payload_id VARCHAR(255) DEFAULT NULL COMMENT 'payloadID（照合用）',
                raw_cxml LONGTEXT NOT NULL COMMENT '受信したcXML生データ',
                created_at DATETIME NOT NULL COMMENT '登録日時',
                updated_at DATETIME NOT NULL COMMENT '更新日時',
                PRIMARY KEY(id),
                UNIQUE INDEX UNIQ_SHIPMENT_ID (shipment_id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT='Amazon配送通知（ShipNoticeRequest）ヘッダ';
        ");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP TABLE amazon_ship_notices");

    }
}
