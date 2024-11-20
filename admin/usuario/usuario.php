<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../admin/usuario/login.php"); // Redirigir al login si no está autenticado
    exit; // Detener la ejecución
}

?>