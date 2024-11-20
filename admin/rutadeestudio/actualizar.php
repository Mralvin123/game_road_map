<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['cod'])) {
    die("Error: El parámetro 'cod' no está definido.");
}

// Escapar el valor del 'id' para evitar inyecciones SQL
$id = mysqli_real_escape_string($db, $_GET['cod']);

// Consulta para obtener datos de la ruta
$query = "SELECT * FROM ruta_de_estudio WHERE id = '$id'";
$resultado = mysqli_query($db, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: Ruta de estudio no encontrada.");
}

$ruta = mysqli_fetch_assoc($resultado);

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $categoria = mysqli_real_escape_string($db, $_POST['categoria']);
    $estado = mysqli_real_escape_string($db, $_POST['estado']);

    // Actualizar el registro en la base de datos
    $query = "UPDATE ruta_de_estudio SET 
              titulo = '$titulo', 
              descripcion = '$descripcion', 
              categoria = '$categoria', 
              estado = '$estado' 
              WHERE id = '$id'";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "<script>
                alert('Ruta de estudio actualizada correctamente.');
                window.location.href = 'listarestudio.php'; // Redirigir a la tabla de rutas
              </script>";
    } else {
        echo "<script>alert('Error al actualizar la ruta de estudio.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Ruta de Estudio</title>
</head>
<?php include "../../includes/template/header.php";?>
<body>
    <h1>Actualizar Ruta de Estudio</h1>
    <form method="post" class="formulario">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo $ruta['titulo']; ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="4" required><?php echo $ruta['descripcion']; ?></textarea>

        <label for="categoria">Categoría:</label>
        <input type="text" name="categoria" id="categoria" value="<?php echo $ruta['categoria']; ?>" required>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="Activo" <?php echo $ruta['estado'] === 'Activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="Inactivo" <?php echo $ruta['estado'] === 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <input type="submit" value="Actualizar Ruta" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php";?>
</body>
</html>
