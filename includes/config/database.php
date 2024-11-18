<?php
function conectarDB() {
    $db = mysqli_connect('localhost', 'root', '', 'game_road');

    // Verificar si la conexión fue exitosa
    if (!$db) {
        echo "Error: No se pudo conectar a la base de datos.";
        exit;
    }

    return $db;
}
?>
