FROM php:8.3-fpm

#actualiza dependencias de paquetes e instala las necesarias
RUN apt-get update && apt-get install -y \
        curl \
        zip \
        unzip \
        git \
        && docker-php-ext-install pdo_mysql

#copia Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#define directorio trabajo dentro del contenedor
WORKDIR /var/www
