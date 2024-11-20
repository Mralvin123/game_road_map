<?php
session_start();

// Verificar si la sesión está activa
if (isset($_SESSION['loggedin'])) {
    // Limpiar todas las variables de sesión
    $_SESSION = [];

    // Eliminar la cookie de sesión si está configurada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"] ?? '/',
            $params["domain"] ?? '',
            $params["secure"] ?? false,
            $params["httponly"] ?? false
        );
    }

    // Destruir la sesión
    session_destroy();
}

// Redirigir al usuario a la página de inicio
header("Location: ../../index.php");
exit();
?>
