<?php
require_once 'db.php';

$nome = $_POST['nome'];
$email = $_POST['email'];

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
$stmt->execute([$nome, $email]);

// Disparar backup via microserviço
file_get_contents('http://backup-trigger-service/backup');

header("Location: index.php");
exit;
?>
