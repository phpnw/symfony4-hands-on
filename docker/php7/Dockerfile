FROM php:7.2-fpm
RUN pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql mysqli opcache

RUN mkdir -p /var/www/sites/phpnw.dev

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && echo "log_errors = On" >> /usr/local/etc/php/php.ini \
    && echo "error_log = /dev/stderr" >> /usr/local/etc/php/php.ini

RUN echo "php_admin_value[error_log] = /dev/stderr" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

COPY docker/php7/php.ini /usr/local/etc/php/conf.d/php.ini
COPY docker/php7/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/sites/phpnw.dev
