<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal - Roadmaps de Desarrollo de Videojuegos</title>
    <!-- Vinculamos los archivos CSS -->
    <link rel="stylesheet" href="stylesheet/index.css">
    <link rel="stylesheet" href="stylesheet/Header.css">
    <link rel="stylesheet" href="stylesheet/Footer.css">
</head>
<body>

    <!-- Incluimos el encabezado -->
    <?php include "./includes/template/Header.php"; ?>

    <!-- Contenido principal -->
    <main>
        <!-- Introducción -->
        <section class="intro">
            <div class="intro-content">
                <h1>Roadmaps de Desarrollo de Videojuegos</h1>
                <p>Descubre y sigue rutas de aprendizaje para convertirte en un experto en desarrollo de videojuegos. Ya sea en 2D o 3D, Unity, Godot, o Blender, ¡aquí encontrarás el camino hacia tu futuro como desarrollador de juegos!</p>
                <div class="buttons">
                    <a href="#unity" class="btn btn-primary">Unity</a>
                    <a href="#godot" class="btn btn-primary">Godot</a>
                    <a href="#art" class="btn btn-primary">Arte 3D</a>
                </div>
            </div>
        </section>

        <!-- Sección Unity -->
        <section id="unity" class="roadmap">
            <h2>Unity</h2>
            <p>Aprende a desarrollar juegos en Unity, uno de los motores más poderosos para crear juegos en 2D y 3D.</p>

            <!-- Sub-sección Unity 3D -->
            <div class="roadmap-subsection">
                <div class="roadmap-container">
                    <div class="roadmap-item">Unity 3D</div>
                    <div class="roadmap-item">Unity 2D</div>
                    <div class="roadmap-item">Game Design in Unity</div>
                    <div class="roadmap-item">UI Design in Unity</div>
                </div>
            </div>
        <!-- Sección Godot -->
        <section id="godot" class="roadmap">
            <h2>Godot</h2>
            <p>Explora el desarrollo de juegos con Godot, un motor open-source ideal tanto para proyectos en 2D como en 3D.</p>

            <!-- Sub-sección Godot 3D -->
            <div class="roadmap-subsection">
                <div class="roadmap-container">
                    <div class="roadmap-item">Godot 3D</div>
                    <div class="roadmap-item">Godot 2D</div>
                    <div class="roadmap-item">Game Design in Godot</div>
                    <div class="roadmap-item">UI Design in Godot</div>
                </div>
            </div>
        <!-- Sección Arte 3D -->
        <section id="art" class="roadmap">
            <h2>Arte 3D</h2>
            <p>Aprende a crear arte para videojuegos con herramientas como Blender y MagicaVoxel.</p>

            <!-- Sub-sección Blender -->
            <div class="roadmap-subsection">
                <div class="roadmap-container">
                    <div class="roadmap-item">MagicaVoxel</div>
                    <div class="roadmap-item">Blender</div>
                </div>
            </div>
        </section>
    </main>

    <!-- Incluimos el pie de página -->
    <?php include "./includes/template/Footer.php"; ?>

</body>
</html>
