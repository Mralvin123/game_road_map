<?php
    include "../../includes/template/Header.php";

    include "../../includes/config/database.php";
    $db = conectarDB();

    // Validar si el parámetro 'id' está definido
    if (!isset($_GET['id'])) {
        die("Error: El parámetro 'id' no está definido.");
    }

    // Escapar el valor de 'id' para evitar inyecciones SQL
    $idPaso = mysqli_real_escape_string($db, $_GET['id']);

    // Consulta para actualizar el estado del paso
    $consql = "UPDATE paso SET estado='Inactivo' WHERE id = '$idPaso'";
    $res = mysqli_query($db, $consql);

    // Mostrar mensaje de éxito o error
    if ($res) {
        echo "<script>
                alert('El paso fue actualizado a \"Inactivo\" correctamente.');
                window.location.href = 'listarpasos.php'; // Redirige a la lista de pasos
              </script>";
    } else {
        echo "<script>
                alert('No se pudo actualizar el paso.');
                window.history.back(); // Regresa a la página anterior
              </script>";
    }

    include "../../includes/template/footer.php";
?>
