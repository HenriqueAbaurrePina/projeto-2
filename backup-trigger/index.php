<?php
header("Content-Type: text/plain");

// === MySQL Backup Job ===
$originalBackup = "/app/mysql-backup-job.yml";
$tempBackup = "/tmp/mysql-backup-job-" . time() . ".yml";

if (!file_exists($originalBackup)) {
    http_response_code(500);
    echo "❌ Arquivo de Job do MySQL não encontrado: $originalBackup\n";
    exit;
}

$jobYaml = file_get_contents($originalBackup);
$uniqueName = "mysql-backup-job-" . time();
$jobYaml = preg_replace('/name: mysql-backup-job/', "name: $uniqueName", $jobYaml);
file_put_contents($tempBackup, $jobYaml);

echo "🔁 Disparando Job de Backup do MySQL...\n";
$output = shell_exec("kubectl apply -f $tempBackup 2>&1");
echo "📄 Resultado do backup:\n$output\n";

echo "✅ Job de backup finalizado.\n";
?>
