<?php
include "../includes/config/database2.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Error: Usuario no autenticado.');
            window.history.back();
          </script>";
    exit;
}

// Validar si se recibió el parámetro 'id'
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>
            alert('Error: ID no especificado.');
            window.history.back();
          </script>";
    exit;
}

try {
    // Obtener valores
    $userId = $_SESSION['user_id'];
    $stepId = htmlspecialchars($_GET['id']); // Escapar para seguridad

    // Obtener id_Ruta relacionado con el paso
    $queryRoute = "SELECT id_Ruta FROM paso WHERE id = ?";
    $stmtRoute = $pdo->prepare($queryRoute);
    $stmtRoute->execute([$stepId]);

    if ($stmtRoute->rowCount() > 0) {
        $route = $stmtRoute->fetch(PDO::FETCH_ASSOC);
        $routeId = $route['id_Ruta']; // Obtener el id_Ruta
    } else {
        echo "<script>
                alert('Error: Paso no encontrado o no tiene ruta asociada.');
                window.history.back();
              </script>";
        exit;
    }

    // Verificar si existe el registro en usuario_ruta_estudio
    $queryCheckUserRoute = "SELECT * FROM usuario_ruta_estudio WHERE id_Usuario = ? AND id_Ruta_Estudio = ?";
    $stmtCheckUserRoute = $pdo->prepare($queryCheckUserRoute);
    $stmtCheckUserRoute->execute([$userId, $routeId]);

    if ($stmtCheckUserRoute->rowCount() == 0) {
        // Registrar en usuario_ruta_estudio si no existe
        $queryInsertUserRoute = "INSERT INTO usuario_ruta_estudio (id_Usuario, id_Ruta_Estudio) VALUES (?, ?)";
        $stmtInsertUserRoute = $pdo->prepare($queryInsertUserRoute);
        $stmtInsertUserRoute->execute([$userId, $routeId]);
    }

    // Conectar a la base de datos para insertar el paso del usuario
    $query = "INSERT INTO usuario_paso (id_Usuario, id_Paso) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);

    // Ejecutar consulta
    $stmt->execute([$userId, $stepId]);

    echo "<script>
            alert('Paso marcado como completado.');
            window.location.href = 'Route.php?id=" . htmlspecialchars($routeId) . "';
          </script>";
} catch (PDOException $e) {
    echo "<script>
            alert('Error: " . htmlspecialchars($e->getMessage()) . "');
            window.history.back();
          </script>";
}
?>