<?php

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'rsjnews';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>