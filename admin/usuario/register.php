<?php
require '../../includes/config/database.php'; // Archivo de conexión a la base de datos
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($email) || empty($password) || empty($confirm_password)) {
        $message = 'Por favor complete todos los campos.';
    } else {
        if ($password !== $confirm_password) {
            $message = 'Las contraseñas no coinciden.';
        } else {
            $db = conectarDB();

            // Verificar si el correo electrónico ya está registrado
            $sql_check_email = "SELECT id FROM usuario WHERE email = ? LIMIT 1";
            $stmt_check_email = $db->prepare($sql_check_email);
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $stmt_check_email->store_result();

            if ($stmt_check_email->num_rows > 0) {
                $message = 'El correo electrónico ya está registrado.';
            } else {
                if (strlen($password) < 8) {
                    $message = 'La contraseña debe tener al menos 8 caracteres.';
                } else {
                    // Insertar el usuario con el rol 'Cliente' en la base de datos y valor predeterminado en id_nivel_subs
                    $sql = "INSERT INTO usuario (email, password, rol, estado, id_nivel_subs) VALUES (?, ?, 'Cliente', 'activo', 1)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("ss", $email, $password); // No hasheamos la contraseña

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
            }
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
                <input placeholder="Confirmar Contraseña" class="input-field" type="password" name="confirm_password" required>
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
