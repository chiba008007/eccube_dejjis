<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613071855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
        CREATE TABLE amazon_ship_notice_items (
            id INT AUTO_INCREMENT NOT NULL COMMENT 'ID',
            ship_notice_id INT NOT NULL COMMENT 'amazon_ship_notices.id',
            line_number INT NOT NULL COMMENT '明細行番号',
            quantity INT NOT NULL COMMENT '数量',
            unit_of_measure VARCHAR(32) DEFAULT NULL COMMENT '単位（例：EA）',
            created_at DATETIME NOT NULL COMMENT '登録日時',
            updated_at DATETIME NOT NULL COMMENT '更新日時',
            PRIMARY KEY(id),
            INDEX IDX_SHIP_NOTICE_ID (ship_notice_id),
            CONSTRAINT FK_SHIP_NOTICE_ID FOREIGN KEY (ship_notice_id)
                REFERENCES amazon_ship_notices (id) ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT='配送通知明細（ShipNoticeItem）';
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP TABLE amazon_ship_notice_items");
    }
}
