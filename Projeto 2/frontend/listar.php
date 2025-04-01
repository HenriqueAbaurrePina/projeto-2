<?php
$ch = curl_init('http://backend/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Erro ao acessar API: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

if (!is_array($data)) {
    echo "Erro ao decodificar JSON.";
    exit;
}

foreach ($data as $usuario) {
    echo "{$usuario['nome']} - {$usuario['email']}<br>";
}
?>
