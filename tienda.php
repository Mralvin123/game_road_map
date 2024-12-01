<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Paquetes de Suscripción</title>
    <link rel="stylesheet" href="stylesheet/Header.css">
    <link rel="stylesheet" href="stylesheet/Footer.css">
    <link rel="stylesheet" href="stylesheet/tienda.css"> <!-- Archivo CSS específico para productos -->
</head>

<body>

    <!-- Incluimos el header -->
    <?php include "./includes/template/Header.php"; ?>

    <?php
    // Incluir la configuración de la base de datos para establecer la conexión con PDO
    include './includes/config/database.php';
    include './includes/config/database2.php';
    ?>

    <main>
        <!-- Sección de introducción -->
        <section class="intro">
            <div class="intro-content">
                <h1>Compra Tu Paquete de Suscripción</h1>
                <p>Selecciona el nivel de suscripción que más te convenga y disfruta de los beneficios exclusivos.</p>
            </div>
        </section>

        <!-- Sección de productos -->
        <section class="products">
            <div class="products-container">
                <?php
                try {
                    // Consulta para obtener los niveles de suscripción activos, incluyendo descripción
                    $query = "SELECT id, nombre, costo, descripcion FROM nivel_de_subscripcion WHERE estado = 'activo'";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $levels = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Verificamos si hay niveles de suscripción
                    if ($levels) {
                        foreach ($levels as $level) {
                            $levelId = htmlspecialchars($level['id']);
                            $levelName = htmlspecialchars($level['nombre']);
                            $levelPrice = number_format($level['costo'], 2); // Formato de precio
                            $levelDescription = htmlspecialchars($level['descripcion']); // Escapamos la descripción

                            // Mostramos cada nivel de suscripción en una tarjeta
                            echo "<div class='product-card'>";
                            echo "<h2 class='product-title'>{$levelName}</h2>";
                            echo "<p class='product-price'>Precio: {$levelPrice} €</p>";
                            echo "<p class='product-description'>{$levelDescription}</p>"; // Agregamos la descripción
                            echo "<a href='productos.php?id={$levelId}' class='buy-btn'>Comprar</a>"; // Enlace actualizado
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No hay niveles de suscripción disponibles en este momento.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Error al realizar la consulta: " . htmlspecialchars($e->getMessage()) . "</p>";
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
