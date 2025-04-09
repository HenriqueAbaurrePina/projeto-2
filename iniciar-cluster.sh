#!/bin/bash

echo "[1] Aplicando PVC do backup..."
kubectl apply -f k8s/mysql-backup-pvc.yml

echo "[2] Aplicando service do MySQL..."
kubectl apply -f k8s/mysql-service.yml

echo "[3] Aplicando ConfigMap do dump padrão..."
kubectl apply -f k8s/usuarios-dump-configmap.yml

echo "[4] Aplicando deployment do MySQL com restauração..."
kubectl apply -f k8s/mysql-deployment-restore.yml

echo "[5] Aplicando job de init (pode falhar, tudo certo)..."
kubectl apply -f k8s/mysql-init-job.yml

echo "[6] Aplicando backend + service..."
kubectl apply -f k8s/backend-deployment.yml
kubectl apply -f k8s/backend-service.yml

echo "[7] Aplicando frontend + service..."
kubectl apply -f k8s/frontend-deployment.yml
kubectl apply -f k8s/frontend-service.yml

echo "[8] Aplicando backup-trigger + service..."
kubectl apply -f k8s/backup-trigger-deployment.yml
kubectl apply -f k8s/backup-trigger-service.yml

echo "[9] Aplicando RBAC para permitir kubectl dentro do backup-trigger..."
kubectl apply -f k8s/backup-trigger-rbac.yml

echo "[10] (Opcional) Aplicando debug pod para inspecionar volume de backup..."
kubectl apply -f k8s/debug-pod-backup.yml

echo "[✔] Cluster iniciado com sucesso!"
