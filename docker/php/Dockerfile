FROM php:7.1-fpm-alpine3.9

RUN apk add -U libjpeg-turbo-dev libpng-dev freetype-dev
RUN docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-freetype-dir=/usr/include/freetype2 \
        --with-png-dir=/usr/include \
        --with-jpeg-dir=/usr/include
RUN docker-php-ext-install gd mysqli
