<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'id' está definido
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Escapar el valor de 'id' para evitar inyecciones SQL
$idRecurso = mysqli_real_escape_string($db, $_GET['id']);

// Consulta para obtener datos del recurso
$query = "SELECT * FROM recurso WHERE id = '$idRecurso'";
$resultado = mysqli_query($db, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: Recurso no encontrado.");
}

$recurso = mysqli_fetch_assoc($resultado);

// Consultar los niveles de suscripción
$query_nivel_subs = "SELECT id, nombre FROM nivel_de_subscripcion";
$resultado_nivel_subs = mysqli_query($db, $query_nivel_subs);

// Consultar los pasos
$query_paso = "SELECT id, titulo FROM paso";
$resultado_paso = mysqli_query($db, $query_paso);

// Consultar los tipos
$query_tipo = "SELECT id, nombre FROM tipo";
$resultado_tipo = mysqli_query($db, $query_tipo);

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $url = mysqli_real_escape_string($db, $_POST['url']);
    $estado = mysqli_real_escape_string($db, $_POST['estado']);
    $id_Nivel_Subs = mysqli_real_escape_string($db, $_POST['id_Nivel_Subs']);
    $id_Paso = mysqli_real_escape_string($db, $_POST['id_Paso']);
    $id_Tipo = mysqli_real_escape_string($db, $_POST['id_Tipo']);

    // Consulta para actualizar el registro
    $query = "UPDATE recurso SET 
              titulo = '$titulo', 
              url = '$url', 
              estado = '$estado',
              id_Nivel_Subs = '$id_Nivel_Subs',
              id_Paso = '$id_Paso',
              id_Tipo = '$id_Tipo' 
              WHERE id = '$idRecurso'";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "<script>
                alert('Recurso actualizado correctamente.');
                window.location.href = 'listarrecurso.php'; // Redirigir a la lista de recursos
              </script>";
    } else {
        echo "<script>alert('Error al actualizar el recurso.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Recurso</title>
</head>
<?php include "../../includes/template/Header.php"; ?>
<body>
    <h1>Actualizar Recurso</h1>
    <form method="post" class="formulario">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($recurso['titulo']); ?>" required>

        <label for="url">URL:</label>
        <input type="url" name="url" id="url" value="<?php echo htmlspecialchars($recurso['url']); ?>" required>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="activo" <?php echo $recurso['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?php echo $recurso['estado'] === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <label for="id_Nivel_Subs">ID Nivel de Subscripción:</label>
        <select name="id_Nivel_Subs" id="id_Nivel_Subs" required>
            <?php while ($nivel = mysqli_fetch_assoc($resultado_nivel_subs)) { ?>
                <option value="<?= $nivel['id']; ?>" <?= $recurso['id_Nivel_Subs'] == $nivel['id'] ? 'selected' : ''; ?>>
                    <?= $nivel['nombre']; ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_Paso">ID Paso:</label>
        <select name="id_Paso" id="id_Paso" required>
            <?php while ($paso = mysqli_fetch_assoc($resultado_paso)) { ?>
                <option value="<?= $paso['id']; ?>" <?= $recurso['id_Paso'] == $paso['id'] ? 'selected' : ''; ?>>
                    <?= $paso['titulo']; ?>
                </option>
            <?php } ?>
        </select>

        <label for="id_Tipo">ID Tipo:</label>
        <select name="id_Tipo" id="id_Tipo" required>
            <?php while ($tipo = mysqli_fetch_assoc($resultado_tipo)) { ?>
                <option value="<?= $tipo['id']; ?>" <?= $recurso['id_Tipo'] == $tipo['id'] ? 'selected' : ''; ?>>
                    <?= $tipo['nombre']; ?>
                </option>
            <?php } ?>
        </select>

        <input type="submit" value="Actualizar Recurso" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
