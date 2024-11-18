<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    $query = "SELECT * FROM usuario WHERE estado = 'activo'";
    $resultado = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/tablausu.css">
    <title>Lista de Usuarios</title>
</head>
<?php include "../../includes/template/header.php";?>
<body>
    <h1>Lista de Usuarios Activos</h1>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>ID Nivel Subscripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usuario = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['password']; ?></td>
                    <td><?php echo $usuario['rol']; ?></td>
                    <td><?php echo $usuario['estado']; ?></td>
                    <td><?php echo $usuario['id_nivel_subs']; ?></td>
                    <td>
                        <a href="actualizar.php">motificar</a>
                        <a href="eliminar.php">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php";?>
</html>