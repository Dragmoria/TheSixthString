FROM php:apache

RUN docker-php-ext-install mysqli

COPY ./docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

COPY ./src /var/www/html

WORKDIR /var/www

# Create the public directory
RUN mkdir -p /var/www/html/public

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]