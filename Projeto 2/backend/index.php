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
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $stmt->execute([$data['nome'], $data['email']]);
    echo json_encode(['status' => 'success']);
} else {
    // Segurança: retornar erro para métodos desconhecidos
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}
?>
