#!/bin/sh

echo "⏳ Aguardando API do Kubernetes..."
until kubectl get jobs > /dev/null 2>&1; do
    sleep 3
done

echo "📤 Disparando Job do Kibana Index Pattern..."
cp /app/kibana-indexpattern-job.yml /tmp/kibana-indexpattern-job.yml
sed -i "s/name: create-kibana-indexpattern/name: kibana-indexpattern-job-$(date +%s)/" /tmp/kibana-indexpattern-job.yml
kubectl apply -f /tmp/kibana-indexpattern-job.yml || true

echo "✅ Job do Index Pattern disparado. Iniciando servidor PHP..."
cd /var/www/html
exec php -S 0.0.0.0:80
