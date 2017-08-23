FROM php:7.0-apache
COPY htdocs /var/www/html
COPY htdocs/application/config/stikked.php.dist /var/www/html/application/config/stikked.php
COPY replace-envvars.sh /bin/
COPY docker-php-entrypoint /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-php-entrypoint

EXPOSE 80
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli
