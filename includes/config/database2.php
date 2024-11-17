<?php
$server = 'localhost';
$username = 'root';
$password = ''; // Variable correcta
$database = 'game_road';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password); // Usar $password, no $Password
    // Establece el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Conexión fallida: ' . $e->getMessage());
}
?>

