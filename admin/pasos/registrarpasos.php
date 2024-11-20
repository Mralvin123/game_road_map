<?php
include "../../includes/template/header.php";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $id_ruta = isset($_POST['id_ruta']) ? $_POST['id_ruta'] : null;
    $id_paso_previo = isset($_POST['id_paso_previo']) ? $_POST['id_paso_previo'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;

    // Validar que todos los campos requeridos están presentes
    if ($titulo && $descripcion && $id_ruta && $estado) {
        include "../../includes/config/database.php";
        $db = conectarDB();

        $consql = "INSERT INTO paso (titulo, descripcion, id_Ruta, id_Paso_Previo, estado) 
                   VALUES ('$titulo', '$descripcion', '$id_ruta', ".($id_paso_previo ? "'$id_paso_previo'" : "NULL").", '$estado')";
        $res = mysqli_query($db, $consql);

        if ($res) {
            echo "<script>
                    alert('Registro exitoso');
                    window.location.href = 'listarpasos.php';
                  </script>";
        } else {
            echo "Error al registrar: " . mysqli_error($db);
        }
    } else {
        echo "Por favor, complete todos los campos obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
    <title>Registrar Paso</title>
</head>
<body>
   <!-- Formulario HTML para agregar un nuevo paso -->
   <h1>Registrar Paso</h1>
<form method="POST" action="">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" required><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required></textarea><br>

    <label for="id_ruta">ID Ruta:</label>
    <input type="number" name="id_ruta" required><br>

    <label for="id_paso_previo">ID Paso Previo (opcional):</label>
    <input type="number" name="id_paso_previo"><br>

    <label for="estado">Estado:</label>
    <input type="text" name="estado" required><br>

    <input type="submit" value="Registrar Paso">
</form>
<?php include "../../includes/template/Footer.php"; ?> 
</body>
</html>
