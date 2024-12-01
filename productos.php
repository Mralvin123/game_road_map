<?php
include './includes/config/database.php';
include './includes/config/database2.php';

// Iniciar sesión para comprobar si el usuario está logueado
session_start();

// Verificar que el parámetro 'id' esté presente
if (!isset($_GET['id'])) {
    die("Error: El parámetro 'id' no está definido.");
}

// Obtener el valor de 'id' del producto
$idProducto = $_GET['id'];

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Si no está logueado, mostrar un mensaje
    echo "<p>Debes iniciar sesión para realizar la compra.</p>";
    exit();
} else {
    $usuarioId = $_SESSION['user_id'];  // ID del usuario logueado
}

// Intentar obtener los detalles del producto
try {
    // Consulta para obtener los detalles del paquete de suscripción seleccionado
    $query = "SELECT id, nombre, costo, descripcion FROM nivel_de_subscripcion WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idProducto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el producto existe
    if (!$producto) {
        die("Error: Producto no encontrado.");
    }

    // Asignar variables para usar en el HTML
    $nombre = htmlspecialchars($producto['nombre']);
    $costo = number_format($producto['costo'], 2);
    $descripcion = htmlspecialchars($producto['descripcion']);

    // Si el formulario fue enviado (es decir, el usuario confirmó la compra)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validar el método de pago
        if (!isset($_POST['metodo_pago']) || $_POST['metodo_pago'] != 'paypal') {
            echo "<p>Debes seleccionar PayPal como método de pago.</p>";
            exit();
        }

        // Obtener el correo de PayPal
        $paypalEmail = $_POST['paypal_email'] ?? null;

        if (empty($paypalEmail)) {
            echo "<p>Por favor, ingresa tu correo de PayPal.</p>";
            exit();
        }

        // Aquí procesarías el pago con PayPal (simulación o integración real)
        echo "<script>alert('¡Pago con PayPal procesado correctamente!');</script>";

        // Redirigir a la página principal después de procesar el pago con PayPal
        echo "<script>
            window.location.href = 'index.php'; // Página de confirmación después del pago
        </script>";
        exit(); // Aseguramos que no continúe el procesamiento después de la redirección
    }

} catch (PDOException $e) {
    echo "<p>Error al obtener los datos del producto: " . htmlspecialchars($e->getMessage()) . "</p>";
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto - <?php echo $nombre; ?></title>
    <link rel="stylesheet" href="stylesheet/Header.css">
    <link rel="stylesheet" href="stylesheet/Footer.css">
    <link rel="stylesheet" href="stylesheet/productos.css"> <!-- Archivo CSS específico para productos -->
</head>

<body>
    <!-- Incluimos el header -->
    <?php include "./includes/template/Header.php"; ?>

    <main>
        <section class="product-details">
            <h1><?php echo $nombre; ?></h1>
            <p><strong>Precio:</strong> <?php echo $costo; ?> €</p>
            <p><strong>Descripción:</strong> <?php echo $descripcion; ?></p>

            <!-- Formulario para seleccionar el método de pago antes de confirmar la compra -->
            <section class="payment-form">
                <h2>Selecciona el método de pago:</h2>
                <form action="productos.php?id=<?php echo $idProducto; ?>" method="post">
                    <div class="payment-options">
                        <label>
                            <input type="radio" name="metodo_pago" value="paypal" required> Pago con PayPal
                        </label>
                    </div>

                    <!-- Campos para el pago con PayPal -->
                    <div id="paypalFields">
                        <label for="paypal_email">Correo electrónico de PayPal:</label>
                        <input type="email" id="paypal_email" name="paypal_email" placeholder="tuemail@paypal.com" required>
                    </div>

                    <!-- Formulario para confirmar la compra -->
                    <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
                    <input type="hidden" name="precio" value="<?php echo $costo; ?>">
                    <input type="submit" value="Confirmar Compra" class="buy-btn">
                </form>
            </section>
        </section>
    </main>

    <!-- Incluimos el pie de página -->
    <?php include "./includes/template/Footer.php"; ?>
</body>

</html>
