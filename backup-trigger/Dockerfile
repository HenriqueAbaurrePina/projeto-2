FROM php:8.1-cli

# Instala curl, unzip
RUN apt-get update && apt-get install -y curl unzip

# Baixa e instala o kubectl (versão estável atual: v1.29.2)
RUN curl -LO https://dl.k8s.io/release/v1.29.2/bin/linux/amd64/kubectl && \
    install -o root -g root -m 0755 kubectl /usr/local/bin/kubectl && \
    rm kubectl

# Cria diretório da aplicação
WORKDIR /var/www/html

# Copia o script PHP principal
COPY index.php .

# Expõe a porta do servidor embutido
EXPOSE 80

# Comando para iniciar o microserviço
CMD ["php", "-S", "0.0.0.0:80"]
