<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Consulta para obtener los datos de la tabla `ruta_de_estudio` con sus categorías
    $query = "
        SELECT r.id, r.titulo, r.descripcion, c.Titulo AS categoria, r.estado 
        FROM ruta_de_estudio r
        INNER JOIN categoria c ON r.idCategoria = c.id";
    $resultado = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="es">
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
                    <td><?php echo htmlspecialchars($ruta['id']); ?></td>
                    <td><?php echo htmlspecialchars($ruta['titulo']); ?></td>
                    <td style="max-width: 250px;"><?php echo nl2br(htmlspecialchars($ruta['descripcion'])); ?></td>
                    <td><?php echo htmlspecialchars($ruta['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($ruta['estado']); ?></td>
                    <td style="height: 110px; display: flex; flex-direction: column; justify-content: space-around;">
                            <a href="eliminar.php?cod=<?php echo htmlspecialchars($ruta['id']); ?>" class='btn btn-danger'>ELIMINAR</a>
                            <a href="actualizar.php?cod=<?php echo htmlspecialchars($ruta['id']); ?>" class='btn btn-success'>MODIFICAR</a>
                            <a href="visualizar-ruta-estudio.php?id=<?php echo htmlspecialchars($ruta['id']); ?>" class="btn btn-view">VISUALIZAR</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php"; ?>
</html>
