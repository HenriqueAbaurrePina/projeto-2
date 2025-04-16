FROM php:8.1-cli

# Instala curl, unzip
RUN apt-get update && apt-get install -y curl unzip

# Instala kubectl (versão estável)
RUN curl -LO https://dl.k8s.io/release/v1.29.2/bin/linux/amd64/kubectl && \
    install -o root -g root -m 0755 kubectl /usr/local/bin/kubectl && \
    rm kubectl

# Cria diretório da aplicação
WORKDIR /var/www/html

# Copia arquivos da aplicação e os YAMLs
COPY index.php .
COPY mysql-backup-job.yml /app/mysql-backup-job.yml
COPY kibana-indexpattern-job.yml /app/kibana-indexpattern-job.yml

EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80"]
