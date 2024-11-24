<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Roadmaps de Desarrollo de Videojuegos</title>
    <link rel="stylesheet" href="stylesheet/index.css">
    <link rel="stylesheet" href="stylesheet/Header.css">
    <link rel="stylesheet" href="stylesheet/Footer.css">
</head>
<body>
    <?php include "./includes/template/Header.php"; ?>

    <?php
    // Incluir la configuración de la base de datos con PDO
    include './includes/config/database2.php';
    ?>

    <main>
        <section class="intro">
            <div class="intro-content">
                <h1>Roadmaps de Desarrollo de Videojuegos</h1>
                <p>Descubre y sigue rutas de aprendizaje para convertirte en un experto en desarrollo de videojuegos.</p>
                <div class="buttons">
                    <?php
                    // Consultar categorías activas
                    try {
                        $query = "SELECT id, Titulo FROM categoria WHERE estado = 'Activo'";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Generar botones dinámicos
                        foreach ($categories as $category) {
                            $categoryId = htmlspecialchars($category['id']);
                            $categoryName = htmlspecialchars($category['Titulo']);
                            echo "<a href='#categoria-{$categoryId}' class='btn btn-primary'>{$categoryName}</a>";
                        }
                    } catch (PDOException $e) {
                        echo "Error al realizar la consulta: " . $e->getMessage();
                        die();
                    }
                    ?>
                </div>
            </div>
        </section>

        <?php
        // Consultar rutas activas junto con sus categorías
        try {
            $query = "
                SELECT 
                    r.id AS ruta_id,
                    r.titulo AS ruta_titulo,
                    r.descripcion AS ruta_descripcion,
                    c.id AS categoria_id,
                    c.Titulo AS categoria_titulo
                FROM ruta_de_estudio r
                INNER JOIN categoria c ON r.idCategoria = c.id
                WHERE r.estado = 'activo' AND c.estado = 'Activo'
                ORDER BY c.id, r.id";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al realizar la consulta: " . $e->getMessage();
            die();
        }

        // Mostrar rutas agrupadas por categoría
        $currentCategory = null;
        foreach ($result as $row) {
            if ($currentCategory !== $row['categoria_id']) {
                if ($currentCategory !== null) {
                    echo '</div>'; // Cerrar el contenedor de la categoría anterior
                }
                $currentCategory = $row['categoria_id'];
                $categoryTitle = htmlspecialchars($row['categoria_titulo']);
                echo "<section id='categoria-{$currentCategory}' class='roadmap'>";
                echo "<h2>{$categoryTitle}</h2>";
                echo "<div class='roadmap-subsection'><div class='roadmap-container'>";
            }
            // Mostrar cada ruta de la categoría
            $routeId = htmlspecialchars($row['ruta_id']);
            $routeTitle = htmlspecialchars($row['ruta_titulo']);
            echo "<div class='roadmap-item'><a href='GameRoutes/Route.php?id={$routeId}'>{$routeTitle}</a></div>";
        }
        if ($currentCategory !== null) {
            echo '</div>'; // Cerrar el último contenedor
        }
        ?>
    </main>

    <?php include "./includes/template/Footer.php"; ?>
</body>
</html>
