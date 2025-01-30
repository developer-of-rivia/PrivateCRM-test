FROM php:8.3-fpm

RUN apt-get update && apt-get install libpq-dev -y
RUN docker-php-ext-install pdo pdo_pgsql