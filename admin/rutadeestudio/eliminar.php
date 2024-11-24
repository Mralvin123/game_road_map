<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Verificar si se recibe el parámetro cod en la URL
    if (isset($_GET['cod']) && is_numeric($_GET['cod'])) {
        $id = $_GET['cod'];

        // Consulta para actualizar el estado de la ruta a "Inactivo"
        $query = "UPDATE ruta_de_estudio SET estado = 'Inactivo' WHERE id = ?";

        // Preparar la sentencia SQL
        if ($stmt = mysqli_prepare($db, $query)) {
            // Vincular el parámetro al marcador
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Ejecutar la sentencia
            if (mysqli_stmt_execute($stmt)) {
                // Si la ejecución es exitosa, redirigir a la lista
                echo "<script>
                        alert('La ruta de estudio ha sido marcada como \"Inactivo\" correctamente.');
                        window.location.href = 'listarestudio.php';
                      </script>";
            } else {
                // Si hubo un error en la actualización
                echo "<script>
                        alert('Error al intentar marcar la ruta como inactiva.');
                        window.history.back();
                      </script>";
            }

            // Cerrar la sentencia
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    alert('Error al preparar la consulta para actualizar el estado.');
                    window.history.back();
                  </script>";
        }
    } else {
        // Si el parámetro cod no existe o no es válido
        echo "<script>
                alert('Parámetro inválido. No se puede procesar la solicitud.');
                window.history.back();
              </script>";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($db);
?>
