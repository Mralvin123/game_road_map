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

    <?php include "./includes/template/Header.php"; ?>

    <?php
    // Incluir la configuración de la base de datos para establecer la conexión con PDO
    include './includes/config/database.php';
    include './includes/config/database2.php';
    ?>

    <main>
        <section class="intro">
            <div class="intro-content">
                <h1>Compra Tu Paquete de Suscripción</h1>
                <p>Selecciona el nivel de suscripción que más te convenga y disfruta de los beneficios exclusivos.</p>
            </div>
        </section>

        <section class="products">
            <div class="products-container">
                <?php
                // Consulta para obtener los niveles de suscripción activos
                try {
                    $query = "SELECT * FROM `Nivel_de_Subscripcion` WHERE estado = 'activo'";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $levels = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenemos todos los niveles de suscripción

                    // Verificamos si hay niveles de suscripción
                    if ($levels) {
                        foreach ($levels as $level) {
                            $levelName = htmlspecialchars($level['nombre']); // Escapamos el nombre del nivel
                            $levelPrice = htmlspecialchars($level['costo']); // Escapamos el precio

                            // Mostramos cada nivel de suscripción en una tarjeta sin descripción
                            echo "<div class='product-card'>";
                            echo "<h2 class='product-title'>{$levelName}</h2>";
                            echo "<p class='product-price'>Precio: {$levelPrice} €</p>";
                            echo "<a href='#' class='buy-btn'>Comprar</a>"; // Enlace a la página de compra (puedes agregar lógica de compra aquí)
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
