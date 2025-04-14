# Etapa de build: instala dependências PHP via Composer
FROM composer:latest AS builder

WORKDIR /app
COPY monolog.php .

# Instala Monolog e Elasticsearch client
RUN composer require monolog/monolog elasticsearch/elasticsearch

# Etapa final: imagem PHP leve com os arquivos necessários
FROM php:8.2-cli AS shared-runtime

WORKDIR /shared
COPY --from=builder /app/vendor /shared/vendor
COPY --from=builder /app/monolog.php /shared/monolog.php
