<?php
require '../../includes/config/database.php'; // Conexión a la base de datos
session_start();

$email_error = '';
$password_error = '';
$message = '';

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: ../index.php"); // Redirigir si ya está logueado
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar campos vacíos
    if (empty($email)) {
        $email_error = 'El correo electrónico es obligatorio.';
    }
    if (empty($password)) {
        $password_error = 'La contraseña es obligatoria.';
    }

    if (empty($email_error) && empty($password_error)) {
        $db = conectarDB();

        $sql = "SELECT id, password, estado FROM usuario WHERE email = ? LIMIT 1";
        $stmt = $db->prepare($sql);

        if (!$stmt) {
            die("Error en la consulta: " . $db->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_usuario, $password_db, $estado);
            $stmt->fetch();

            // Verificar el estado del usuario
            if ($estado !== 'activo') {
                $email_error = 'El usuario no está activo.';
            } elseif ($password === $password_db) { // Comparación directa de contraseñas
                // Configurar variables de sesión
                $_SESSION['login'] = true; // Indicador de inicio de sesión
                $_SESSION['user_id'] = $id_usuario;
                $_SESSION['user_email'] = $email;

                // Redirigir al index
                header("Location: ../../index.php");
                exit();
            } else {
                $password_error = 'La contraseña es incorrecta.';
            }
        } else {
            $email_error = 'El correo electrónico no está registrado.';
        }

        $stmt->close();
        $db->close();
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
<?php include "../../includes/template/Header.php"; ?>
<body>
    <div class="container">
        <form class="form" method="POST" action="login.php">
            <h1>Iniciar sesión</h1>

            <div class="field">
                <input placeholder="Correo electrónico" class="input-field" type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                <?php if (!empty($email_error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($email_error) ?></p>
                <?php endif; ?>
            </div>

            <div class="field">
                <input placeholder="Contraseña" class="input-field" type="password" name="password" required>
                <?php if (!empty($password_error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($password_error) ?></p>
                <?php endif; ?>
            </div>

            <div class="btn">
                <a href="register.php" class="button2">Registrarse</a>
                <button type="submit" class="button1">Iniciar sesión</button>
            </div>
        </form>
    </div>
    <?php include "../../includes/template/Footer.php"; ?>
</body>
</html>
