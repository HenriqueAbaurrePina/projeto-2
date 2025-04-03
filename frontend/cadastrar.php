<?php
$data = ['nome' => $_POST['nome'], 'email' => $_POST['email']];
$ch = curl_init('http://backend:80');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,'true');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
header("Location: index.php");
?>