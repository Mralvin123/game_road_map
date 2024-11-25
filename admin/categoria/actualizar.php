<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Escapar el valor de 'id' para evitar inyecciones SQL
$idCategoria = mysqli_real_escape_string($db, $_GET['id']);

// Consulta para obtener datos de la categoría
$query = "SELECT * FROM categoria WHERE id = '$idCategoria'";
$resultado = mysqli_query($db, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: Categoría no encontrada.");
}

$categoria = mysqli_fetch_assoc($resultado);

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = mysqli_real_escape_string($db, $_POST['Titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['Descripcion']);
    $estado = mysqli_real_escape_string($db, $_POST['estado']);

    // Consulta para actualizar el registro
    $query = "UPDATE categoria SET 
              Titulo = '$titulo', 
              Descripcion = '$descripcion', 
              estado = '$estado' 
              WHERE id = '$idCategoria'";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "<script>
                alert('Categoría actualizada correctamente.');
                window.location.href = 'listarcategoria.php'; // Redirigir a la lista de categorías
              </script>";
    } else {
        echo "<script>alert('Error al actualizar la categoría.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Categoría</title>
</head>
<?php include "../../includes/template/header.php"; ?>
<body>
    <h1>Actualizar Categoría</h1>
    <form method="post" class="formulario">
        <label for="Titulo">Título:</label>
        <input type="text" name="Titulo" id="Titulo" value="<?php echo $categoria['Titulo']; ?>" required>

        <label for="Descripcion">Descripción:</label>
        <textarea name="Descripcion" id="Descripcion" required><?php echo $categoria['Descripcion']; ?></textarea>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="Activo" <?php echo $categoria['estado'] === 'Activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="Inactivo" <?php echo $categoria['estado'] === 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <input type="submit" value="Actualizar Categoría" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
