<?php
header("Content-Type: text/plain");

// Verifica se o arquivo existe
$jobFile = "/backup/mysql-backup-job.yml";

if (!file_exists($jobFile)) {
    http_response_code(500);
    echo "Arquivo de Job não encontrado: $jobFile\n";
    exit;
}

// Aplica o job
$output = shell_exec("kubectl apply -f $jobFile 2>&1");

echo "Resultado do backup:\n";
echo $output;
?>
