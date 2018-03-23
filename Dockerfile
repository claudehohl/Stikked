FROM php:7.1-apache

EXPOSE 80

# Note that 'vim' and 'mysql-client' are changed to an echo,
# as they're only useful when debugging, and leaving them in
# the standard container only increases its size.
RUN apt-get -y update && \
	apt-get -y install libpng-dev zlib1g-dev cron && \
	echo apt-get -y install vim mysql-client && \
	a2enmod rewrite && \
	docker-php-ext-install mysqli gd && \
	rm -rf /var/lib/apt/lists/*

COPY htdocs /var/www/html
COPY htdocs/application/config/stikked.php.dist /var/www/html/application/config/stikked.php

# This overwrites the entrypoint from the php container with ours, which updates the
# stikked config file based on environment variables
COPY docker/docker-php-entrypoint /usr/local/bin/

RUN chmod +x /usr/local/bin/docker-php-entrypoint

