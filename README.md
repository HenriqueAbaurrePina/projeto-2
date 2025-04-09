
# Projeto 2 — Sistema de Cadastro com Backup Automático

Este projeto é uma aplicação web fullstack que permite cadastro de usuários com persistência em banco MySQL e backup automático via microserviço. Ele foi projetado para funcionar **tanto no Docker local quanto em clusters AKS (Azure Kubernetes Service)**.

---

## 🔧 Tecnologias Utilizadas

- **PHP** (backend e frontend)
- **MySQL 5.7**
- **Kubernetes + AKS**
- **Docker + Docker Compose**
- **kubectl + RBAC**
- **mysqldump** (para backup)
- **initContainer** (para restauração no AKS)

---

## 📦 Estrutura do Projeto

```
Projeto/
├── backend/              # API PHP com lógica de cadastro
├── frontend/             # Formulário e listagem HTML + PHP
├── backup-trigger/       # Microserviço que dispara o backup (kubectl)
├── bd/                   # Dump SQL original usado para inicialização
├── k8s/                  # Arquivos de configuração do Kubernetes
├── docker-compose.yml    # Orquestração para ambiente Docker
└── iniciar-cluster.sh    # Script completo para subir ambiente AKS
```

---

## 🚀 Como rodar localmente com Docker

### Pré-requisitos
- Docker
- Docker Compose

### Passos

```bash
docker-compose up --build
```

Acesse os serviços:
- Frontend: http://localhost:8080
- Backend (API): http://localhost:8081
- Backup Trigger: http://localhost:8082

---

## ☁️ Como rodar no Azure AKS

### Pré-requisitos
- AKS configurado
- `kubectl` conectado ao cluster
- Azure CLI

### Passos

```bash
chmod +x iniciar-cluster.sh
./iniciar-cluster.sh
```

Esse script aplica os arquivos do diretório `k8s/` na ordem correta, incluindo PVC, Service, Deployments, RBAC e ConfigMap.

---

## 💾 Backup e Restauração

- A cada novo cadastro, o backend chama o `backup-trigger` via HTTP.
- O `backup-trigger` cria um Job Kubernetes que executa o `mysqldump`.
- O dump (`usuarios_dump.sql`) é salvo em PVC compartilhado.

Na reinicialização do cluster/pod:
- Um `initContainer` detecta se já existe banco/tabela.
- Se não existir, restaura o dump automaticamente.

---

## ✅ Compatibilidade

| Ambiente | Suporte |
|----------|---------|
| Docker Desktop | ✅ Total |
| AKS (Azure)    | ✅ Total |

---

## ✨ Créditos

Projeto desenvolvido para fins educacionais, com foco em práticas modernas de DevOps, containers e Kubernetes.

