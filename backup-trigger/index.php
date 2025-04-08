<?php
header("Content-Type: text/plain");

$original = "/app/mysql-backup-job.yml";
$temp = "/tmp/mysql-backup-job-" . time() . ".yml";

if (!file_exists($original)) {
    http_response_code(500);
    echo "Arquivo de Job não encontrado: $original\n";
    exit;
}

// Gera cópia com nome único
$jobYaml = file_get_contents($original);
$uniqueName = "mysql-backup-job-" . time();
$jobYaml = preg_replace('/name: mysql-backup-job/', "name: $uniqueName", $jobYaml);
file_put_contents($temp, $jobYaml);

// Executa kubectl apply
$output = shell_exec("kubectl apply -f $temp 2>&1");

echo "Resultado do backup:\n";
echo $output;
?>
