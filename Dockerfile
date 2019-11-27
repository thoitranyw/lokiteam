FROM php:7.2-fpm-stretch
WORKDIR /app
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apt-get purge -y libpq-dev && apt-get autoclean

COPY . .

RUN chmod -R 777 /app/storage