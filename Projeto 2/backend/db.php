<?php
$pdo = new PDO("mysql:host=mysql;dbname=usuarios_db", "root", "root");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>