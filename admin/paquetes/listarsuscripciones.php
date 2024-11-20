<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Consulta para obtener los datos de nivel_de_subscripcion
    $query = "SELECT 
                id, 
                costo, 
                nombre, 
                estado 
              FROM nivel_de_subscripcion";
    $resultado = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de Niveles de Suscripción</title>
</head>
<?php include "../../includes/template/header.php"; ?>
<body>
    <h1>Lista de Niveles de Suscripción</h1>
    <a href="./registrarsuscripciones.php" class='btn btn-success'>Registrar suscripcion</a>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Costo</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($nivel = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $nivel['id']; ?></td>
                    <td><?php echo $nivel['costo']; ?></td>
                    <td><?php echo $nivel['nombre']; ?></td>
                    <td><?php echo $nivel['estado']; ?></td>
                    <td>
                        <?php echo "<a href='eliminar.php?id=".$nivel['id']."' class='btn btn-danger'>Eliminar</a>"; ?>
                        <?php echo "<a href='actualizar.php?id=".$nivel['id']."' class='btn btn-success'>Modificar</a>"; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php"; ?>
</html>