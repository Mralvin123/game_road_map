<?php
include '../../includes/config/database.php';
include '../../includes/config/database2.php';

// Verificar si se ha pasado el parámetro 'id' en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $categoryId = htmlspecialchars($_GET['id']); // Escapamos el ID para evitar inyecciones

    try {
        // Consulta para obtener la categoría según el ID
        $queryCategory = "SELECT c.Titulo, c.Descripcion, c.estado
                          FROM categoria c
                          WHERE c.id = :id";
        $stmtCategory = $pdo->prepare($queryCategory);
        $stmtCategory->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmtCategory->execute();

        // Verificamos si se encontró la categoría
        if ($stmtCategory->rowCount() > 0) {
            $category = $stmtCategory->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "No se encontró la categoría.";
            exit;
        }

        // Consulta para obtener las rutas de estudio de la categoría
        $queryRoutes = "SELECT r.id, r.titulo, r.descripcion, c.Titulo as categoria, r.estado
                        FROM ruta_de_estudio r
                        JOIN categoria c ON r.idCategoria = c.id
                        WHERE c.id = :id";
        $stmtRoutes = $pdo->prepare($queryRoutes);
        $stmtRoutes->bindParam(':id', $categoryId, PDO::PARAM_INT);
        $stmtRoutes->execute();

        // Almacenamos las rutas en un array
        $routes = $stmtRoutes->fetchAll(PDO::FETCH_ASSOC);

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
    <title><?php echo htmlspecialchars($category['Titulo']); ?> - Categoría</title>
    <link rel="stylesheet" href="../../stylesheet/Header.css">
    <link rel="stylesheet" href="../../stylesheet/Footer.css">
    <link rel="stylesheet" href="../../stylesheet/listausu.css">
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
        <section>
            <h2>Categoría: <?php echo htmlspecialchars($category['Titulo']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($category['Descripcion'])); ?></p>
            <p class="<?php echo $category['estado'] === 'activo' ? 'estado-activo' : 'estado-inactivo'; ?>">
                Estado: <?php echo htmlspecialchars($category['estado']); ?>
            </p>
            <a href="eliminar.php?cod=<?php echo htmlspecialchars($categoryId); ?>" class='btn btn-danger'>ELIMINAR</a>
            <a href="actualizar.php?cod=<?php echo htmlspecialchars($categoryId); ?>" class='btn btn-success'>MODIFICAR</a>
        </section>

        <section>
            <h2>Rutas de Estudio</h2>
            <a href="../rutadeestudio/registrarruta.php?cod=<?php echo htmlspecialchars($categoryId) ?>" class='btn btn-success'>Registrar Ruta</a>
            <?php if (count($routes) > 0): ?>
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
                        <?php foreach ($routes as $route) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($route['id']); ?></td>
                                <td style="max-width: 200px;"><?php echo htmlspecialchars($route['titulo']); ?></td>
                                <td style="max-width: 200px;"><?php echo nl2br(htmlspecialchars($route['descripcion'])); ?></td>
                                <td><?php echo htmlspecialchars($route['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($route['estado']); ?></td>
                                <td style="height: 110px; display: flex; flex-direction: column; justify-content: space-around;">
                                    <a href="../rutadeestudio/eliminar.php?cod=<?php echo htmlspecialchars($route['id']); ?>" class='btn btn-danger'>Eliminar</a>
                                    <a href="../rutadeestudio/actualizar.php?cod=<?php echo htmlspecialchars($route['id']); ?>" class='btn btn-success'>Modificar</a>
                                    <a href="../rutadeestudio/visualizar-ruta-estudio.php?id=<?php echo htmlspecialchars($route['id']); ?>" class="btn btn-view">Visualizar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay rutas de estudio disponibles para esta categoría.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include "../../includes/template/Footer.php"; ?>

</body>

</html>