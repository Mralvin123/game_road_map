<?php
include '../../includes/config/database.php';
include '../../includes/config/database2.php';

// Verificar si se ha pasado el parámetro 'id' en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $routeId = htmlspecialchars($_GET['id']); // Escapamos el ID para evitar inyecciones

    try {
        // Consulta para obtener la ruta de estudio según el ID
        $query = "SELECT r.id, r.titulo, r.descripcion, c.Titulo as categoria, r.estado 
                  FROM ruta_de_estudio r 
                  JOIN categoria c ON r.idCategoria = c.id 
                  WHERE r.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $routeId, PDO::PARAM_INT);
        $stmt->execute();

        // Verificamos si se encontró la ruta
        if ($stmt->rowCount() > 0) {
            $route = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "No se encontró la ruta de estudio.";
            exit;
        }

        // Consulta para obtener los pasos de la ruta de estudio
        $querySteps = "SELECT p.id, p.titulo, p.descripcion, p.estado, r.titulo as 'ruta de estudio', p2.titulo as 'paso previo' 
                       FROM paso p
                       JOIN ruta_de_estudio r ON p.id_Ruta = r.id
                       LEFT JOIN paso p2 ON p.id_Paso_Previo = p2.id
                       WHERE p.id_Ruta = :id";
        $stmtSteps = $pdo->prepare($querySteps);
        $stmtSteps->bindParam(':id', $routeId, PDO::PARAM_INT);
        $stmtSteps->execute();
        
        // Almacenamos los pasos en un array
        $steps = $stmtSteps->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error al realizar la consulta: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($route['titulo']); ?> - Ruta de Estudio</title>
    <link rel="stylesheet" href="../../stylesheet/Header.css">
    <link rel="stylesheet" href="../../stylesheet/Footer.css">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <link rel="stylesheet" href="../../stylesheet/visualizar.css">
    
</head>
<body>

    <?php include "../../includes/template/Header.php"; ?>

    <main>
    <section class="route-section">
        <h2 class="route-title">Ruta de Estudio: <?php echo htmlspecialchars($route['titulo']); ?></h2>
        <p class="route-description"><?php echo nl2br(htmlspecialchars($route['descripcion'])); ?></p>
        <p class="route-category">Categoría: <?php echo htmlspecialchars($route['categoria']); ?></p>
        <p class="route-status <?php echo ($route['estado'] === 'Activo' || $route['estado'] === 'activo') ? 'estado-activo' : 'estado-inactivo'; ?>">
            Estado: <?php echo htmlspecialchars($route['estado']); ?>
        </p>
        <a href="eliminar.php?cod=<?php echo htmlspecialchars($routeId); ?>" class="btn btn-danger">ELIMINAR</a>
        <a href="actualizar.php?cod=<?php echo htmlspecialchars($routeId); ?>" class="btn btn-success">MODIFICAR</a>
    </section>
</main>


        


        <section>
            <h2>Pasos Relacionados</h2>
            <a href="../pasos/registrarpasos.php?cod=<?php echo htmlspecialchars($route['id'])?>" class='btn btn-success'>Registrar Paso</a>
            <table class="table table-success table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Ruta de Estudio</th>
                        <th>Paso Previo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($steps as $step) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($step['id']); ?></td>
                            <td style="max-width: 200px;"><?php echo htmlspecialchars($step['titulo']); ?></td>
                            <td style="max-width: 300px;"><?php echo nl2br(htmlspecialchars($step['descripcion'])); ?></td>
                            <td><?php echo htmlspecialchars($step['ruta de estudio']); ?></td>
                            <td><?php echo htmlspecialchars($step['paso previo']); ?></td>
                            <td><?php echo htmlspecialchars($step['estado']); ?></td>
                            <td style="height: 110px; display: flex; flex-direction: column; justify-content: space-around;">
                                <a href="../pasos/eliminar.php?cod=<?echo htmlspecialchars($step['id']); ?>" class='btn btn-danger'>Eliminar</a>
                                <a href="../pasos/actualizar.php?cod=<?php echo htmlspecialchars($step['id']); ?>" class='btn btn-success'>Modificar</a>
                                <a href="../pasos/visualizarpaso.php?id=<?php echo htmlspecialchars($step['id']); ?>" class='btn btn-view'>Visualizar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (count($steps) < 1): ?>
                <p><center>No tiene pasos extra.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include "../../includes/template/Footer.php"; ?>  

</body>
</html>