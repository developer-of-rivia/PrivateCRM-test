FROM php:8.3-cli-alpine

WORKDIR /var/www/party

RUN apk add libpq-dev && docker-php-ext-install pdo pdo_pgsql

CMD tail -f /dev/null

#ENTRYPOINT ["php", "artisan"]