<?php
// Incluir la configuración de la base de datos para establecer la conexión con PDO
include '../includes/config/database.php';
include '../includes/config/database2.php';

// Verificar si se ha pasado el parámetro 'id' en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $routeId = htmlspecialchars($_GET['id']); // Escapamos el ID para evitar inyecciones

    try {
        // Realizamos la consulta para obtener la ruta de estudio según el ID
        $query = "SELECT titulo, descripcion FROM ruta_de_estudio WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $routeId, PDO::PARAM_INT); // Vinculamos el parámetro
        $stmt->execute();

        // Verificamos si se encontró alguna ruta
        if ($stmt->rowCount() > 0) {
            $route = $stmt->fetch(PDO::FETCH_ASSOC); // Obtenemos la ruta como un array asociativo
        } else {
            echo "No se encontró la ruta de estudio.";
            exit;
        }

        // Consulta para obtener los pasos de la ruta de estudio
        $querySteps = "SELECT id, titulo, descripcion, id_Paso_Previo FROM paso WHERE id_Ruta = :id";
        $stmtSteps = $pdo->prepare($querySteps);
        $stmtSteps->bindParam(':id', $routeId, PDO::PARAM_INT); // Vinculamos el parámetro
        $stmtSteps->execute();
        
        // Almacenamos los pasos en un array
        $steps = $stmtSteps->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error al realizar la consulta: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID no especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($route['titulo']); ?> - Ruta de Estudio</title>
    <link rel="stylesheet" href="../stylesheet/Header.css">
    <link rel="stylesheet" href="../stylesheet/Footer.css">
    <link rel="stylesheet" href="../stylesheet/roadmap.css"> <!-- Estilo específico para el roadmap -->
</head>
<body>

    <?php include "../includes/template/Header.php"; ?>

    <main>
        <section>
            <h2>Ruta de Estudio: <?php echo htmlspecialchars($route['titulo']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($route['descripcion'])); ?></p> <!-- nl2br para mantener saltos de línea -->
        </section>

        <section class="roadmap">
            <h2>Pasos del Roadmap</h2>
            <div class="roadmap-container">
                <?php
                // Crear un array para almacenar pasos por ID
                $stepsById = [];
                foreach ($steps as $step) {
                    $stepsById[$step['id']] = $step; // Almacenar pasos por ID
                }

                // Función para mostrar pasos con bifurcaciones
                function displaySteps($currentStepId, $stepsById) {
                    if (!isset($stepsById[$currentStepId])) {
                        return; // Si no existe el paso, salir
                    }

                    $step = $stepsById[$currentStepId];
                    echo "<div class='step'>";
                    echo "<h3>" . htmlspecialchars($step['titulo']) . "</h3>";
                    echo "<p>" . nl2br(htmlspecialchars($step['descripcion'])) . "</p>";
                    echo "</div>";

                    // Mostrar pasos previos
                    $nextSteps = array_filter($stepsById, function($s) use ($currentStepId) {
                        return $s['id_Paso_Previo'] == $currentStepId;
                    });

                    // Si hay pasos siguientes, mostrarlos
                    if (!empty($nextSteps)) {
                        echo "<div class='bifurcacion'>";
                        foreach ($nextSteps as $nextStep) {
                            displaySteps($nextStep['id'], $stepsById);
                        }
                        echo "</div>";
                    }
                }

                // Encontrar el paso inicial (donde id_Paso_Previo es null)
                foreach ($steps as $step) {
                    if ($step['id_Paso_Previo'] === null) {
                        displaySteps($step['id'], $stepsById);
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Incluimos el pie de página -->
    <?php include "../includes/template/Footer.php"; ?>  

</body>
</html>
