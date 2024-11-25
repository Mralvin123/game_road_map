<?php
 
    // Conexión a la base de datos
    include "../../includes/config/database.php";
    $db = conectarDB();

    // Consulta para obtener los datos de nivel_de_subscripcion
    $query = "SELECT 
                id, 
                costo, 
                nombre, 
                descripcion, 
                estado 
              FROM nivel_de_subscripcion";
    $resultado = mysqli_query($db, $query);
    include "../../includes/template/header.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de Niveles de Suscripción</title>
</head>

<body>
    
    <h1>Lista de Niveles de Suscripción</h1>
    <a href="./registrarsuscripciones.php" class='btn btn-success'>Registrar suscripción</a>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Costo</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($nivel = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $nivel['id']; ?></td>
                    <td><?php echo number_format($nivel['costo'], 2); ?></td>
                    <td><?php echo htmlspecialchars($nivel['nombre']); ?></td>
                    <td style="max-width: 500px;"><?php echo htmlspecialchars($nivel['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($nivel['estado']); ?></td>
                    <td>
                        <a href="eliminar.php?id=<?php echo $nivel['id']; ?>" class="btn btn-danger">Eliminar</a>
                        <a href="actualizar.php?id=<?php echo $nivel['id']; ?>" class="btn btn-success">Modificar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php"; ?>
</html>
