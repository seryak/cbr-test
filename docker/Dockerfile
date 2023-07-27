FROM php:8.0.3-fpm-buster

ENV ACCEPT_EULA=Y
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y zip unzip \
    && docker-php-ext-install -j$(nproc) bcmath \
    && apt-get clean && rm -rf /var/cache/apk/* && docker-php-source delete \
    && rm -rf /var/lib/apt

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer