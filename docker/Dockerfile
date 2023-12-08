FROM php:apache

RUN docker-php-ext-install mysqli

RUN pecl install -o -f xdebug \
    && docker-php-ext-enable xdebug

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]