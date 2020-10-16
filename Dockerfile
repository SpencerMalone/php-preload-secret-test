FROM php:7.4-apache

RUN docker-php-ext-install opcache

COPY php.ini "/usr/local/etc/php/conf.d/test.ini"

COPY preload.php /preload.php

COPY index.php /var/www/html/index.php

RUN useradd -ms /bin/bash secretuser && chmod 700 /preload.php && chown secretuser /preload.php