FROM php:8.0.3-fpm

RUN apt-get update && apt-get install -y \
    wget \
    libzip-dev \
    unzip

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet && \
    mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install -j$(nproc) iconv pdo_mysql

# Instalação e configuração do XDebug
RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9090" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && docker-php-ext-enable xdebug

COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install