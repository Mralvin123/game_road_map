<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Escapar el valor de 'id' para evitar inyecciones SQL
$idNivel = mysqli_real_escape_string($db, $_GET['id']);

// Consulta para actualizar el estado del nivel de suscripción
$query = "UPDATE nivel_de_subscripcion SET estado='inactivo' WHERE id = '$idNivel'";
$resultado = mysqli_query($db, $query);

// Mostrar mensaje de éxito o error
if ($resultado) {
    echo "<script>
            alert('El nivel de suscripción fue actualizado a \"Inactivo\" correctamente.');
            window.location.href = 'listarsuscripciones.php'; // Redirige a la lista de suscripciones
          </script>";
} else {
    echo "<script>
            alert('No se pudo actualizar el nivel de suscripción.');
            window.history.back(); // Regresa a la página anterior
          </script>";
}
?>
