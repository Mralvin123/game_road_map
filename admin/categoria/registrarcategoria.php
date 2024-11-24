<?php
// Conexión a la base de datos usando PDO
include '../../includes/config/database2.php'; // Usando PDO

// Verificar si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar que los campos no estén vacíos
    if (!empty($_POST['titulo']) && !empty($_POST['descripcion'])) {
        $titulo = htmlspecialchars($_POST['titulo']); // Sanitizar entrada
        $descripcion = htmlspecialchars($_POST['descripcion']); // Sanitizar entrada

        // Estado por defecto
        $estado = "activo";

        // Intentar insertar en la base de datos
        try {
            $query = "INSERT INTO categoria (Titulo, Descripcion, estado) VALUES (:titulo, :descripcion, :estado)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':estado', $estado);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Categoría registrada exitosamente.');
                        window.location.href = '../index.php'; // Redirigir al index
                      </script>";
            } else {
                echo "<script>alert('Error al registrar la categoría.');</script>";
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Categoría</title>
    <link rel="stylesheet" href="../../stylesheet/registrar.css">
</head>
<body>
    <?php include '../../includes/template/Header.php'; ?>
    <main>
        <h1>Registrar Nueva Categoría</h1>
        <form method="POST" class="formulario">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Nombre de la categoría" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción breve de la categoría" required></textarea>

            <input type="submit" value="Registrar Categoría" class="boton">
        </form>
    </main>
    <?php include '../../includes/template/Footer.php'; ?>
</body>
</html>
