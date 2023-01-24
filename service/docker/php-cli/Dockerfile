FROM php:8.1-cli-alpine3.17

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk --no-cache add bash && install-php-extensions pdo_pgsql gmp amqp @composer

WORKDIR /app
