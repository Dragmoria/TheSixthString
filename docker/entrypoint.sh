echo "MYSQL_PASSWORD=$MYSQL_PASSWORD" > /var/www/html/.env
echo "MYSQL_DATABASE=$MYSQL_DATABASE" >> /var/www/html/.env
echo "MYSQL_USER=$MYSQL_USER" >> /var/www/html/.env
echo "MYSQL_SERVER=$MYSQL_SERVERNAME" >> /var/www/html/.env
echo "MYSQL_PORT=$MYSQL_PORT" >> /var/www/html/.env
echo "MAIL_PASSWORD_NOREPLY=$MAIL_PASSWORD_NOREPLY" >> /var/www/html/.env
echo "MAIL_PASSWORD_ADMIN=$MAIL_PASSWORD_ADMIN" >> /var/www/html/.env

exec apache2-foreground