FROM php:8.1-apache

# Copia os arquivos do frontend
COPY . /var/www/html/

# Copia a biblioteca compartilhada já buildada
COPY --from=henriquepina/php-shared:v1.9 /shared /var/www/html/shared/

RUN a2enmod rewrite
EXPOSE 80
