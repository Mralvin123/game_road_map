<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../stylesheet/Header.css">
    <link rel="stylesheet" href="../stylesheet/Footer.css">
    <link rel="stylesheet" href="../stylesheet/indexadmin.css">
</head>
<body>
<?php
        include "../includes/template/Header.php";
    ?>
    <main class="contenedor seccion">
        <h1>Bienvenido</h1>
        <a href="./tablausu/listarusuarios.php" class="btn btn-primary"> Usuarios </a>
        <a href="./rutadeestudio/listarestudio.php" class="btn btn-warning"> Ruta de estudio </a>
        <a href="./pasos/listarpasos.php" class="btn btn-success"> pasos </a>
        <a href="./paquetes/listarsuscripciones.php" class="btn btn-info"> paquetes </a>
    </main>

    <?php
        include "../includes/template/Footer.php";
    ?>
</body>
</html>