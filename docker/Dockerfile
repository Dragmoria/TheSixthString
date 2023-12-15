FROM php:apache

RUN docker-php-ext-install mysqli

COPY ./src /var/www/html

WORKDIR /var/www

# Create the public directory
RUN mkdir -p /var/www/html/public

# Copy the Apache configuration file after creating the public directory
COPY ./docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN a2ensite 000-default

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]