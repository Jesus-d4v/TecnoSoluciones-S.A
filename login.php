<?php
session_start();
include 'includes/database.php';

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (!empty($usuario) && !empty($password)) {
        $stmt = $conn->prepare("SELECT contrasena FROM login WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            // Si la contraseña está hasheada, usa password_verify; si no, compara directamente
            if (password_verify($password, $hashed_password) || $password === $hashed_password) {
                $_SESSION['usuario'] = $usuario;
                header("Location: pagina_principal.php");
                exit();
            } else {
                $mensaje = "<div class='alert alert-danger'>Datos incorrectos.</div>";
            }
        } else {
            $mensaje = "<div class='alert alert-danger'>Usuario no encontrado.</div>";
        }
        $stmt->close();
    } else {
        $mensaje = "<div class='alert alert-danger'>Por favor, complete todos los campos.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">

</head>
<body">
    <div class="container mt-5" style="max-width: 400px;">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (!empty($mensaje)) echo $mensaje; ?>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye" id="icono-ojo"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
        <script>
            document.getElementById("togglePassword").addEventListener("click", function () {
                const passwordInput = document.getElementById("password");
                const icono = document.getElementById("icono-ojo");
                this.style.transform = "scale(1.2)";
                setTimeout(() => this.style.transform = "scale(1)", 100);

                const mostrar = passwordInput.type === "password";
                passwordInput.type = mostrar ? "text" : "password";

                icono.classList.toggle("bi-eye");
                icono.classList.toggle("bi-eye-slash");
            });
        </script>
    </div>
</body>
</html>
