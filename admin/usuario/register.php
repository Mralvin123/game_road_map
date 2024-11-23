<?php
require '../../includes/config/database.php'; // Archivo de conexión a la base de datos
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura de datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validación de campos vacíos
    if (empty($email) || empty($password) || empty($confirm_password)) {
        $message = 'Por favor complete todos los campos.';
    } else {
        // Validar si las contraseñas coinciden
        if ($password !== $confirm_password) {
            $message = 'Las contraseñas no coinciden.';
        } else {
            // Conectar a la base de datos
            $db = conectarDB();

            // Verificar si el email ya existe
            $sql_check_email = "SELECT id FROM usuario WHERE email = ? LIMIT 1";
            $stmt_check_email = $db->prepare($sql_check_email);
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $stmt_check_email->store_result();

            if ($stmt_check_email->num_rows > 0) {
                $message = 'El correo electrónico ya está registrado.';
            } else {
                // Encriptar la contraseña con md5
                $hashed_password = md5($password);

                // Insertar el nuevo usuario con rol Cliente, estado activo y nivel de suscripción 1
                $sql = "INSERT INTO usuario (email, password, rol, estado, id_nivel_subs) VALUES (?, ?, 'Cliente', 'activo', 1)";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("ss", $email, $hashed_password);

                if ($stmt->execute()) {
                    echo "<script>
                            alert('Registro exitoso. Por favor, inicie sesión.');
                            window.location.href = 'login.php';
                          </script>";
                    exit();
                } else {
                    $message = 'Hubo un error al registrar el usuario. Intente nuevamente.';
                }
            }

            $stmt_check_email->close();
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
    <title>Registro</title>
</head>
<?php include "../../includes/template/Header.php"; ?>
<body>
    <div class="container">
        <form class="form" method="POST" action="register.php">
            <h1>Registrarse</h1>
            <?php if (!empty($message)): ?>
                <p style="color: red;"><?= $message ?></p>
            <?php endif; ?>

            <div class="field">
                <input placeholder="Correo electrónico" class="input-field" type="email" name="email" required>
            </div>

            <div class="field">
                <input placeholder="Contraseña" class="input-field" type="password" name="password" required>
            </div>

            <div class="field">
                <input placeholder="Confirmar contraseña" class="input-field" type="password" name="confirm_password" required>
            </div>

            <div class="btn">
                <a href="login.php" class="button2">Iniciar sesión</a>
                <button type="submit" class="button1">Registrarse</button>
            </div>
        </form>
    </div>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
