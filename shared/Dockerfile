# Etapa única: usa mesma imagem que será usada nos serviços finais
FROM php:8.1-cli AS shared-builder

# Instala dependências para Composer e pacotes PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    zip \
    libzip-dev \
 && docker-php-ext-install zip

# Instala Composer manualmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /shared

# Copia o arquivo com o logger
COPY monolog.php .

# Instala as dependências Monolog e Elasticsearch client
RUN composer require monolog/monolog elasticsearch/elasticsearch:^7.0
