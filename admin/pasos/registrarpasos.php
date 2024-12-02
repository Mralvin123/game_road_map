<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Obtener las rutas de estudio para llenar el desplegable
$queryRutas = "SELECT id, titulo FROM ruta_de_estudio WHERE estado = 'activo'";
$resultadoRutas = mysqli_query($db, $queryRutas);

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['ajax'])) {
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $id_ruta = isset($_POST['id_ruta']) ? $_POST['id_ruta'] : null;
    $id_paso_previo = isset($_POST['id_paso_previo']) ? $_POST['id_paso_previo'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;

    if ($titulo && $descripcion && $id_ruta && $estado) {
        $consql = "INSERT INTO paso (titulo, descripcion, id_Ruta, id_Paso_Previo, estado) 
                   VALUES ('$titulo', '$descripcion', '$id_ruta', " . ($id_paso_previo ? "'$id_paso_previo'" : "NULL") . ", '$estado')";
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

// Manejar la consulta dinámica para obtener pasos previos según la ruta seleccionada
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax']) && $_POST['ajax'] === "true") {
    $id_ruta = mysqli_real_escape_string($db, $_POST['id_ruta']);
    $query = "SELECT id, titulo FROM paso WHERE id_Ruta = '$id_ruta' AND estado = 'activo'";
    $resultado = mysqli_query($db, $query);

    $opciones = '<option value="" disabled selected>Seleccione un paso previo</option>';
    while ($paso = mysqli_fetch_assoc($resultado)) {
        $opciones .= "<option value='{$paso['id']}'>{$paso['titulo']}</option>";
    }
    echo $opciones;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
    <title>Registrar Paso</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<?php include "../../includes/template/Header.php"; ?>
<body>
   <h1>Registrar Paso</h1>
   <form method="POST" action="">
       <label for="titulo">Título:</label>
       <input type="text" name="titulo" required><br>

       <label for="descripcion">Descripción:</label>
       <textarea name="descripcion" required></textarea><br>

       <label for="id_ruta">Ruta de Estudio:</label>
       <select name="id_ruta" id="id_ruta" required>
           <option value="" disabled selected>Seleccione una ruta</option>
           <?php while ($ruta = mysqli_fetch_assoc($resultadoRutas)): ?>
               <option value="<?php echo $ruta['id']; ?>"><?php echo $ruta['titulo']; ?></option>
           <?php endwhile; ?>
       </select><br>

       <label for="id_paso_previo">Paso Previo (opcional):</label>
       <select name="id_paso_previo" id="id_paso_previo">
           <option value="" disabled selected>Seleccione primero una ruta</option>
       </select><br>

       <label for="estado">Estado:</label>
       <select name="estado" required>
           <option value="activo" selected>activo</option>
           <option value="inactivo">inactivo</option>
       </select><br>

       <input type="submit" value="Registrar Paso">
   </form>
   <?php include "../../includes/template/Footer.php"; ?>

   <script>
       $(document).ready(function() {
           $('#id_ruta').on('change', function() {
               var rutaId = $(this).val();
               if (rutaId) {
                   $.ajax({
                       url: "", // Llama al mismo archivo
                       type: "POST",
                       data: { id_ruta: rutaId, ajax: "true" },
                       success: function(data) {
                           $('#id_paso_previo').html(data);
                       }
                   });
               } else {
                   $('#id_paso_previo').html('<option value="" disabled selected>Seleccione primero una ruta</option>');
               }
           });
       });
   </script>
</body>
</html>
