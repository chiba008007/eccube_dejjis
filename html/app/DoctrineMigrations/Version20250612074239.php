<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250612074239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create amazon_order_confirmation_items table for PunchOut SetupRequest management';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE amazon_order_confirmation_items (
                id INT AUTO_INCREMENT NOT NULL COMMENT 'ID',
                confirmation_request_id INT NOT NULL COMMENT 'ConfirmationRequest外部キー',
                line_number INT NOT NULL COMMENT '商品行番号',
                quantity INT NOT NULL COMMENT '数量',
                unit_of_measure VARCHAR(32) NOT NULL COMMENT '単位',
                tax NUMERIC(12, 2) DEFAULT NULL COMMENT '税額',
                tax_rate NUMERIC(5, 2) DEFAULT NULL COMMENT '税率',
                shipping NUMERIC(12, 2) DEFAULT NULL COMMENT '配送料',
                description VARCHAR(255) DEFAULT NULL COMMENT '説明文（税/配送料）',
                comments VARCHAR(255) DEFAULT NULL COMMENT 'コメント（confirmID等）',
                created_at DATETIME NOT NULL COMMENT '登録日時',
                updated_at DATETIME NOT NULL COMMENT '更新日時',
                INDEX IDX_CONFIRMATION_REQUEST (confirmation_request_id),
                PRIMARY KEY(id),
                CONSTRAINT FK_CONFIRMATION_REQUEST FOREIGN KEY (confirmation_request_id) REFERENCES amazon_order_confirmations (id) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT='Amazon ConfirmationRequest 明細情報';
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE amazon_order_confirmation_items");
    }
}
