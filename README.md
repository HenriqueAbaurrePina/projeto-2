
# Projeto 2 — Deploy Local (Docker) e Kubernetes (AKS)

Este projeto permite o cadastro de usuários com persistência em banco de dados MySQL e backups automáticos. Ele pode ser executado localmente via Docker ou em um cluster Kubernetes (AKS).

---

## 🐳 Instalação e Deploy Local (Docker)

### Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### Passos para rodar localmente

1. Clone o repositório:
```bash
git clone <url-do-repositorio>
cd Projeto2
```

2. Suba os serviços:
```bash
docker-compose up --build
```

3. Acesse os serviços:
- Frontend: [http://localhost:8080](http://localhost:8080)
- Backend (API): [http://localhost:8081](http://localhost:8081)
- Backup Trigger: [http://localhost:8082](http://localhost:8082)

---

## ☁️ Deploy em Kubernetes (AKS)

### Pré-requisitos

- Cluster AKS criado
- `kubectl` configurado com contexto do AKS
- Azure CLI instalado e autenticado

### Passos para o deploy

1. Clone o projeto e entre na pasta:
```bash
git clone <url-do-repositorio>
cd Projeto2
```

2. Execute o script de deploy:
```bash
chmod +x iniciar-cluster.sh
./iniciar-cluster.sh
```

Este script aplica automaticamente todos os manifests Kubernetes na ordem correta.

### Ordem de componentes (aplicado pelo script):

- PVC para backup: `mysql-backup-pvc.yml`
- ConfigMap com dump inicial: `usuarios-dump-configmap.yml`
- Serviço MySQL: `mysql-service.yml`
- Init job do banco: `mysql-init-job.yml`
- Deploy do banco com restauração: `mysql-deployment-restore.yml`
- Backend e service: `backend-deployment.yml`, `backend-service.yml`
- Frontend e service: `frontend-deployment.yml`, `frontend-service.yml`
- Deploy e service do backup-trigger: `backup-trigger-deployment.yml`, `backup-trigger-service.yml`
- Permissões (RBAC): `backup-trigger-rbac.yml`
- Pod de debug para inspeção do backup: `debug-pod-backup.yml`

---

## 🔁 Backup e Restauração

- A cada novo cadastro, o backend chama o microserviço `backup-trigger`, que aplica um Job Kubernetes para gerar um novo `usuarios_dump.sql`.
- O arquivo é armazenado em um PVC compartilhado.
- Na reinicialização do banco, um `initContainer` detecta a ausência da tabela e restaura a partir do dump.

---

## 🧪 Verificação pós-deploy

Para verificar se tudo está funcionando:

```bash
kubectl get pods
kubectl get svc
kubectl exec -it deploy/mysql -- mysql -uroot -e "USE usuarios_db; SELECT * FROM usuarios;"
kubectl exec -it debug-backup -- cat /backup/usuarios_dump.sql | grep INSERT
```

---

## ✅ Pronto!

Seu ambiente está pronto tanto localmente quanto na nuvem com AKS. Basta acessar o frontend, cadastrar usuários e verificar os backups sendo feitos.

