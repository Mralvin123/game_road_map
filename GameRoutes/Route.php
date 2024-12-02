<?php
include '../includes/config/database.php';
include '../includes/config/database2.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $routeId = htmlspecialchars($_GET['id']);
    try {
        // Obtener la información principal de la ruta
        $routeQuery = "SELECT titulo, descripcion FROM ruta_de_estudio WHERE id = :id";
        $stmtRoute = $pdo->prepare($routeQuery);
        $stmtRoute->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmtRoute->execute();
        $route = $stmtRoute->fetch(PDO::FETCH_ASSOC);

        if (!$route) {
            die("Ruta no encontrada.");
        }

        // Obtener pasos del roadmap
        $stepsQuery = "SELECT * FROM paso WHERE id_Ruta = :id ORDER BY id";
        $stmtSteps = $pdo->prepare($stepsQuery);
        $stmtSteps->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmtSteps->execute();
        $steps = $stmtSteps->fetchAll(PDO::FETCH_ASSOC);

        // Reorganizar los pasos por ID
        $stepsById = [];
        foreach ($steps as $step) {
            $stepsById[$step['id']] = $step;
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
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
<?php include("../includes/template/Header.php")?>
<body>
    <header>
        <h1><?php echo htmlspecialchars($route['titulo']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($route['descripcion'])); ?></p>
    </header>

    <main>
        <section>
            <h2>Pasos del Roadmap</h2>
            <div class="roadmap-container">
                <?php
                // Renderizar pasos
                function renderSteps($currentStepId, $stepsById)
                {
                    if (!isset($stepsById[$currentStepId])) return;

                    $step = $stepsById[$currentStepId];
                    echo "<div class='step'>";
                    echo "<a href='#' class='step-link' data-id='" . $step['id'] . "'>";
                    echo "<h3>" . htmlspecialchars($step['titulo']) . "</h3>";
                    echo "</a>";
                    echo "</div>";

                    $nextSteps = array_filter($stepsById, fn($s) => $s['id_Paso_Previo'] == $currentStepId);
                    if (!empty($nextSteps)) {
                        echo "<div class='bifurcacion'>";
                        foreach ($nextSteps as $nextStep) {
                            renderSteps($nextStep['id'], $stepsById);
                        }
                        echo "</div>";
                    }
                }

                foreach ($steps as $step) {
                    if ($step['id_Paso_Previo'] === null) {
                        renderSteps($step['id'], $stepsById);
                        break;
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal-content" id="modalContent">
            <!-- Contenido cargado dinámicamente -->
        </div>
    </div>

    <script>
        // Abrir modal y cargar contenido
        document.querySelectorAll('.step-link').forEach(link => {
            link.addEventListener('click', async (e) => {
                e.preventDefault();
                const stepId = link.getAttribute('data-id');

                // Fetch contenido del overlay desde otro archivo
                const response = await fetch(`get_step_overlay.php?id=${stepId}`);
                const content = await response.text();

                // Insertar el contenido en el modal
                document.getElementById('modalContent').innerHTML = content;

                // Mostrar modal
                document.getElementById('modalOverlay').style.display = 'flex';

                // Añadir evento de cierre dinámicamente
                const closeBtn = document.getElementById('modalClose');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        document.getElementById('modalOverlay').style.display = 'none';
                    });
                }
            });
        });
        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('modalOverlay').addEventListener('click', (e) => {
            if (e.target === document.getElementById('modalOverlay')) {
                document.getElementById('modalOverlay').style.display = 'none';
            }
        });
    </script>
</body>
<?php include("../includes/template/Footer.php")?>
</html>