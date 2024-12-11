<?php
include '../includes/config/database.php';
include '../includes/config/database2.php';

session_start(); // Iniciar sesión para acceder al usuario logueado

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo "<p>Error: Usuario no autenticado.</p>";
    exit;
}

// Validar sdi se recibió el parámetro 'id'
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $stepId = htmlspecialchars($_GET['id']); // Escapar el valor para seguridad
    $userId = $_SESSION['user_id']; // ID del usuario logueado

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

        // Obtener el nivel de suscripción del usuario
        $queryUserSub = "
            SELECT n.costo 
            FROM usuario u
            JOIN nivel_de_subscripcion n ON u.id_nivel_subs = n.id
            WHERE u.id = ?
        ";
        $stmtUserSub = $pdo->prepare($queryUserSub);
        $stmtUserSub->execute([$userId]);

        if ($stmtUserSub->rowCount() > 0) {
            $userSub = $stmtUserSub->fetch(PDO::FETCH_ASSOC)['costo'];
        } else {
            echo "<p>Error: Nivel de suscripción del usuario no encontrado.</p>";
            exit;
        }

        // Obtener recursos adicionales con validación de nivel de suscripción
        $queryResources = "
            SELECT r.titulo, r.url, t.nombre AS tipo, n.costo AS recursoCosto, n.nombre as costo
            FROM recurso r 
            JOIN tipo t ON r.id_Tipo = t.id
            JOIN nivel_de_subscripcion n ON r.id_Nivel_Subs = n.id
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
                if ($userSub >= $resource['recursoCosto']) {
                    echo "<li><a href='" . htmlspecialchars($resource['url']) . "' target='_blank'>" . htmlspecialchars($resource['titulo']) . " (" . htmlspecialchars($resource['tipo']) . ")</a></li>";
                } else {
                    echo "<li> <em> recurso para usaurios con el " . htmlspecialchars($resource['costo']) . " para arriba</em></li>";
                }
            }
            echo "</ul>";
        }

        // Mostrar el estado del paso con enlaces a las páginas de creación y eliminación
        echo "<h3>Estado del paso</h3>";
        echo "<p>Estado actual: <strong>" . ($isCompleted == 'completed' ? 'Completado' : 'Incompleto') . "</strong></p>";

        if ($isCompleted == 'incomplete') {
            echo "<a href='crearPaso.php?id=" . urlencode($stepId) . "' class='btn-complete'>Marcar como Completado</a>";
        } else {
            echo "<a href='eliminarPaso.php?id=" . urlencode($stepId) . "' class='btn-incomplete'>Marcar como Incompleto</a>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>Error: ID no especificado.</p>";
}
?>