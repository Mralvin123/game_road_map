<?php
// Conexión a la base de datos
include "../../includes/config/database.php";
$db = conectarDB();

// Consulta para obtener los datos de la tabla recurso
$query = "SELECT 
            id, 
            titulo, 
            url, 
            estado, 
            id_Nivel_Subs, 
            id_Paso, 
            id_Tipo 
          FROM recurso";
$resultado = mysqli_query($db, $query);

include "../../includes/template/header.php"; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <title>Lista de recursos</title>
</head>
<body>
    <h1>Lista de recursos</h1>
    <a href="./registrarrecurso.php" class='btn btn-success'>Registrar recurso</a>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>URL</th>
                <th>Estado</th>
                <th>ID Nivel Subs</th>
                <th>ID Paso</th>
                <th>ID Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($recurso = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <!-- Mostrar datos con escape de caracteres -->
                    <td><?php echo htmlspecialchars($recurso['id']); ?></td>
                    <td><?php echo htmlspecialchars($recurso['titulo']); ?></td>
                    <td style="max-width: 300px; word-wrap: break-word;">
                        <a href="<?php echo htmlspecialchars($recurso['url']); ?>" target="_blank">
                            <?php echo htmlspecialchars($recurso['url']); ?>
                        </a>
                    </td>
                    <td>
                        <!-- Colorear el estado dependiendo de su valor -->
                        <span class="<?php echo $recurso['estado'] === 'activo' ? 'text-success' : 'text-danger'; ?>">
                            <?php echo htmlspecialchars($recurso['estado']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($recurso['id_Nivel_Subs']); ?></td>
                    <td><?php echo htmlspecialchars($recurso['id_Paso']); ?></td>
                    <td><?php echo htmlspecialchars($recurso['id_Tipo']); ?></td>
                    <td>
                        <!-- Botones de acción -->
                        <a href="eliminar.php?id=<?php echo $recurso['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este recurso?');">Eliminar</a>
                        <a href="actualizar.php?id=<?php echo $recurso['id']; ?>" class="btn btn-success">Modificar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
<?php include "../../includes/template/Footer.php"; ?>
</html>
