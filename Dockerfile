FROM php:7.2-fpm
WORKDIR /app
RUN apt-get update && apt-get install -y libpq-dev git curl locales libzip-dev zip

RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

RUN apt-get purge -y libpq-dev && apt-get autoclean

RUN pecl install -o -f redis \
	&&  rm -rf /tmp/pear \
	&&  echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . .
RUN chmod -R 777 /app/storage
RUN composer install
