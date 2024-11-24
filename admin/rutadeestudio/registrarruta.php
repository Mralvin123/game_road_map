<?php
include "../../includes/template/header.php";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;

    // Validar que todos los campos requeridos están presentes
    if ($titulo && $descripcion && $categoria && $estado) {
        include "../../includes/config/database.php";
        $db = conectarDB();

        // Insertar los datos en la tabla `ruta_de_estudio` sin especificar el ID
        $consql = "INSERT INTO ruta_de_estudio (titulo, descripcion, categoria, estado) 
                   VALUES ('$titulo', '$descripcion', '$categoria', '$estado')";
        $res = mysqli_query($db, $consql);

        if ($res) {
            echo "<script>
                    alert('Ruta de estudio registrada exitosamente.');
                    window.location.href = 'listarestudio.php'; // Redirige a la lista de rutas
                  </script>";
        } else {
            echo "Error al registrar: " . mysqli_error($db);
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
    <title>Registrar Ruta de Estudio</title>
</head>
<body>
   <!-- Formulario HTML para agregar una nueva ruta de estudio -->
   <h1>Registrar Ruta de Estudio</h1>
   <form method="POST" action="">
       <label for="titulo">Título:</label>
       <input type="text" name="titulo" required><br>

       <label for="descripcion">Descripción:</label>
       <textarea name="descripcion" rows="4" required></textarea><br>

       <label for="categoria">Categoría:</label>
       <input type="text" name="categoria" required><br>

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
