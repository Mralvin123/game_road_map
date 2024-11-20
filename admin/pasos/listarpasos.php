<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Consulta para obtener los pasos
    $query = "SELECT 
                paso.id, 
                paso.titulo, 
                paso.descripcion, 
                paso.id_Ruta, 
                paso.id_Paso_Previo, 
                paso.estado 
              FROM paso";
    $resultado = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de Pasos</title>
</head>
<?php include "../../includes/template/header.php";?>
<body>
    <h1>Lista de Pasos</h1>
    <a href="./registrarpasos.php" class='btn btn-success'>Registrar Paso</a>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>ID Ruta</th>
                <th>ID Paso Previo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($paso = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $paso['id']; ?></td>
                    <td><?php echo $paso['titulo']; ?></td>
                    <td><?php echo $paso['descripcion']; ?></td>
                    <td><?php echo $paso['id_Ruta']; ?></td>
                    <td><?php echo $paso['id_Paso_Previo'] ? $paso['id_Paso_Previo'] : 'N/A'; ?></td>
                    <td><?php echo $paso['estado']; ?></td>
                    <td>
                        <?php echo "<a href='eliminar.php?id=".$paso['id']."' class='btn btn-danger'>Eliminar</a>"; ?>
                        <?php echo "<a href='actualizar.php?cod=".$paso['id']."' class='btn btn-success'>Modificar</a>"; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php";?>
</html>
