echo "MYSQL_PASSWORD=$MYSQL_PASSWORD" > /var/www/html/.env
echo "MYSQL_DATABASE=$MYSQL_DATABASE" >> /var/www/html/.env
echo "MYSQL_USER=$MYSQL_USER" >> /var/www/html/.env
echo "MYSQL_SERVERNAME=$MYSQL_SERVERNAME" >> /var/www/html/.env
echo "MYSQL_PORT=$MYSQL_INTERNAL_PORT" >> /var/www/html/.env
echo "MAIL_PASSWORD_NOREPLY=$MAIL_PASSWORD_NOREPLY" >> /var/www/html/.env
echo "MAIL_PASSWORD_ADMIN=$MAIL_PASSWORD_ADMIN" >> /var/www/html/.env
echo "MAIL_API_KEY=$MAIL_API_KEY" >> /var/www/html/.env
echo "MAIL_SERVER=$MAIL_SERVER" >> /var/www/html/.env
echo "MAIL_WITH_API=$MAIL_WITH_API" >> /var/www/html/.env
cat /var/www/html/.env
exec apache2-foreground