<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Header</title>
    <link rel="stylesheet" href="../../stylesheet/Header.css">
</head>
<?php
// Define la URL base
$baseURL = "http://localhost/GAME_ROAD_MAP/";
?>
<body>
<header>
    <nav class="navbar">
        <!-- Logo -->
        <a href="index.php" class="logo">Roadmap</a>

        <!-- Navigation Links -->
        <ul class="nav-links">
            <li><a href="<?php echo $baseURL; ?>index.php">Inicio</a></li>
            <li><a href="<?php echo $baseURL; ?>nosotros.php">Nosotros</a></li>
            <li><a href="<?php echo $baseURL; ?>acerca.php">Acerca de</a></li>
            <li><a href="<?php echo $baseURL; ?>productos.php">paquetes</a></li>
        </ul>

        <!-- Authentication Buttons -->
        <div class="auth-buttons">
            <a href="<?php echo $baseURL; ?>admin/usuario/login.php" class="btn">Login</a>
            <a href="<?php echo $baseURL; ?>admin/usuario/register.php" class="btn btn-primary">Register</a>
        </div>

    </nav>
</header>
</body>
</html>
