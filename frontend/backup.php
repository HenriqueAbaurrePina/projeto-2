<?php
// Dispara a Job de backup do banco
shell_exec("kubectl apply -f /var/www/html/mysql-backup-job.yml");
echo "Backup acionado!";
?>
