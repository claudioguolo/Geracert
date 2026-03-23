FROM php:8.1-cli-alpine

RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev freetype-dev libjpeg-turbo-dev libpng-dev; \
    apk add --no-cache icu-libs freetype libjpeg-turbo libpng; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install intl mysqli pdo_mysql gd; \
    apk del .build-deps
