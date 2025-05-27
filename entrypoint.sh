#!/bin/bash
set -e

# MySQL が起動して準備できるまで待つ
until mysqladmin ping -h db -u root -p"${MYSQL_ROOT_PASSWORD:-root}" --silent; do
  echo "Waiting for MySQL to be healthy..."
  sleep 5
done

echo "MySQL is healthy. Starting EC-CUBE installation..."

cd /var/www/html



# EC-CUBE 非対話インストール
php bin/console eccube:install \
  --env=dev \
  --no-interaction \
  --db-driver="pdo_mysql" \
  --db-host="db" \
  --db-port="3306" \
  --db-name="eccube" \
  --db-user="root" \
  --db-pass="root" \
  --admin-user="admin" \
  --admin-pass="password" \
  --admin-mail="admin@example.com" \
  --locale="ja" \
  --currency="JPY" \
  --country="JP" \
  --timezone="Asia/Tokyo"

composer dump-autoload

# プラグイン有効化（プラグインコードは実際の値に置き換えてください）
php bin/console eccube:plugin:install --code=ApiDebugPlugin || true
php bin/console eccube:plugin:enable --code=ApiDebugPlugin || true


# キャッシュのクリアとウォームアップ
php bin/console cache:clear --no-warmup --env=dev
php bin/console cache:warmup --env=dev

# Apache をフォアグラウンドで起動
exec apache2-foreground
