<?php
include "../../includes/config/database.php";
$db = conectarDB();

// Validar si el parámetro 'cod' está definido
if (!isset($_GET['cod'])) {
    die("Error: El parámetro 'cod' no está definido.");
}

// Escapar el valor del 'id' para evitar inyecciones SQL
$id = mysqli_real_escape_string($db, $_GET['cod']);

// Consulta para obtener datos del usuario
$query = "SELECT * FROM usuario WHERE id = '$id'";
$resultado = mysqli_query($db, $query);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Error: Usuario no encontrado.");
}

$usuario = mysqli_fetch_assoc($resultado);

// Obtener los niveles de suscripción para el desplegable
$queryNiveles = "SELECT id, nombre FROM nivel_de_subscripcion WHERE estado = 'activo'";
$resultadoNiveles = mysqli_query($db, $queryNiveles);

// Actualizar datos si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $rol = mysqli_real_escape_string($db, $_POST['rol']);
    $estado = mysqli_real_escape_string($db, $_POST['estado']);
    $id_nivel_subs = mysqli_real_escape_string($db, $_POST['id_nivel_subs']);

    // Encriptar la nueva contraseña usando md5
    $passwordHash = md5($password);

    // Actualizar el registro en la base de datos
    $query = "UPDATE usuario SET 
              email = '$email', 
              password = '$passwordHash', 
              rol = '$rol', 
              estado = '$estado', 
              id_nivel_subs = '$id_nivel_subs' 
              WHERE id = '$id'";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "<script>
                alert('Usuario actualizado correctamente.');
                window.location.href = 'listarusuarios.php'; // Redirigir a la tabla de usuarios
              </script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/modificar.css">
    <title>Actualizar Usuario</title>
</head>
<?php include "../../includes/template/header.php";?>
<body>
    <h1>Actualizar Usuario</h1>
    <form method="post" class="formulario">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $usuario['email']; ?>" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Ingrese una nueva contraseña o mantenga la actual" required>

        <label for="rol">Rol:</label>
        <input type="text" name="rol" id="rol" value="<?php echo $usuario['rol']; ?>" required>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" id="estado" value="<?php echo $usuario['estado']; ?>" required>

        <label for="id_nivel_subs">Nivel de Suscripción:</label>
        <select name="id_nivel_subs" id="id_nivel_subs" required>
            <option value="" disabled>Seleccione un nivel</option>
            <?php
            while ($nivel = mysqli_fetch_assoc($resultadoNiveles)) {
                // Comparar el ID actual del usuario con el ID del nivel
                $selected = ($nivel['id'] == $usuario['id_nivel_subs']) ? 'selected' : '';
                echo "<option value='{$nivel['id']}' $selected>{$nivel['nombre']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Actualizar Usuario" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php";?>
</body>
</html>
