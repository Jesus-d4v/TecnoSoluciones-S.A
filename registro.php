<?php
session_start();
include 'includes/database.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $confirmar = trim($_POST['confirmar']);
    $gmail = trim($_POST['gmail']);
    $telefono = trim($_POST['telefono']);

    if (!empty($usuario) && !empty($password) && !empty($confirmar) && !empty($gmail) && !empty($telefono)) {
        if ($password === $confirmar) {
            if (filter_var($gmail, FILTER_VALIDATE_EMAIL) && substr($gmail, -10) === '@gmail.com') {
                if (preg_match('/^[0-9]+$/', $telefono)) {
                    // verificacion de ususaro existente
                    $stmt = $conn->prepare("SELECT usuario FROM login WHERE usuario = ?");
                    $stmt->bind_param("s", $usuario);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        $mensaje = "<div class='alert alert-danger'>El usuario ya existe.</div>";
                    } else {
                        // Inserta el nuevo usuario SIN hash
                        $stmt = $conn->prepare("INSERT INTO login (usuario, contrasena, gmail, telefono) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssss", $usuario, $password, $gmail, $telefono);
                        if ($stmt->execute()) {
                            $mensaje = "<div class='alert alert-success'>Registro exitoso. <a href='login.php'>Iniciar sesión</a></div>";
                        } else {
                            $mensaje = "<div class='alert alert-danger'>Error al registrar.</div>";
                        }
                    }
                    $stmt->close();
                } else {
                    $mensaje = "<div class='alert alert-danger'>El teléfono debe contener solo números.</div>";
                }
            } else {
                $mensaje = "<div class='alert alert-danger'>Ingrese un correo Gmail válido.</div>";
            }
        } else {
            $mensaje = "<div class='alert alert-danger'>Las contraseñas no coinciden.</div>";
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Complete todos los campos.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'includes/header.php'; ?>
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-3" style="max-width: 400px;">
        <h2 class="text-center">Registro</h2>
        <?php if (!empty($mensaje)) echo $mensaje; ?>
        <form method="POST" action="registro.php">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo Gmail</label>
                <input type="email" class="form-control" name="gmail" required placeholder="ejemplo@gmail.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" required pattern="[0-9]+" maxlength="15">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3 ">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                <input type="password" class="form-control" name="confirmar" id= "password"required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye" id="icono-ojo"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>
        <div class="mt-3 text-center">
            <a href="login.php" style="color: #000;">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
        <script src="assets/js/scripts.js"></script>
    </div>
    
</body>
</html>