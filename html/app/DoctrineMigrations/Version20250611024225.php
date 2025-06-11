<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611024225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create amazon_order_request_items table for PunchOut SetupRequest management';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE amazon_order_request_items (
                id INT AUTO_INCREMENT PRIMARY KEY COMMENT '主キー',
                request_id INT NOT NULL COMMENT '親OrderRequest（amazon_order_requests.id）',
                line_number INT COMMENT '明細行番号（ItemOut lineNumber）',
                supplier_part_id VARCHAR(255) COMMENT '商品ID（SupplierPartID）',
                supplier_part_auxiliary_id VARCHAR(255) COMMENT '商品補助ID（SupplierPartAuxiliaryID）',
                quantity INT COMMENT '数量（ItemOut quantity）',
                unit_price DECIMAL(15,2) COMMENT '単価（ItemDetail/UnitPrice/Money）',
                description TEXT COMMENT '商品説明（ItemDetail/Description）',
                manufacturer_part_id VARCHAR(255) COMMENT 'メーカー型番（ManufacturerPartID）',
                manufacturer_name VARCHAR(255) COMMENT 'メーカー名（ManufacturerName）',
                category VARCHAR(64) COMMENT 'カテゴリ（Extrinsic/category）',
                sub_category VARCHAR(64) COMMENT 'サブカテゴリ（Extrinsic/subCategory）',
                item_condition VARCHAR(32) COMMENT '商品状態（Extrinsic/itemCondition）',
                detail_page_url VARCHAR(512) COMMENT '商品詳細URL（Extrinsic/detailPageURL）',
                ean VARCHAR(64) COMMENT 'EANコード（Extrinsic/ean）',
                preference VARCHAR(32) COMMENT 'preference（Extrinsic/preference）',
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'レコード作成日時',
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'レコード更新日時',
                FOREIGN KEY (request_id) REFERENCES amazon_order_requests(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Amazon Business OrderRequest明細行';
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE amazon_order_request_items");
    }
}
