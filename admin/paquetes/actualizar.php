<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Escapar el valor de 'id' para evitar inyecciones SQL
$idNivel = mysqli_real_escape_string($db, $_GET['id']);

// Consulta para obtener datos del nivel de suscripción
$query = "SELECT * FROM nivel_de_subscripcion WHERE id = '$idNivel'";
$resultado = mysqli_query($db, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: Nivel de suscripción no encontrado.");
}

$nivel = mysqli_fetch_assoc($resultado);

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $costo = mysqli_real_escape_string($db, $_POST['costo']);
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $estado = mysqli_real_escape_string($db, $_POST['estado']);

    // Consulta para actualizar el registro
    $query = "UPDATE nivel_de_subscripcion SET 
              costo = '$costo', 
              nombre = '$nombre', 
              estado = '$estado' 
              WHERE id = '$idNivel'";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "<script>
                alert('Nivel de suscripción actualizado correctamente.');
                window.location.href = 'listarsuscripciones.php'; // Redirigir a la lista de suscripciones
              </script>";
    } else {
        echo "<script>alert('Error al actualizar el nivel de suscripción.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Nivel de Suscripción</title>
</head>
<?php include "../../includes/template/header.php"; ?>
<body>
    <h1>Actualizar Nivel de Suscripción</h1>
    <form method="post" class="formulario">
        <label for="costo">Costo:</label>
        <input type="number" step="0.01" name="costo" id="costo" value="<?php echo $nivel['costo']; ?>" required>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $nivel['nombre']; ?>" required>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="activo" <?php echo $nivel['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?php echo $nivel['estado'] === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <input type="submit" value="Actualizar Nivel" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
