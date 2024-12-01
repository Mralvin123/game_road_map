<?php
session_start();

// Verificar si el usuario está logueado y si tiene el rol de Administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    // Si no está logueado o no es un administrador, redirigir a la página de inicio o login
    header('Location: ../login.php');
    exit();
}
?>

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
<a href="./categoria/listarcategoria.php" class="btn btn-dark"> Categoria </a>
<a href="./rutadeestudio/listarestudio.php" class="btn btn-warning"> Ruta de estudio </a>
<a href="./pasos/listarpasos.php" class="btn btn-success"> Pasos </a>
<a href="./paquetes/listarsuscripciones.php" class="btn btn-info"> Paquetes </a>
<a href="./recursosextra/listarrecurso.php" class="btn btn-secondary"> Recursos Extra </a>

    </main>

<?php
    include "../includes/template/Footer.php";
?>
</body>
</html>
