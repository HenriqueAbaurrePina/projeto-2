<?php
require __DIR__ . '/shared/monolog.php';
require 'db.php';

$logger = getLogger();
$logger->info("Página index.php acessada");

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM usuarios");
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $logger->info("Total de usuários retornados: " . count($usuarios));
        echo json_encode($usuarios);
    } catch (PDOException $e) {
        $logger->error("Erro ao listar usuários: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(["error" => "Erro interno ao listar usuários"]);
    }

} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['nome'], $data['email'])) {
        $logger->warning("Tentativa de cadastro inválido: " . json_encode($data));
        http_response_code(400);
        echo json_encode(['error' => 'Nome e email são obrigatórios']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        $stmt->execute([$data['nome'], $data['email']]);

        $logger->info("Usuário cadastrado: " . $data['nome']);

        // Disparar backup
        if (@file_get_contents('http://backup-trigger-service/backup') === false) {
            $logger->warning("Falha ao acionar o serviço de backup.");
        } else {
            $logger->info("Backup acionado com sucesso.");
        }

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        $logger->error("Erro ao cadastrar usuário: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'Erro interno ao cadastrar usuário']);
    }

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}
