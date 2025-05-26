FROM php:8.0.29-apache

# 必要なパッケージをまとめてインストール
RUN apt-get update && apt-get install -y \
    $PHPIZE_DEPS \
    ca-certificates \
    curl \
    xz-utils \
    libzip-dev \
    libicu-dev \
    mariadb-client-10.5 \
    iputils-ping \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libmagickwand-dev \
    net-tools \
    lsof \
    unzip \
    --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# PHP拡張モジュールインストール
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd dom zip intl pdo pdo_mysql

# imagick & xdebug
RUN pecl install imagick xdebug \
    && docker-php-ext-enable imagick xdebug

# Xdebug 設定
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Composer インストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Apache の設定変更と rewrite モジュール有効化
RUN sed -i 's!/var/www/html!/var/www/html!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!/var/www/!/var/www/!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# PHP 設定ファイルのコピー
COPY ./php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリ & コード配置
WORKDIR /var/www/html
COPY ./html/ .

# 権限変更と Composer install
RUN chown -R www-data:www-data /var/www/html
USER www-data
RUN composer install || true  # 失敗しても進める開発用途ならこれもアリ
USER root

# DB 初期化 & エントリポイント
COPY init.sql /docker-entrypoint-initdb.d/
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 80
EXPOSE 9003
