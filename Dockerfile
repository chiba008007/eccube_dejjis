FROM php:8.0.29-apache

# 必要なパッケージをインストール (PHP 拡張機能ビルドに必要なものを含む)
RUN apt-get update && apt-get install -y \
    $PHPIZE_DEPS \
    ca-certificates \
    curl \
    xz-utils \
    libzip-dev \
    libicu-dev \
    mariadb-client-10.5 \
    --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# PHP ZIP 拡張機能を有効にする
RUN docker-php-ext-install zip

# PHP intl 拡張機能を有効にする
RUN docker-php-ext-install intl

# PHP PDO および MySQL 拡張機能を有効にする
RUN docker-php-ext-install pdo pdo_mysql

# Composer をダウンロードしてインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# PATH 環境変数を設定 (念のため)
ENV PATH="$PATH:/usr/local/bin"

# Apache のドキュメントルートを設定 (既存の設定を上書き)
RUN sed -i 's!/var/www/html!/var/www/html!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/!/var/www/!g' /etc/apache2/apache2.conf

# Apache の rewrite モジュールを有効化 (EC-CUBE で必要)
RUN a2enmod rewrite

# PHP の設定をコピー (もし php.ini をホスト側で管理している場合)
COPY ./php.ini /usr/local/etc/php/php.ini

# PHP の設定ディレクトリを指定
ENV PHP_INI_SCAN_DIR /usr/local/etc/php/conf.d

# 作業ディレクトリを設定
WORKDIR /var/www/html

# html ディレクトリの中身を /var/www/html にコピー
COPY ./html/ . 

# Composer install を実行 (www-data ユーザーで)
RUN chown -R www-data:www-data /var/www/html
USER www-data
RUN composer install --no-dev --optimize-autoloader
USER root


COPY init.sql /docker-entrypoint-initdb.d/
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 80