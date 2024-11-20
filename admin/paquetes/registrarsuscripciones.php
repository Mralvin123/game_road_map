<?php
include "../../includes/template/header.php";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST
    $costo = isset($_POST['costo']) ? $_POST['costo'] : null;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;

    // Validar que todos los campos requeridos están presentes
    if ($costo !== null && $nombre && $estado) {
        include "../../includes/config/database.php";
        $db = conectarDB();

        $consql = "INSERT INTO nivel_de_subscripcion (costo, nombre, estado) 
                   VALUES ('$costo', '$nombre', '$estado')";
        $res = mysqli_query($db, $consql);

        if ($res) {
            echo "<script>
                    alert('Registro exitoso');
                    window.location.href = 'listarsuscripciones.php';
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
    <title>Registrar Nivel de Suscripción</title>
</head>
<body>
   <!-- Formulario HTML para agregar un nuevo nivel de suscripción -->
   <h1>Registrar Nivel de Suscripción</h1>
<form method="POST" action="">
    <label for="costo">Costo:</label>
    <input type="number" step="0.01" name="costo" required><br>

    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required><br>

    <label for="estado">Estado:</label>
    <input type="text" name="estado" required><br>

    <input type="submit" value="Registrar Nivel">
</form>
<?php include "../../includes/template/Footer.php"; ?> 
</body>
</html>
