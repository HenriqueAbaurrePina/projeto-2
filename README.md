
# Projeto 3 — Sistema de Cadastro com Backup Automático e Monitoramento

Este projeto implementa um sistema completo com frontend, backend em PHP, banco de dados MySQL, backups automáticos via microserviço e monitoramento com Elasticsearch e Kibana. Ele pode ser executado localmente com Docker ou em um cluster Kubernetes (AKS).

---

## 🐳 Deploy Local com Docker

### Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- Docker com suporte a build multi-stage (Docker 18.09+)

### Passos para rodar localmente

1. Clone o repositório e acesse o diretório:

```bash
git clone <url-do-repositorio>
cd Projeto3
```

2. Construa a imagem base com dependências compartilhadas:

```bash
docker build -t henriquepina/php-shared:v1.9 ./shared
```

3. Suba os serviços:

```bash
docker-compose up --build
```

4. Acesse os serviços:

- **Frontend**: [http://localhost:8080](http://localhost:8080)
- **Backend (API)**: [http://localhost:8081](http://localhost:8081)
- **Backup Trigger**: [http://localhost:8082](http://localhost:8082)
- **Elasticsearch**: [http://localhost:9200](http://localhost:9200)
- **Kibana**: [http://localhost:5601](http://localhost:5601)

---

## ☁️ Deploy em Kubernetes (AKS)

### Pré-requisitos

- Cluster AKS ativo
- `kubectl` configurado
- Azure CLI autenticado

### Passos para o deploy

1. Clone o projeto e acesse a pasta:

```bash
git clone <url-do-repositorio>
cd Projeto3
```

2. Execute o script:

```bash
chmod +x iniciar-cluster.sh
./iniciar-cluster.sh
```

O script aplica todos os manifests Kubernetes em ordem para garantir funcionamento completo.

### Componentes aplicados:

- PVCs: `mysql-backup-pvc.yml`, `elasticsearch-pvc.yml`, `kibana-pvc.yml`
- Serviços: `mysql-service.yml`, `backend-service.yml`, `frontend-service.yml`, `elasticsearch-service.yml`, `kibana-service.yml`, `backup-trigger-service.yml`
- Deployments: `mysql-deployment-restore.yml`, `backend-deployment.yml`, `frontend-deployment.yml`, `elasticsearch-deployment.yml`, `kibana-deployment.yml`, `backup-trigger-deployment.yml`
- Jobs: `mysql-init-job.yml`, `debug-pod-backup.yml`
- ConfigMap: `usuarios-dump-configmap.yml`
- RBAC: `backup-trigger-rbac.yml`

---

## 💾 Backup e Restauração

- Após cada cadastro, o backend envia uma requisição ao serviço `backup-trigger`, que executa um job de backup do MySQL.
- O dump gerado é armazenado em volume compartilhado (`/backup`).
- O banco, ao ser reiniciado, verifica a existência da tabela e aplica restauração automática com o dump mais recente.

---

## 🔎 Logs e Monitoramento

- **Monolog** é utilizado para enviar logs para o Elasticsearch.
- **Kibana** pode ser acessado via `http://localhost:5601` para visualizar e consultar logs.

---

## ✅ Verificação

Para garantir que tudo está funcionando:

```bash
# Docker
docker ps
docker exec -it backend bash
cat /var/www/html/shared/monolog.php

# Kubernetes (AKS)
kubectl get pods
kubectl get svc
kubectl logs deploy/backend
kubectl exec -it deploy/mysql -- mysql -uroot -e "USE usuarios_db; SELECT * FROM usuarios;"
```

---

## 📂 Estrutura do Projeto

```
Projeto3/
│
├── backend/                # API PHP (PDO + Monolog)
├── frontend/               # Interface de cadastro
├── shared/                 # Biblioteca compartilhada (monolog.php)
├── backup-trigger/         # Serviço HTTP que dispara backups
├── bd/init.sql             # Script SQL inicial para o banco
├── k8s/                    # Manifests do Kubernetes
├── docker-compose.yml      # Orquestração local
└── iniciar-cluster.sh      # Script de deploy em AKS
```

---

## ✨ Pronto!

Agora o sistema está configurado para funcionar tanto localmente (via Docker) quanto em produção (via AKS), com backup e monitoramento integrados.
