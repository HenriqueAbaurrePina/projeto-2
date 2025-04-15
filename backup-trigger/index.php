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

// === Kibana Index Pattern Job ===
$originalKibana = "/app/kibana-indexpattern-job.yml";
$tempKibana = "/tmp/kibana-indexpattern-job-" . time() . ".yml";

if (!file_exists($originalKibana)) {
    http_response_code(500);
    echo "❌ Arquivo de Job do Kibana não encontrado: $originalKibana\n";
    exit;
}

$kibanaYaml = file_get_contents($originalKibana);
$uniqueKibanaName = "kibana-indexpattern-job-" . time();
$kibanaYaml = preg_replace('/name: create-kibana-indexpattern/', "name: $uniqueKibanaName", $kibanaYaml);
file_put_contents($tempKibana, $kibanaYaml);

echo "🔁 Disparando Job de Criação do Index Pattern Kibana...\n";
$kibanaOutput = shell_exec("kubectl apply -f $tempKibana 2>&1");
echo "📄 Resultado do index pattern:\n$kibanaOutput\n";

echo "✅ Jobs disparados com sucesso.\n";
?>
