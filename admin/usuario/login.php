<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/login.css">
    <title>Iniciar Sesión</title>
</head>
<body>
<?php
require '../../includes/config/database2.php'; // Archivo de conexión a la base de datos
session_start(); // Iniciar sesión
$message = ''; // Variable para almacenar mensajes de error o éxito

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        // Consulta SQL para buscar el usuario en la base de datos
        $sql = "SELECT Id_Usuario, Password, estado FROM usuario WHERE Email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $_POST['email']); // Vincular el correo ingresado
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener los datos del usuario

        // Validar usuario y contraseña
        if ($user && password_verify($_POST['password'], $user['Password'])) {
            if ($user['estado'] === 'activo') { // Verificar si el usuario está activo
                $_SESSION['user_id'] = $user['Id_Usuario']; // Guardar información en la sesión
                $_SESSION['loggedin'] = true;
                header("Location: ../../index.php"); // Redirigir a la página principal
                exit();
            } else {
                $message = 'Cuenta inactiva. Por favor, contacte al administrador.';
            }
        } else {
            $message = 'Correo o contraseña incorrectos. Intente de nuevo.';
        }
    } else {
        $message = 'Por favor, complete todos los campos.';
    }
}
?>
    <!-- Agrega el Header -->
    <?php include '../../includes/template/Header.php'; ?>

    <!-- Formulario de inicio de sesión -->
    <div>
        <div class="container">
            <form class="form" method="POST" action="login.php">
                <h1>Iniciar Sesión</h1>
                <!-- Mostrar mensaje de error si existe -->
                <?php if(!empty($message)): ?>
                    <p style="color: red;"><?= $message ?></p>
                <?php endif; ?>
                
                <!-- Campo para el correo -->
                <div class="field">
                    <input placeholder="Correo electrónico" class="input-field" type="email" name="email" required>
                </div>

                <!-- Campo para la contraseña -->
                <div class="field">
                    <input placeholder="Contraseña" class="input-field" type="password" name="password" required>
                </div>

                <!-- Botones para enviar el formulario o registrarse -->
                <div class="btn">
                    <button type="submit" class="button1">Iniciar Sesión</button>
                    <a href="./register.php" class="button2">Registrarse</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Agrega el Footer -->
    <?php include '../../includes/template/Footer.php'; ?>
</body>
</html>
