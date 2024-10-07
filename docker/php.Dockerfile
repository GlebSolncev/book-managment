FROM php:8.3-fpm-alpine

WORKDIR /var/www/book
COPY . /var/www/book

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PCOV
RUN echo "pcov.enabled=0" > /usr/local/etc/php/conf.d/pcov.ini \
    && echo "pcov.directory=/var/www/book" >> /usr/local/etc/php/conf.d/pcov.ini

EXPOSE 9000
CMD ["php-fpm"]
