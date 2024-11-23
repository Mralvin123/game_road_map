<?php
include "../../includes/template/header.php";

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $rol = isset($_POST['rol']) ? $_POST['rol'] : null;
    $estado = isset($_POST['estado']) ? $_POST['estado'] : null;
    $id_nivel_subs = isset($_POST['id_nivel_subs']) ? $_POST['id_nivel_subs'] : null;

    // Validar que todos los campos requeridos están presentes
    if ($email && $password && $rol && $estado && $id_nivel_subs) {
        include "../../includes/config/database.php";
        $db = conectarDB();

        // Obtener el último ID de la base de datos y sumar 1
        $query = "SELECT MAX(id) AS max_id FROM usuario";
        $resultado = mysqli_query($db, $query);
        $fila = mysqli_fetch_assoc($resultado);
        $nuevoID = $fila['max_id'] + 1;

        // Encriptar la contraseña usando md5
        $passwordHash = md5($password);

        // Insertar el nuevo usuario en la base de datos
        $consql = "INSERT INTO usuario (id, email, password, rol, estado, id_nivel_subs) 
                   VALUES ('$nuevoID', '$email', '$passwordHash', '$rol', '$estado', '$id_nivel_subs')";
        $res = mysqli_query($db, $consql);

        if ($res) {
            echo "<script>
                    alert('Registro exitoso');
                    window.location.href = 'listarusuarios.php';
                  </script>";
        } else {
            echo "Error al registrar: " . mysqli_error($db);
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
    <title>Registrar Usuario</title>
</head>
<body>
   <!-- Formulario HTML para agregar un nuevo usuario -->
   <h1>Registrar Usuario</h1>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required><br>

    <label for="rol">Rol:</label>
    <input type="text" name="rol" required><br>

    <label for="estado">Estado:</label>
    <input type="text" name="estado" required><br>

    <label for="id_nivel_subs">ID Nivel Subs:</label>
    <input type="text" name="id_nivel_subs" required><br>

    <input type="submit" value="Registrar Usuario">
</form>
<?php include "../../includes/template/Footer.php"; ?> 
</body>
</html>
