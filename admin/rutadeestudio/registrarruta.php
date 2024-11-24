<?php
include "../../includes/template/header.php";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST y limpiarlas
    $titulo = isset($_POST['titulo']) ? htmlspecialchars(trim($_POST['titulo'])) : null;
    $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : null;
    $categoria = isset($_POST['categoria']) ? htmlspecialchars(trim($_POST['categoria'])) : null;
    $estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : null;

    // Validar que todos los campos requeridos están presentes
    if ($titulo && $descripcion && $categoria && $estado) {
        include "../../includes/config/database.php";
        $db = conectarDB();

        // Consulta preparada para evitar inyecciones SQL
        // Aquí la columna `idCategoria` de la tabla `ruta_de_estudio` está relacionada con la tabla `categoria`
        $query = "INSERT INTO ruta_de_estudio (titulo, descripcion, idCategoria, estado) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            // Vincular los valores al marcador de posición
            // Nota que 'idCategoria' es el campo que relaciona la tabla 'ruta_de_estudio' con la tabla 'categoria'
            mysqli_stmt_bind_param($stmt, "ssss", $titulo, $descripcion, $categoria, $estado);

            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Ruta de estudio registrada exitosamente.');
                        window.location.href = 'listarestudio.php'; // Redirige a la lista de rutas
                      </script>";
            } else {
                echo "<script>
                        alert('Error al registrar la ruta de estudio.');
                      </script>";
            }

            // Cerrar la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    alert('Error al preparar la consulta para registrar la ruta.');
                  </script>";
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($db);
    } else {
        echo "<script>
                alert('Por favor, complete todos los campos del formulario.');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
    <title>Registrar Ruta de Estudio</title>
</head>
<body>
    <h1>Registrar Ruta de Estudio</h1>
    <form method="POST" action="">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" rows="4" required></textarea><br>

        <label for="categoria">Categoría:</label>
        <select name="categoria" required>
            <?php
            // Conexión para cargar las categorías desde la base de datos
            include "../../includes/config/database.php";
            $db = conectarDB();

            // Consulta para obtener las categorías activas
            $query = "SELECT id, Titulo FROM categoria WHERE estado = 'activo'";
            $result = mysqli_query($db, $query);

            // Mostrar las opciones de categorías
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['Titulo'] . "</option>";
            }

            // Cerrar la conexión
            mysqli_close($db);
            ?>
        </select><br>

        <label for="estado">Estado:</label>
        <select name="estado" required>
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select><br>

        <input type="submit" value="Registrar Ruta">
    </form>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
