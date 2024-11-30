<?php
include '../../includes/config/database.php';
include '../../includes/config/database2.php';

// Verificar si se ha pasado el parámetro 'id' en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $stepId = htmlspecialchars($_GET['id']); // Escapamos el ID para evitar inyecciones

    try {
        // Consulta para obtener el paso según el ID
        $query = "SELECT p.id, p.titulo, p.descripcion, r.titulo as 'ruta de estudio', 
                         p2.titulo as 'paso previo', p.estado 
                  FROM paso p
                  JOIN ruta_de_estudio r ON p.id_Ruta = r.id
                  LEFT JOIN paso p2 ON p.id_Paso_Previo = p2.id
                  WHERE p.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $stepId, PDO::PARAM_INT);
        $stmt->execute();

        // Verificamos si se encontró el paso
        if ($stmt->rowCount() > 0) {
            $step = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "No se encontró el paso.";
            exit;
        }

        // Consulta para obtener los recursos extra del paso
        $queryResources = "SELECT r.id, r.titulo, r.url, t.nombre as tipo, 
                                  p.titulo as paso, n.nombre as 'nivel de subscripcion', r.estado
                           FROM recurso r
                           JOIN paso p ON r.id_Paso = p.id
                           JOIN tipo t ON r.id_Tipo = t.id
                           JOIN nivel_de_subscripcion n ON r.id_Nivel_Subs = n.id
                           WHERE r.id_Paso = :id";
        $stmtResources = $pdo->prepare($queryResources);
        $stmtResources->bindParam(':id', $stepId, PDO::PARAM_INT);
        $stmtResources->execute();

        // Almacenamos los recursos en un array
        $resources = $stmtResources->fetchAll(PDO::FETCH_ASSOC);
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
    <title><?php echo htmlspecialchars($step['titulo']); ?> - Paso</title>
    <link rel="stylesheet" href="../../stylesheet/Header.css">
    <link rel="stylesheet" href="../../stylesheet/Footer.css">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
    <link rel="stylesheet" href="../../stylesheet/visualizar.css">
    <style>
        .estado-activo {
            color: green;
        }

        .estado-inactivo {
            color: red;
        }
    </style>
</head>

<body>

    <?php include "../../includes/template/Header.php"; ?>

    <main>
    <section class="step-section">
        <h2 class="step-title">Paso: <?php echo htmlspecialchars($step['titulo']); ?></h2>
        <p class="step-description"><?php echo nl2br(htmlspecialchars($step['descripcion'])); ?></p>
        <p class="step-route">Ruta de Estudio: <?php echo htmlspecialchars($step['ruta de estudio']); ?></p>
        <p class="step-previous">Paso Previo: <?php echo htmlspecialchars($step['paso previo']); ?></p>
        <p class="step-status <?php echo ($step['estado'] === 'activo') ? 'estado-activo' : 'estado-inactivo'; ?>">
            Estado: <?php echo htmlspecialchars($step['estado']); ?>
        </p>
        <div class="step-actions">
            <a href="eliminar.php?cod=<?php echo htmlspecialchars($stepId); ?>" class="btn btn-danger">ELIMINAR</a>
            <a href="actualizar.php?cod=<?php echo htmlspecialchars($stepId); ?>" class="btn btn-success">MODIFICAR</a>
        </div>
    </section>



        <section>
            <h2>Recursos Extra</h2>
            <a href="../recursos/registrarrecursos.php?cod=<?php echo htmlspecialchars($step['id']) ?>" class='btn btn-success'>Registrar Recurso</a>
            <table class="table table-success table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>URL</th>
                        <th>Tipo</th>
                        <th>Paso</th>
                        <th>Nivel de Suscripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resources as $resource) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($resource['id']); ?></td>
                            <td style="max-width: 200px;"><?php echo htmlspecialchars($resource['titulo']); ?></td>
                            <td style="max-width: 200px;"><?php echo htmlspecialchars($resource['url']); ?></td>
                            <td><?php echo htmlspecialchars($resource['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($resource['paso']); ?></td>
                            <td><?php echo htmlspecialchars($resource['nivel de subscripcion']); ?></td>
                            <td><?php echo htmlspecialchars($resource['estado']); ?></td>
                            <td>
                                <a href="../recursos/eliminar.php?cod=<?php echo htmlspecialchars($resource['id']); ?>" class='btn btn-danger'>Eliminar</a>
                                <a href="../recursos/actualizar.php?cod=<?php echo htmlspecialchars($resource['id']); ?>" class='btn btn-success'>Modificar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (count($resources) < 1): ?>
                <p><center>No tiene recursos extra.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include "../../includes/template/Footer.php"; ?>

</body>

</html>