<?php

require_once 'db.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {

    $query = $pdo->query("SELECT * FROM usuarios");
    $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($usuarios);

} elseif ($method === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['nome'], $data['email'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Nome e email são obrigatórios']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $stmt->execute([$data['nome'], $data['email']]);

    // 🚀 Dispara o serviço de backup
    @file_get_contents('http://backup-trigger-service/backup');

    echo json_encode(['status' => 'success']);

} else {

    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);

}
