<?php
$ch = curl_init('http://backend:80/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
$response = curl_exec($ch);
curl_close($ch);
$data = json_decode($response,true);

foreach($data as $usuario){
    echo "{$usuario['nome']} - {$usuario['email']}<br>";
}
?>