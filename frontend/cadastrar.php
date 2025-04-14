<?php

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';

if (empty($nome) || empty($email)) {
    echo "Nome e e-mail são obrigatórios.";
    exit;
}

// Envia os dados via POST para o backend
$data = json_encode([
    "nome" => $nome,
    "email" => $email
]);

$ch = curl_init('http://backend/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

// Disparar backup via microserviço
@file_get_contents('http://backup-trigger-service/backup');

// Redireciona de volta para index
header("Location: index.php");
exit;
?>