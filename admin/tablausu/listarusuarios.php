<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    $query = "SELECT Usuario.id, Usuario.email, Usuario.password, Usuario.rol, Usuario.estado, Nivel_de_Subscripcion.nombre AS 'nivel_subs' FROM Usuario JOIN Nivel_de_Subscripcion ON Usuario.id_nivel_subs = Nivel_de_Subscripcion.id WHERE Usuario.estado = 'activo'";
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
<a href="./registrarusuarios.php" class="boton boton-red"> Usuarios </a>
    <h1>Lista de Usuarios Activos</h1>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Niveles de Subscripción</th>
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
                    <td><?php echo $usuario['nivel_subs']; ?></td>
                    
                    <?php echo "<td> <a href=eliminar.php?cod=".$usuario['id']." class='btn btn-danger'> ELIMINAR </a></td>";?>
                    <?php echo "<td> <a href=actualizar.php?cod=".$usuario['id']." class='btn btn-success'> MODIFICAR </a></td>";?>
                    
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php";?>
</html>