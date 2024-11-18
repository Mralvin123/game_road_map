<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];
        $estado = $_POST['estado'];
        $id_nivel_subs = $_POST['id_nivel_subs'];

        $query = "INSERT INTO usuario (id, email, password, rol, estado, id_nivel_subs) 
                  VALUES ('$id', '$email', '$password', '$rol', '$estado', '$id_nivel_subs')";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "Usuario creado correctamente.";
        } else {
            echo "Error al crear el usuario.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/tablausu.css">
    <title>Crear Usuario</title>
</head>
<?php include "../../includes/template/header.php";?>
<body>
    <h1>Crear Usuario</h1>
    <form method="post" class="formulario">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="rol">Rol:</label>
        <input type="text" name="rol" id="rol" required>

        <label for="estado">Estado:</label>
        <input type="text" name="estado" id="estado" required>

        <label for="id_nivel_subs">ID Nivel Subscripción:</label>
        <input type="text" name="id_nivel_subs" id="id_nivel_subs" required>

        <input type="submit" value="Crear Usuario" class="boton boton-verde">
    </form>
    <?php include "../../includes/template/Footer.php";?>
</body>
</html>