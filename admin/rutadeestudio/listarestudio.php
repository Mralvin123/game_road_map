<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Consulta para obtener los datos de la tabla `ruta_de_estudio` con estado 'Activo'
    $query = "SELECT id, titulo, descripcion, categoria, estado FROM ruta_de_estudio ";
    $resultado = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de Rutas de Estudio</title>
</head>
<?php include "../../includes/template/header.php"; ?>
<body>
    <h1>Lista de Rutas de Estudio</h1>
    <a href="./registrarruta.php" class='btn btn-success'>Registrar Nueva Ruta</a>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($ruta = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $ruta['id']; ?></td>
                    <td><?php echo $ruta['titulo']; ?></td>
                    <td><?php echo $ruta['descripcion']; ?></td>
                    <td><?php echo $ruta['categoria']; ?></td>
                    <td><?php echo $ruta['estado']; ?></td>
                    <td>
                        <a href="eliminar.php?cod=<?php echo $ruta['id']; ?>" class='btn btn-danger'>ELIMINAR</a>
                        <a href="actualizar.php?cod=<?php echo $ruta['id']; ?>" class='btn btn-success'>MODIFICAR</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php"; ?>
</html>
