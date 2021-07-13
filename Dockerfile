FROM php:8.0-apache
RUN apt-get update
RUN apt-get install -y zip libzip-dev libpq-dev
RUN docker-php-ext-install zip opcache
RUN mkdir -p /usr/src/php/ext/redis
RUN curl -fsSL https://pecl.php.net/get/redis | tar xvz -C "/usr/src/php/ext/redis" --strip 1
RUN docker-php-ext-install redis pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite

COPY application /var/www/html
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/ports.conf /etc/apache2/ports.conf
WORKDIR /var/www/html
RUN composer install
CMD ["apache2-foreground"]