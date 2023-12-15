FROM php:apache

RUN pecl install -o -f xdebug \
    && docker-php-ext-enable xdebug

# Copy the source code first
COPY ./src /var/www/html

# Then copy the Apache configuration file
COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Then copy the PHP configuration file
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]