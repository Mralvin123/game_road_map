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
                <h3>Unity 3D</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">C#</div>
                    <div class="roadmap-item">Unity Basics</div>
                    <div class="roadmap-item">Physics & Collisions</div>
                    <div class="roadmap-item">3D Graphics</div>
                    <div class="roadmap-item">Animations</div>
                    <div class="roadmap-item">AI and Pathfinding</div>
                </div>
            </div>

            <!-- Sub-sección Unity 2D -->
            <div class="roadmap-subsection">
                <h3>Unity 2D</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">Unity 2D Tools</div>
                    <div class="roadmap-item">Sprites & Animations</div>
                    <div class="roadmap-item">2D Physics</div>
                    <div class="roadmap-item">Tilemaps</div>
                    <div class="roadmap-item">Camera System</div>
                    <div class="roadmap-item">UI Design</div>
                </div>
            </div>

            <!-- Sub-sección Game Design en Unity -->
            <div class="roadmap-subsection">
                <h3>Game Design en Unity</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">Game Mechanics</div>
                    <div class="roadmap-item">Level Design</div>
                    <div class="roadmap-item">Prototyping</div>
                    <div class="roadmap-item">Player Experience</div>
                </div>
            </div>

            <!-- Sub-sección UI Design en Unity -->
            <div class="roadmap-subsection">
                <h3>UI Design en Unity</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">UI Layout</div>
                    <div class="roadmap-item">Navigation</div>
                    <div class="roadmap-item">Responsive Design</div>
                    <div class="roadmap-item">Animation</div>
                </div>
            </div>
        </section>

        <!-- Sección Godot -->
        <section id="godot" class="roadmap">
            <h2>Godot</h2>
            <p>Explora el desarrollo de juegos con Godot, un motor open-source ideal tanto para proyectos en 2D como en 3D.</p>

            <!-- Sub-sección Godot 3D -->
            <div class="roadmap-subsection">
                <h3>Godot 3D</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">GDScript</div>
                    <div class="roadmap-item">3D Scenes</div>
                    <div class="roadmap-item">Physics</div>
                    <div class="roadmap-item">Lighting and Shadows</div>
                    <div class="roadmap-item">3D Animation</div>
                    <div class="roadmap-item">Multiplayer</div>
                </div>
            </div>

            <!-- Sub-sección Godot 2D -->
            <div class="roadmap-subsection">
                <h3>Godot 2D</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">2D Tools</div>
                    <div class="roadmap-item">Tilemaps</div>
                    <div class="roadmap-item">2D Physics</div>
                    <div class="roadmap-item">Shaders</div>
                    <div class="roadmap-item">Player Input</div>
                    <div class="roadmap-item">UI and Menus</div>
                </div>
            </div>

            <!-- Sub-sección Game Design en Godot -->
            <div class="roadmap-subsection">
                <h3>Game Design en Godot</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">Game Mechanics</div>
                    <div class="roadmap-item">Level Design</div>
                    <div class="roadmap-item">Prototyping</div>
                    <div class="roadmap-item">Player Experience</div>
                </div>
            </div>

            <!-- Sub-sección UI Design en Godot -->
            <div class="roadmap-subsection">
                <h3>UI Design en Godot</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">UI Layout</div>
                    <div class="roadmap-item">Navigation</div>
                    <div class="roadmap-item">Responsive Design</div>
                    <div class="roadmap-item">Animation</div>
                </div>
            </div>
        </section>

        <!-- Sección Arte 3D -->
        <section id="art" class="roadmap">
            <h2>Arte 3D</h2>
            <p>Aprende a crear arte para videojuegos con herramientas como Blender y MagicaVoxel.</p>

            <!-- Sub-sección Blender -->
            <div class="roadmap-subsection">
                <h3>Blender</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">Modelado 3D</div>
                    <div class="roadmap-item">Texturizado</div>
                    <div class="roadmap-item">Rigging</div>
                    <div class="roadmap-item">Animación 3D</div>
                    <div class="roadmap-item">Sculpting</div>
                    <div class="roadmap-item">Exportación a Unity</div>
                </div>
            </div>

            <!-- Sub-sección MagicaVoxel -->
            <div class="roadmap-subsection">
                <h3>MagicaVoxel</h3>
                <div class="roadmap-container">
                    <div class="roadmap-item">Modelado Voxels</div>
                    <div class="roadmap-item">Texturización</div>
                    <div class="roadmap-item">Animaciones Voxels</div>
                    <div class="roadmap-item">Exportación a Unity</div>
                </div>
            </div>
        </section>
    </main>

    <!-- Incluimos el pie de página -->
    <?php include "./includes/template/Footer.php"; ?>

</body>
</html>
