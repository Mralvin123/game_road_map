<?php
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Consulta para obtener los datos de la tabla categoria
    $query = "SELECT 
                id, 
                Titulo, 
                Descripcion, 
                estado 
              FROM categoria";
    $resultado = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de Categorías</title>
</head>
<?php include "../../includes/template/header.php"; ?>
<body>
    <h1>Lista de Categorías</h1>
    <a href="./registrarcategoria.php" class='btn btn-success'>Registrar Categoría</a>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($categoria = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $categoria['id']; ?></td>
                    <td><?php echo $categoria['Titulo']; ?></td>
                    <td><?php echo $categoria['Descripcion']; ?></td>
                    <td><?php echo $categoria['estado']; ?></td>
                    <td style="height: 110px; display: flex; flex-direction: column; justify-content: space-around;">
                        <?php echo "<a href='eliminar.php?id=".$categoria['id']."' class='btn btn-danger'>Eliminar</a>"; ?>
                        <?php echo "<a href='actualizar.php?id=".$categoria['id']."' class='btn btn-success'>Modificar</a>"; ?>
                        <?php echo "<a href='visualizar-categoria.php?id=".$categoria['id']."' class='btn btn-view'>Visualizar</a>"; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php"; ?>
</html>
