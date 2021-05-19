FROM php:7.4-fpm

RUN apt-get update && apt-get install -y git zip unzip libzip-dev
RUN docker-php-ext-install zip pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /var/www/project
