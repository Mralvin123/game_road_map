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

// Obtener las rutas de estudio activas para llenar el desplegable
$queryRutas = "SELECT id, titulo FROM ruta_de_estudio WHERE estado = 'activo'";
$resultadoRutas = mysqli_query($db, $queryRutas);

// Convertir el resultado en un arreglo
$rutas = [];
while ($ruta = mysqli_fetch_assoc($resultadoRutas)) {
    $rutas[] = $ruta;
}

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['ajax'])) {
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $idRuta = mysqli_real_escape_string($db, $_POST['id_ruta']);
    $idPasoPrevio = mysqli_real_escape_string($db, $_POST['id_paso_previo']);
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
include "../../includes/template/Header.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Paso</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Actualizar Paso</h1>
    <form method="POST" class="formulario">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo $paso['titulo']; ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?php echo $paso['descripcion']; ?></textarea>

        <label for="id_ruta">Ruta de Estudio:</label>
        <select name="id_ruta" id="id_ruta" required>
            <option value="" disabled selected>Seleccione una ruta</option>
            <?php
            // Usar un for en lugar de while para recorrer las rutas
            for ($i = 0; $i < count($rutas); $i++) {
                $ruta = $rutas[$i];
                ?>
                <option value="<?php echo $ruta['id']; ?>" <?php echo ($ruta['id'] == $paso['id_Ruta']) ? 'selected' : ''; ?>>
                    <?php echo $ruta['titulo']; ?>
                </option>
                <?php
            }
            ?>
        </select>

        <label for="id_paso_previo">Paso Previo (Opcional):</label>
        <select name="id_paso_previo" id="id_paso_previo">
            <option value="" disabled selected>Seleccione primero una ruta</option>
            <?php
            // Si ya existe un paso previo, mostrarlo seleccionado
            if ($paso['id_Paso_Previo']) {
                $pasoPrevioQuery = "SELECT * FROM paso WHERE id = '{$paso['id_Paso_Previo']}'";
                $pasoPrevioResult = mysqli_query($db, $pasoPrevioQuery);
                $pasoPrevio = mysqli_fetch_assoc($pasoPrevioResult);
                echo "<option value='{$pasoPrevio['id']}' selected>{$pasoPrevio['titulo']}</option>";
            }
            ?>
        </select>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="activo" <?php echo $paso['estado'] === 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="inactivo" <?php echo $paso['estado'] === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
        </select>

        <input type="submit" value="Actualizar Paso" class="boton boton-verde">
    </form>

    <script>
        $(document).ready(function() {
            // Cuando cambia la ruta seleccionada
            $('#id_ruta').on('change', function() {
                var rutaId = $(this).val();
                if (rutaId) {
                    $.ajax({
                        url: "",  // Llama al mismo archivo
                        type: "POST",
                        data: { id_ruta: rutaId, ajax: "true" },  // Envia el ID de la ruta
                        success: function(data) {
                            $('#id_paso_previo').html(data);  // Actualiza el campo de paso previo
                        }
                    });
                } else {
                    $('#id_paso_previo').html('<option value="" disabled selected>Seleccione primero una ruta</option>');
                }
            });
        });
    </script>

    <?php
    // Manejar la consulta AJAX para obtener los pasos previos de la ruta seleccionada
    if (isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
        $idRuta = mysqli_real_escape_string($db, $_POST['id_ruta']);
        $pasosQuery = "SELECT id, titulo FROM paso WHERE id_Ruta = '$idRuta' AND estado = 'activo'";
        $pasosResult = mysqli_query($db, $pasosQuery);
        $opciones = '<option value="" disabled selected>Seleccione un paso previo</option>';

        while ($paso = mysqli_fetch_assoc($pasosResult)) {
            $opciones .= "<option value='{$paso['id']}'>{$paso['titulo']}</option>";
        }

        echo $opciones;
        exit();
    }
    ?>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
