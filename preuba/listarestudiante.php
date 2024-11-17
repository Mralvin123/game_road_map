<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main class="contenedor seccion">
        <h1>Lista de Estudiantes</h1>
        <a href="../index.php" class="boton boton-verde">Volver</a>
        <table class="table table-success table-striped">
            <thead>
                <th>Nombre</th>
                <th>Paterno</th>
                <th>Materno</th>
                <th>ID Curso</th>
            </thead>
            <tbody>
                <?php
                    include "../config/database.php";
                    $db = conectarDB();
                    $consql = "SELECT * FROM estudiante";
                    $res = mysqli_query($db, $consql);
                    while($reg = mysqli_fetch_array($res)) {
                        echo "<tr>";
                        echo "<td> ".$reg['nombre']."</td>";
                        echo "<td> ".$reg['paterno']."</td>";
                        echo "<td> ".$reg['materno']."</td>";
                        echo "<td> ".$reg['idcurso']."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <a href="crear.php" class="boton boton-amarillo">Registrar Estudiante</a>
    </main>

</body>
</html>
