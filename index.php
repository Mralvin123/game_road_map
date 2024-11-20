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
    // Incluir la configuración de la base de datos para establecer la conexión con PDO
    include './includes/config/database.php';
    include './includes/config/database2.php';
    ?>

    <main>
        <section class="intro">
            <div class="intro-content">
                <h1>Roadmaps de Desarrollo de Videojuegos</h1>
                <p>Descubre y sigue rutas de aprendizaje para convertirte en un experto en desarrollo de videojuegos.</p>
                <div class="buttons">
                    <?php
                    // Realizamos la consulta para obtener las categorías
                    try {
                        $query = "SELECT categoria FROM Ruta_de_estudio WHERE estado = 'activo' GROUP BY categoria";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenemos todas las categorías

                        // Generamos los enlaces dinámicamente
                        foreach ($categories as $category) {
                            $categoryName = htmlspecialchars($category['categoria']); // Escapamos caracteres especiales
                            echo "<a href='#{$categoryName}' class='btn btn-primary'>{$categoryName}</a>";
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
        // Realizamos la consulta a la base de datos
        try {
            // Esta consulta selecciona los datos necesarios de la tabla Ruta_de_estudio
            $query = "SELECT id, categoria, titulo, descripcion FROM Ruta_de_estudio WHERE estado = 'activo' ORDER BY categoria";
            $stmt = $pdo->prepare($query);  // Usamos la conexión PDO para preparar la consulta
            $stmt->execute(); // Ejecutamos la consulta
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenemos todos los resultados como un array asociativo
        } catch (PDOException $e) {
            // Si ocurre algún error al ejecutar la consulta, lo mostramos
            echo "Error al realizar la consulta: " . $e->getMessage();
            die();
        }

        // Variable para almacenar la categoría actual y evitar repetirla en la misma sección
        $currentCategory = '';

        // Iteramos sobre los resultados obtenidos de la consulta
        foreach ($result as $row) {
            // Si la categoría ha cambiado, mostramos el encabezado de la nueva categoría
            if ($currentCategory !== $row['categoria']) {
                if ($currentCategory !== '') {
                    echo '</div>'; // Cerramos el contenedor anterior
                }
                $currentCategory = $row['categoria']; // Actualizamos la categoría actual
                echo "<section id='{$currentCategory}' class='roadmap'>"; // Creamos una nueva sección para esta categoría
                echo "<h2>{$currentCategory}</h2>";
                echo "<p>{$row['descripcion']}</p>"; // Mostramos la descripción de la categoría
                echo "<div class='roadmap-subsection'><div class='roadmap-container'>"; // Iniciamos el contenedor de los elementos de esta categoría
            }
            // Mostramos el ítem utilizando el título como enlace
            $routeId = htmlspecialchars($row['id']); // Escapamos el ID
            $routeTitle = htmlspecialchars($row['titulo']); // Escapamos el título
            echo "<div class='roadmap-item'><a href='GameRoutes/Route.php?id={$routeId}'>{$routeTitle}</a></div>";
        } ?>
    </main>

    <!-- Incluimos el pie de página -->
    <?php include "./includes/template/Footer.php"; ?>

</body>

</html>