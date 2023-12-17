FROM php:apache

RUN docker-php-ext-install mysqli

RUN pecl install -o -f xdebug \
    && docker-php-ext-enable xdebug

# Copy the source code first
COPY ./src /var/www/html

# Then copy the Apache configuration file
COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Then copy the PHP configuration file
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY ./docker/entrypoint.sh /entrypoint.sh

WORKDIR /var/www

RUN a2enmod rewrite

RUN chown -R www-data:www-data /var/www

# Make the entrypoint script executable
RUN chmod +x /entrypoint.sh

# Run the entrypoint script when the container starts
CMD ["/entrypoint.sh"]