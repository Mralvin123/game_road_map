<?php
// Define la URL base
$baseURL = "http://localhost/GAME_ROAD_MAP/";

// Verifica si la sesión ya ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión si no está activa
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Header</title>
    <link rel="stylesheet" href="../../stylesheet/Header.css">
</head>
<body>
<header>
    <nav class="navbar">
        <!-- Logo -->
        <a href="<?php echo $baseURL; ?>index.php" class="logo">GameRoadMap</a>

        <!-- Navigation Links -->
        <ul class="nav-links">
            <li><a href="<?php echo $baseURL; ?>index.php">Inicio</a></li>
            <li><a href="<?php echo $baseURL; ?>contactanos.php">Contáctanos</a></li>
            <li><a href="<?php echo $baseURL; ?>acercade.php">Acerca de</a></li>
            <li><a href="<?php echo $baseURL; ?>productos.php">Paquetes</a></li>
        </ul>

        <!-- Authentication Buttons -->
        <div class="auth-buttons">
            <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                <!-- Si el usuario está logueado -->
                <a href="<?php echo $baseURL; ?>admin/index.php" class="btn">Administrador</a>
                <a href="<?php echo $baseURL; ?>admin/cerrarsesion.php" class="btn btn-inline">Cerrar Sesión</a>
            <?php else: ?>
                <!-- Si el usuario no está logueado -->
                <a href="<?php echo $baseURL; ?>admin/usuario/login.php" class="btn">Login</a>
                <a href="<?php echo $baseURL; ?>admin/usuario/register.php" class="btn btn-primary">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
</body>
</html>
