<?php
require_once 'db.php';

header("Content Type: aplication/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $query = $pdo->query("SELECT * FROM usuarios");
    echo json_decode($query->fetch(PDO::FETCH_ASSOC));
}elseif ($method === 'POST') {
    $data = json_encode(file_get_contents("php://input"), true);
    $smtm = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $smtm->execute([$data['nome'], $data['email']]);
    echo json_encode(['status' => 'sucess']);
}
?>