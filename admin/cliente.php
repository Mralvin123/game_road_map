<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] === 'admin') {
    header('Location: /cine2/index.php');
    exit();
}
$inicio = false;
include '../includes/template/Header.php';
?>

<h1>Bienvenido, Cliente</h1>

<?php include '../includes/template/Footer.php'; ?>
