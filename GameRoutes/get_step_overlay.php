<?php
include '../includes/config/database.php';
include '../includes/config/database2.php';

session_start(); // Iniciar sesión para acceder al usuario logueado

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo "<p>Error: Usuario no autenticado.</p>";
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $stepId = htmlspecialchars($_GET['id']);
    $userId = $_SESSION['user_id']; // Obtener el ID del usuario logueado

    try {
        // Obtener datos del paso
        $queryStep = "SELECT titulo, descripcion FROM paso WHERE id = ?";
        $stmtStep = $pdo->prepare($queryStep);
        $stmtStep->execute([$stepId]);

        if ($stmtStep->rowCount() > 0) {
            $step = $stmtStep->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "<p>Error: Paso no encontrado.</p>";
            exit;
        }

        // Obtener recursos adicionales
        $queryResources = "
            SELECT r.titulo, r.url, t.nombre AS tipo
            FROM recurso r 
            JOIN tipo t ON r.id_Tipo = t.id
            WHERE r.id_Paso = ?
        ";
        $stmtResources = $pdo->prepare($queryResources);
        $stmtResources->execute([$stepId]);
        $resources = $stmtResources->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si el paso está completado por el usuario
        $queryUserStep = "
            SELECT 1 FROM usuario_paso WHERE id_Usuario = ? AND id_Paso = ?
        ";
        $stmtUserStep = $pdo->prepare($queryUserStep);
        $stmtUserStep->execute([$userId, $stepId]);

        $isCompleted = $stmtUserStep->rowCount() > 0 ? 'completed' : 'incomplete';

        // Generar contenido del modal
        echo "<span class='modal-close' id='modalClose'>&times;</span>";
        echo "<h2>" . htmlspecialchars($step['titulo']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($step['descripcion'])) . "</p>";

        if (!empty($resources)) {
            echo "<h3>Recursos Adicionales</h3>";
            echo "<ul>";
            foreach ($resources as $resource) {
                echo "<li><a href='" . htmlspecialchars($resource['url']) . "' target='_blank'>" . htmlspecialchars($resource['titulo']) . " (" . htmlspecialchars($resource['tipo']) . ")</a></li>";
            }
            echo "</ul>";
        }

        // Mostrar el estado del paso y el dropdown para cambiar el estado
        echo "<h3>Estado del paso</h3>";
        echo "<form id='stepForm' method='POST'>";
        echo "<label for='stepStatus'>Estado: </label>";
        echo "<select name='stepStatus' id='stepStatus' onchange='this.form.submit()'>";
        echo "<option value='incomplete'" . ($isCompleted == 'incomplete' ? " selected" : "") . ">Incompleto</option>";
        echo "<option value='completed'" . ($isCompleted == 'completed' ? " selected" : "") . ">Completado</option>";
        echo "</select>";
        echo "</form>";

        // Cambiar el estado del paso mediante una consulta al enviar el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stepStatus'])) {
            $newStatus = $_POST['stepStatus'];

            if ($newStatus == 'completed') {
                // Verificar si el paso ya ha sido completado por el usuario
                $queryCheck = "SELECT * FROM usuario_paso WHERE id_Usuario = ? AND id_Paso = ?";
                $stmtCheck = $pdo->prepare($queryCheck);
                $stmtCheck->execute([$userId, $stepId]);

                // Si no existe, realizar la inserción
                if ($stmtCheck->rowCount() == 0) {
                    $queryInsert = "INSERT INTO usuario_paso (id_Usuario, id_Paso) VALUES (?, ?)";
                    $stmtInsert = $pdo->prepare($queryInsert);
                    $stmtInsert->execute([$userId, $stepId]);
                    echo "<p>Estado actualizado a 'Completado'.</p>";
                } else {
                    echo "<p>El paso ya ha sido marcado como completado.</p>";
                }
            } elseif ($newStatus == 'incomplete') {
                // Eliminar el registro en la tabla usuario_paso si el paso es marcado como incompleto
                $queryDelete = "DELETE FROM usuario_paso WHERE id_Usuario = ? AND id_Paso = ?";
                $stmtDelete = $pdo->prepare($queryDelete);
                $stmtDelete->execute([$userId, $stepId]);
                echo "<p>Estado actualizado a 'Incompleto'.</p>";
            }

            // Recargar la página para reflejar el cambio de estado
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>Error: ID no especificado.</p>";
}
?>
