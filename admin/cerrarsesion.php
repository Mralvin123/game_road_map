<?php
session_start();

// Destruir todas las variables de sesión
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location: http://localhost/GAME_ROAD_MAP/index.php");
exit();
?>
