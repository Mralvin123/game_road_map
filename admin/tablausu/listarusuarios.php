<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    $query = "SELECT Usuario.id, Usuario.email, Usuario.password, Usuario.rol, Usuario.estado, Nivel_de_Subscripcion.nombre AS 'nivel_subs' FROM Usuario JOIN Nivel_de_Subscripcion ON Usuario.id_nivel_subs = Nivel_de_Subscripcion.id";
    $resultado = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de Usuarios</title>
</head>
<?php include "../../includes/template/header.php";?>
<body>
    

    <h1>Lista de Usuarios Activos</h1>
    <a href="./registrarusuarios.php" class='btn btn-success'> Registrar usuarios </a>
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
                    <td>
                        <?php echo "<a style='margin-right: 20px;'href=eliminar.php?cod=".$usuario['id']." class='btn btn-danger'> ELIMINAR </a>";?>
                        <?php echo "<a href=actualizar.php?cod=".$usuario['id']." class='btn btn-success'> MODIFICAR </a>";?>
                    </td>    
                </tr>
            <?php endwhile; ?>
        </tbody>

<tbody>
            <?php while ($nivel = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $nivel['id']; ?></td>
                    <td><?php echo $nivel['costo']; ?></td>
                    <td><?php echo $nivel['nombre']; ?></td>
                    <td><?php echo $nivel['estado']; ?></td>

                        <?php echo "<a href='eliminar.php?id=".$nivel['id']."' class='btn btn-danger'>Eliminar</a>"; ?>
                        <?php echo "<a href='actualizar.php?id=".$nivel['id']."' class='btn btn-success'>Modificar</a>"; ?>

                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
</body>
<?php include "../../includes/template/Footer.php";?>
</html>