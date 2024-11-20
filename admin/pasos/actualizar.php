<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'cod' está definido
if (!isset($_GET['cod'])) {
    die("Error: El parámetro 'cod' no está definido.");
}

// Escapar el valor del 'cod' para evitar inyecciones SQL
$idPaso = mysqli_real_escape_string($db, $_GET['cod']);

// Consulta para obtener datos del paso
$query = "SELECT * FROM paso WHERE id = '$idPaso'";
$resultado = mysqli_query($db, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: Paso no encontrado.");
}

$paso = mysqli_fetch_assoc($resultado);

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $idRuta = mysqli_real_escape_string($db, $_POST['id_Ruta']);
    $idPasoPrevio = mysqli_real_escape_string($db, $_POST['id_Paso_Previo']);
    $estado = mysqli_real_escape_string($db, $_POST['estado']);

    // Consulta para actualizar el registro
    $query = "UPDATE paso SET 
              titulo = '$titulo', 
              descripcion = '$descripcion', 
              id_Ruta = '$idRuta', 
              id_Paso_Previo = " . ($idPasoPrevio ? "'$idPasoPrevio'" : "NULL") . ", 
              estado = '$estado' 
              WHERE id = '$idPaso'";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "<script>
                alert('Paso actualizado correctamente.');
                window.location.href = 'listarpasos.php'; // Redirigir a la tabla de pasos
              </script>";
    } else {
        echo "<script>alert('Error al actualizar el paso.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Paso</title>
</head>
<?php include "../../includes/template/header.php"; ?>
<body>
    <h1>Actualizar Paso</h1>
    <form method="post" class="formulario">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo $paso['titulo']; ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?php echo $paso['descripcion']; ?></textarea>

        <label for="id_Ruta">ID Ruta:</label>
        <input type="number" name="id_Ruta" id="id_Ruta" value="<?php echo $paso['id_Ruta']; ?>" required>

        <label for="id_Paso_Previo">ID Paso Previo:</label>
        <input type="number" name="id_Paso_Previo" id="id_Paso_Previo" 
               value="<?php echo $paso['id_Paso_Previo'] ? $paso['id_Paso_Previo'] : ''; ?>" 
               placeholder="Opcional">

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="activo" <?php echo $paso['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?php echo $paso['estado'] === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <input type="submit" value="Actualizar Paso" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
