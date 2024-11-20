<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Verificar si se recibe el parámetro cod en la URL
    if (isset($_GET['cod']) && is_numeric($_GET['cod'])) {
        $id = $_GET['cod'];

        // Consulta para actualizar el estado de la ruta a "inactivo"
        $query = "UPDATE ruta_de_estudio SET estado = 'inactivo' WHERE id = ?";

        // Preparar la sentencia SQL
        if ($stmt = mysqli_prepare($db, $query)) {
            // Vincular el parámetro al marcador
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Ejecutar la sentencia
            if (mysqli_stmt_execute($stmt)) {
                // Si la ejecución es exitosa, redirigir a la lista
                echo "<script>
                        alert('Ruta de estudio fue actualizado a \"Inactivo\" correctamente.');
                        window.location.href = 'listarestudio.php';
                      </script>";
            } else {
                // Si hubo un error en la actualización
                echo "<script>
                        alert('Error al marcar la ruta como inactiva.');
                        window.history.back();
                      </script>";
            }

            // Cerrar la sentencia
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    alert('Error al preparar la consulta.');
                    window.history.back();
                  </script>";
        }
    } else {
        // Si el parámetro cod no existe o no es válido
        echo "<script>
                alert('Parámetro inválido.');
                window.history.back();
              </script>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($db);
?>