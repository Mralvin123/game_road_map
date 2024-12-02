<?php
include "../../includes/template/header.php";

// Conectar a la base de datos
include "../../includes/config/database.php";
$db = conectarDB();

// Consultar los niveles de suscripción
$query_nivel_subs = "SELECT id, nombre FROM nivel_de_subscripcion";
$resultado_nivel_subs = mysqli_query($db, $query_nivel_subs);

// Consultar los pasos
$query_paso = "SELECT id, titulo FROM paso";
$resultado_paso = mysqli_query($db, $query_paso);

// Consultar los tipos
$query_tipo = "SELECT id, nombre FROM tipo";
$resultado_tipo = mysqli_query($db, $query_tipo);

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : null;
    $url = isset($_POST['url']) ? trim($_POST['url']) : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
    $id_Nivel_Subs = isset($_POST['id_Nivel_Subs']) ? $_POST['id_Nivel_Subs'] : null;
    $id_Paso = isset($_POST['id_Paso']) ? $_POST['id_Paso'] : null;
    $id_Tipo = isset($_POST['id_Tipo']) ? $_POST['id_Tipo'] : null;

    // Validar que todos los campos requeridos están presentes
    if ($titulo && $url && $estado && $id_Nivel_Subs && $id_Paso && $id_Tipo) {
        // Escapar valores para evitar inyección SQL
        $titulo = mysqli_real_escape_string($db, $titulo);
        $url = mysqli_real_escape_string($db, $url);
        $estado = mysqli_real_escape_string($db, $estado);
        $id_Nivel_Subs = mysqli_real_escape_string($db, $id_Nivel_Subs);
        $id_Paso = mysqli_real_escape_string($db, $id_Paso);
        $id_Tipo = mysqli_real_escape_string($db, $id_Tipo);

        // Consulta para insertar el nuevo recurso
        $query = "INSERT INTO recurso (titulo, url, estado, id_Nivel_Subs, id_Paso, id_Tipo) 
                  VALUES ('$titulo', '$url', '$estado', '$id_Nivel_Subs', '$id_Paso', '$id_Tipo')";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "<script>
                    alert('Registro exitoso');
                    window.location.href = 'listarrecurso.php';
                  </script>";
        } else {
            echo "<script>alert('Error al registrar: " . mysqli_error($db) . "');</script>";
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
    <title>Registrar Recurso</title>
</head>
<body>
    <h1>Registrar Recurso</h1>
    <form method="POST" action="" class="formulario">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required><br>

        <label for="url">URL:</label>
        <input type="url" name="url" id="url" required><br>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="activo">activo</option>
            <option value="inactivo">inactivo</option>
        </select><br>

        <label for="id_Nivel_Subs">ID Nivel de Subscripción:</label>
        <select name="id_Nivel_Subs" id="id_Nivel_Subs" required>
            <?php while ($nivel = mysqli_fetch_assoc($resultado_nivel_subs)) { ?>
                <option value="<?= $nivel['id']; ?>"><?= $nivel['nombre']; ?></option>
            <?php } ?>
        </select><br>

        <label for="id_Paso">ID Paso:</label>
        <select name="id_Paso" id="id_Paso" required>
            <?php while ($paso = mysqli_fetch_assoc($resultado_paso)) { ?>
                <option value="<?= $paso['id']; ?>"><?= $paso['titulo']; ?></option>
            <?php } ?>
        </select><br>

        <label for="id_Tipo">ID Tipo:</label>
        <select name="id_Tipo" id="id_Tipo" required>
            <?php while ($tipo = mysqli_fetch_assoc($resultado_tipo)) { ?>
                <option value="<?= $tipo['id']; ?>"><?= $tipo['nombre']; ?></option>
            <?php } ?>
        </select><br>

        <input type="submit" value="Registrar Recurso" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
