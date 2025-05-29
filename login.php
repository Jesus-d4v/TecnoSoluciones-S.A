<?php
session_start();
include 'includes/database.php';

if (isset($_GET['cerrar_sesion'])) {
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
            if (password_verify($password, $hashed_password)) {
                $_SESSION['usuario'] = $usuario;
                header("Location: pagina_principal.php");
                exit();
            } elseif ($password === $hashed_password) {
                $nuevo_hash = password_hash($password, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE login SET contrasena = ? WHERE usuario = ?");
                $update->bind_param("ss", $nuevo_hash, $usuario);
                $update->execute();
                $update->close();

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
        <script src="assets/js/scripts.js"></script>
    </div>
</body>
</html>
