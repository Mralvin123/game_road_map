<?php
 $auth=$_SESSION['login'];
    if (!$auth) {
        header('Location: /game_road');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>
    
</body>
<?php
 $inicio=false;
    include "../includes/template/Header.php";
?>
    <main class="contenedor seccion">
        <h1>Bienvenido</h1>
        <a href="./vendedores/listarVendedor.php" class="boton boton-verde"> Vendedores </a>
        <a href="./propiedades/listarPropiedades.php" class="boton boton-amarillo"> Propiedades </a>
        <a href="./controlador/usuarioLista.php" class="boton boton-verde"> Usuarios </a>
    </main>

<?php
    include "../includes/template/Footer.php";
?>
</html>