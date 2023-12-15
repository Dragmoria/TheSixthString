FROM php:apache

RUN docker-php-ext-install mysqli

# Enable the necessary Apache modules
RUN a2enmod rewrite
RUN a2enmod autoindex

COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable the site
RUN a2ensite 000-default

COPY ./src /var/www/html

WORKDIR /var/www

# Create the public directory
RUN mkdir -p /var/www/html/public

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]