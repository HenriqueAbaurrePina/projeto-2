FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libcurl4-openssl-dev libzip-dev libonig-dev \
    && docker-php-ext-install curl pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o código da aplicação
COPY . /var/www/html/

# Instalar dependências PHP do projeto
WORKDIR /var/www/html
RUN composer require monolog/monolog elasticsearch/elasticsearch:^7.17

# Habilitar mod_rewrite se necessário
RUN a2enmod rewrite

# Expor porta padrão do Apache
EXPOSE 80
