<?php
require __DIR__ . '/../shared/monolog.php';

$logger = getLogger();
$logger->info("Página listar.php acessada");

echo "<h2>Lista de Usuários</h2>";

$ch = curl_init('http://backend/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// Verifica erro de conexão com backend
if (curl_errno($ch)) {
    echo "<p style='color:red;'>❌ Erro ao acessar a API: " . curl_error($ch) . "</p>";
    curl_close($ch);
    exit;
}

curl_close($ch);

// Decodifica a resposta JSON
$data = json_decode($response, true);

// Verifica se o JSON está válido
if (!is_array($data)) {
    echo "<p style='color:red;'>⚠️ Erro ao decodificar a resposta da API.</p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>"; // Mostra o que foi retornado
    exit;
}

// Mostra os usuários
if (count($data) === 0) {
    echo "<p>Nenhum usuário encontrado.</p>";
} else {
    echo "<ul>";
    foreach ($data as $usuario) {
        echo "<li><strong>" . htmlspecialchars($usuario['nome']) . "</strong> - " . htmlspecialchars($usuario['email']) . "</li>";
    }
    echo "</ul>";
}
?>