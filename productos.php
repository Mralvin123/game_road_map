<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niveles de Suscripción - Roadmaps de Desarrollo de Videojuegos</title>
    <link rel="stylesheet" href="stylesheet/index.css">
    <link rel="stylesheet" href="stylesheet/Header.css">
    <link rel="stylesheet" href="stylesheet/Footer.css">
    <link rel="stylesheet" href="stylesheet/cards.css"> <!-- Agrega un nuevo archivo CSS para las cards -->
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
                <h1>Niveles de Suscripción</h1>
                <p>Explora nuestros niveles de suscripción y elige el que mejor se adapte a tus necesidades.</p>
            </div>
        </section>

        <section class="subscription-levels">
            <div class="levels-container">
                <?php
                // Realizamos la consulta para obtener los niveles de suscripción
                try {
                    $query = "SELECT * FROM `Nivel_de_Subscripcion`";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $levels = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenemos todos los niveles de suscripción

                    // Verificamos si hay niveles de suscripción
                    if ($levels) {
                        foreach ($levels as $level) {
                            $levelName = htmlspecialchars($level['nombre']); // Escapamos el nombre del nivel
                            $levelPrice = htmlspecialchars($level['costo']); // Escapamos el precio

                            // Mostramos cada nivel de suscripción en una tarjeta
                            echo "<div class='subscription-card'>";
                            echo "<h2 class='card-title'>{$levelName}</h2>";
                            echo "<p class='card-price'>Precio: {$levelPrice} €</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No hay niveles de suscripción disponibles en este momento.</p>";
                    }
                } catch (PDOException $e) {
                    echo "Error al realizar la consulta: " . $e->getMessage();
                    die();
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Incluimos el pie de página -->
    <?php include "./includes/template/Footer.php"; ?>

</body>

</html>