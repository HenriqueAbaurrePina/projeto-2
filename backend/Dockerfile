FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev && \
    docker-php-ext-install pdo pdo_mysql

# Copia os arquivos do backend
COPY . /var/www/html/

# Copia a biblioteca compartilhada já buildada
COPY --from=henriquepina/php-shared:v1.9 /shared /var/www/html/shared/

RUN a2enmod rewrite
EXPOSE 80
