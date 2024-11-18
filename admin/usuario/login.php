<?php
require '../../includes/config/database.php'; // Archivo de conexión a la base de datos
session_start();
$message = '';

if (isset($_SESSION['user_id'])) {
    // Si ya está logueado, redirigir al index.php
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = 'Por favor complete todos los campos.';
    } else {
        $db = conectarDB();
        // Consulta SQL ajustada para la columna "pasword"
        $sql = "SELECT id_usuario, pasword, estado, rol FROM usuario WHERE email = ? LIMIT 1"; // Aquí usamos "pasword"
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_usuario, $password_db, $estado, $rol);
            $stmt->fetch();

            // Verificar la contraseña con el hash almacenado en "pasword"
            if (password_verify($password, $password_db)) {
                if ($estado === 'activo') {
                    $_SESSION['user_id'] = $id_usuario;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_rol'] = $rol;
                    $_SESSION['loggedin'] = true;  // Esto marca al usuario como logueado
                    header("Location: index.php"); // Redirige a index.php
                    exit();  // Evita que el código siga ejecutándose después de la redirección
                } else {
                    $message = 'Cuenta inactiva. Por favor, contacte al administrador.';
                }
            } else {
                $message = 'Correo o contraseña incorrectos. Intente de nuevo.';
            }
        } else {
            $message = 'Correo o contraseña incorrectos. Intente de nuevo.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/login.css">
    <title>Iniciar sesión</title>
</head>
<?php include "../../includes/template/Header.php";?>
<body>
    <div class="container">
        <form class="form" method="POST" action="login.php">
            <h1>Iniciar sesión</h1>
            <?php if (!empty($message)): ?>
                <p style="color: red;"><?= $message ?></p>
            <?php endif; ?>

            <div class="field">
                <input placeholder="Correo electrónico" class="input-field" type="email" name="email" required>
            </div>

            <div class="field">
                <input placeholder="Contraseña" class="input-field" type="password" name="password" required>
            </div>

            <div class="btn">
                <button type="submit" class="button1">Iniciar sesión</button>
                <a href="register.php" class="button2">Registrarse</a>
            </div>
        </form>
    </div>
    <?php include "../../includes/template/Footer.php";?>
</body>
</html>
