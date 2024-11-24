<?php
include "../../includes/template/Header.php";
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Escapar el valor de 'id' para evitar inyecciones SQL
$idCategoria = mysqli_real_escape_string($db, $_GET['id']);

// Consulta para actualizar el estado de la categoría
$query = "UPDATE categoria SET estado='Inactivo' WHERE id = '$idCategoria'";
$resultado = mysqli_query($db, $query);

// Mostrar mensaje de éxito o error
if ($resultado) {
    echo "<script>
            alert('La categoría fue actualizada a \"Inactivo\" correctamente.');
            window.location.href = 'listarcategorias.php'; // Redirige a la lista de categorías
          </script>";
} else {
    echo "<script>
            alert('No se pudo actualizar la categoría.');
            window.history.back(); // Regresa a la página anterior
          </script>";
}

include "../../includes/template/footer.php";
?>