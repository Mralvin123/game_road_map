<?php
// Define la URL base
$baseURL = "http://localhost/GAME_ROAD_MAP/";

// Verifica si la sesión ya ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Iniciar la sesión si no está activa
}

// Asegúrate de que las variables de sesión estén definidas correctamente
$usuarioLogueado = isset($_SESSION['login']) && $_SESSION['login'] === true;
$esAdministrador = isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
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

        <!-- Enlaces de Navegación -->
        <ul class="nav-links">
            <li><a href="<?php echo $baseURL; ?>index.php">Inicio</a></li>
            <li><a href="<?php echo $baseURL; ?>contactanos.php">Contáctanos</a></li>
            <li><a href="<?php echo $baseURL; ?>acercade.php">Acerca de</a></li>
            <li><a href="<?php echo $baseURL; ?>productos.php">Paquetes</a></li>
        </ul>

        <!-- Botones de Autenticación -->
        <?php 
// Verificar si el usuario está logueado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) { ?>
    <div class="auth-buttons">
        <a href="<?php echo $baseURL; ?>admin/usuario/login.php" class="btn">Login</a>
        <a href="<?php echo $baseURL; ?>admin/usuario/register.php" class="btn btn-primary">Register</a>
    </div>
<?php 
} else {
    // Si el usuario está logueado
    ?>
    <div class="auth-buttons">
        <a href="<?php echo $baseURL; ?>admin/cerrarsesion.php" class="btn btn-inline">Cerrar Sesión</a>
    
    <?php 
    // Verificar si el usuario tiene el rol de Administrador
    if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'Administrador') { ?>
        
            <a href="<?php echo $baseURL; ?>admin/index.php" class="btn btn-inline">Administrador</a>
        </div>
    <?php 
    } 
} 
?>
        
    </nav>
</header>
</body>
</html>
