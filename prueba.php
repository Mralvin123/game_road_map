// Verificar si el usuario está autenticado y tiene el rol de "Administrador"
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Administrador') {
        // Si no está autenticado o no es administrador, redirigir a la página de inicio de sesión
        header("Location: /dencel/cine/login.php");
        exit; // Termina el script para evitar la ejecución de código posterior
    }

    // Incluir el archivo de encabezado
    include "../../includes/templates/header.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CINE FLUX</title>
</head>
<body>
<header class="uc-header">
  <nav class="uc-navbar">
    <!-- Menú para versión Escritorio -->
    <div class="container d-none d-lg-block">
      <div class="row">
        <div class="col-lg-3">
          <a href="/dencel/cine/index.php">
          <img
            src="/dencel/cine/build/imagenes/logofinal.png"
            alt="Logo"
            class="img-fluid"
          />
          </a>
        </div>
        <div class="col-lg-9">
          <ul class="uc-navbar_nav">
            <li class="nav-item">
              <a href="#" class="uc-btn btn-inline">Cartelera</a>
            </li>
            <li class="nav-item">
              <a href="" class="uc-btn btn-inline">Sobre Nosotros</a>
            </li>
            <li class="nav-item">
              <a href="" class="uc-btn btn-inline">Contactanos</a>
            </li>
            <li class="nav-item">
              <a href="#" class="uc-btn btn-inline">Reseñas</a>
            </li>
            <?php 
              if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) { ?>
                <li class="nav-item">
                  <a href="" class="uc-btn btn-inline">Iniciar Sesion</a>
                </li>
              <?php 
                } else { ?>
                <li class="nav-item">
                  <a href="" class="uc-btn btn-inline">Cerrar Sesion</a>
                </li>
                <li class="nav-item">
                  <a href="" class="uc-btn btn-inline">Administrador</a>
                </li>
              <?php 
              } ?>
          </ul>
        </div>
      </div>
    </div>
    <!-- Menú para versión Móvil -->
    <div class="uc-navbar_mobile d-block d-lg-none">
      <div class="uc-navbar_mobile-bar navbar-brand">
        <div class="uc-navbar_mobile-logo navbar-light">
        <a href="/dencel/cine/index.php">
          <img
            src="/dencel/cine/build/imagenes/logofinal.png"
            alt="Logo"
            class="img-fluid"
          />
          </a>
        </div>
        <a
          href="javascript:void(0);"
          class="uc-navbar_mobile-button"
          data-collapse="collapseMobileNav1"
        >
          <span class="uc-icon"></span>
          Menú
        </a>
      </div>
      <div
        class="uc-navbar_mobile-content"
        data-toggle="collapseMobileNav1"
        data-open="false"
        style="height: 0"
      >
        <div class="uc-navbar_mobile-list">
          <a href="#" class="list-item">cartelera</a>
          <a href="/dencel/cine/nosotros.php" class="list-item">Sobre Nosotros</a>
          <a href="/dencel/cine/contactanos.php" class="list-item">Contactanos</a>
          <a href="#" class="list-item">Reseñas</a>
            <?php 
            if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) { ?>
                <a href="/dencel/cine/login.php" class="list-item">Iniciar Sesion</a>
            <?php 
            } else { ?>
                <a href="/dencel/cine/admin/cerrarsesion.php" class="list-item">Cerrar sesion</a>
                <a href="/dencel/cine/admin/index.php" class="list-item">Administrador</a>
            <?php 
            } ?>
        </div>
      </div>
    </div>
  </nav>
</header>

<main class="contenedor section">
    <h1>Bienvenido al Panel de Administrador</h1>
    <!-- Contenido de la página de administración -->
</main>  

<?php
    // Incluir el archivo de pie de página
    include "../../includes/templates/footer.php";
?>
</body>
</html>