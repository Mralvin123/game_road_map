<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../stylesheet/login.css">
    <title>Registrarse</title>
</head>
<body>
<?php
require '../../includes/config/database2.php';
session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        // Verificar si las contraseñas coinciden
        if ($_POST['password'] === $_POST['confirm_password']) {
            // Verificar si el email ya está registrado
            $sql = "SELECT Id_Usuario FROM usuario WHERE Email = :email LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->execute();
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<script>alert('El correo electrónico ya está registrado.');</script>";
            } else {
                // Preparar y ejecutar la consulta para registrar el usuario
                $sql = "INSERT INTO usuario (Email, Password, estado) VALUES (:email, :password, 'activo')";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $_POST['email']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password);
                if ($stmt->execute()) {
                    // Mostrar modal de éxito
                    echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modal = document.getElementById('successModal');
                            modal.style.display = 'flex';
                        });
                    </script>";
                } else {
                    echo "<script>alert('Lo siento, hubo un error al crear la cuenta.');</script>";
                }
            }
        } else {
            echo "<script>alert('Las contraseñas no coinciden. Por favor, intente nuevamente.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos.');</script>";
    }
}
?>
    <!-- Agrega Header -->
    <?php include '../../includes/template/Header.php'; ?>

    <div style="background-image: url('./imagenes/login.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <form class="form" method="POST" action="register.php">
                <h1>Registrarse</h1>
                
                <div class="field">
                    <input placeholder="Correo electrónico" class="input-field" type="email" name="email" required>
                </div>        
                <div class="field">
                    <input placeholder="Contraseña" class="input-field" type="password" name="password" required>
                </div>
                <div class="field">
                    <input placeholder="Confirma tu Contraseña" class="input-field" type="password" name="confirm_password" required>
                </div>

                <div class="btn">
                    <button type="submit" class="button1">Registrarse</button>
                    <a href="./login.php" class="button2">Iniciar sesión</a>
                </div>

            </form>
        </div>
    </div>
    <!-- Ventana modal de éxito -->
    <div id="successModal" class="modal" style="display: none;">
        <div class="modal-content">
            <p>Usuario creado satisfactoriamente.</p>
            <button onclick="redirectToIndex()">Aceptar</button>
        </div>
    </div>
    <!-- Script para redirigir a login.php al cerrar el modal -->
    <script>
        function redirectToIndex() {
            window.location.href = './login.php';
        }
    </script>
    <!-- Agrega el Footer -->
    <?php include '../../includes/template/Footer.php'; ?>
</body>
</html>
