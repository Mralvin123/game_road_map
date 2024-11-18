<?php
require '../../includes/config/database.php'; // Archivo de conexión a la base de datos
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validación de campos vacíos
    if (empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $message = 'Por favor complete todos los campos.';
    } else {
        // Verificar que las contraseñas coincidan
        if ($password !== $confirm_password) {
            $message = 'Las contraseñas no coinciden.';
        } else {
            // Conectar a la base de datos
            $db = conectarDB();

            // Verificar si el correo ya está registrado
            $sql_check_email = "SELECT id_usuario FROM usuario WHERE email = ? LIMIT 1";
            $stmt_check_email = $db->prepare($sql_check_email);
            $stmt_check_email->bind_param("s", $email);
            $stmt_check_email->execute();
            $stmt_check_email->store_result();

            if ($stmt_check_email->num_rows > 0) {
                $message = 'El correo electrónico ya está registrado.';
            } else {
                // Verificar la complejidad de la contraseña (opcional)
                if (strlen($password) < 8) {
                    $message = 'La contraseña debe tener al menos 8 caracteres.';
                } else {
                    // Encriptar la contraseña
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Preparar y ejecutar la consulta de inserción
                    $sql = "INSERT INTO usuario (email, pasword, rol, estado) VALUES (?, ?, ?, 'activo')";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("sss", $email, $hashed_password, $role);

                    if ($stmt->execute()) {
                        $_SESSION['message'] = 'Registro exitoso, por favor inicie sesión.';
                        header("Location: login.php"); // Redirigir al login
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
<?php include "../../includes/template/Header.php";?>
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

            <div class="field">
                <select name="role" required>
                    <option value="admin">Administrador</option>
                    <option value="cliente">Cliente</option>
                </select>
            </div>

            <div class="btn">
                <button type="submit" class="button1">Registrarse</button>
                <a href="login.php" class="button2">Iniciar sesión</a>
            </div>
        </form>
    </div>
    <?php include "../../includes/template/Footer.php";?>
</body>
</html>
