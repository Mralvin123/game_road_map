<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Escapar el valor de 'id' para evitar inyecciones SQL
$idRecurso = mysqli_real_escape_string($db, $_GET['id']);

// Consulta para actualizar el estado del recurso a "inactivo"
$query = "UPDATE recurso SET estado='inactivo' WHERE id = '$idRecurso'";
$resultado = mysqli_query($db, $query);

// Mostrar mensaje de éxito o error
if ($resultado) {
    echo "<script>
            alert('El recurso fue actualizado a \"Inactivo\" correctamente.');
            window.location.href = 'listarrecurso.php'; // Redirige a la lista de recursos
          </script>";
} else {
    echo "<script>
            alert('No se pudo actualizar el recurso.');
            window.history.back(); // Regresa a la página anterior
          </script>";
}
?>