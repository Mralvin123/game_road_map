<?php
    include "../../includes/template/Header.php";

    include "../../includes/config/database.php";
    $db = conectarDB();

    // Validar si el parámetro 'cod' está definido
    if (!isset($_GET['cod'])) {
        die("Error: El parámetro 'cod' no está definido.");
    }

    // Escapar el valor de 'cod' para evitar inyecciones SQL
    $idv = mysqli_real_escape_string($db, $_GET['cod']);

    // Consulta para actualizar el estado
    $consql = "UPDATE usuario SET estado='Inactivo' WHERE id = '$idv'";
    $res=mysqli_query($db, $consql);
    // Mostrar mensaje de éxito o error
    if ($res) {
        echo "<script>
                alert('el usuario fue actualizado a \"Inactivo\" correctamente.');
                window.location.href = 'listarusuarios.php'; // Redirige a la lista de usuarios
              </script>";
    } else {
        echo "<script>
                alert('No se pudo eliminar el registro.');
                window.history.back(); // Regresa a la página anterior
              </script>";
    }

    include "../../includes/template/footer.php";
?>
