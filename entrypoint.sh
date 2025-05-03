#!/bin/bash
set -e

# MySQL のヘルスチェックが成功するまで待機
until mysqladmin ping -h db -u root -p"${MYSQL_ROOT_PASSWORD:-root}"; do
  echo "Waiting for MySQL to be healthy..."
  sleep 5
done

echo "MySQL is healthy. Starting EC-CUBE installation..."
cd /var/www/html
php bin/console eccube:install --env=dev -i # 対話型インストールを強制
php bin/console cache:clear --no-warmup --env=dev
php bin/console cache:warmup --env=dev

# Apache をフォアグラウンドで起動
exec apache2-foreground