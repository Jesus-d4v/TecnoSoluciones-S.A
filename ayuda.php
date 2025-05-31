<?php
include 'includes/heder_tarea.php';
include 'includes/database.php'; 

function guardarComentario($conn, $correo, $comentario) {
    $sql = "INSERT INTO comentario (correo, comentario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $correo, $comentario);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comentario']) && !empty($_POST['correo'])) {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $comentario = htmlspecialchars($_POST['comentario']);
    if (guardarComentario($conn, $correo, $comentario)) {
        $mensaje = '<div class="alert alert-success mt-3">¡Gracias por tu comentario!</div>';
    } else {
        $mensaje = '<div class="alert alert-danger mt-3">Error al guardar el comentario.</div>';
    }
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2 class="text-center mb-4">Ayuda y Comentarios</h2>
    <div class="card p-4 mb-4">
        <h5>¿Necesitas ayuda?</h5>
        <p>
            Si tienes dudas sobre el uso del sistema, puedes consultar el manual de usuario o contactar al soporte técnico.
        </p>
        <ul>
            <li>Manual de usuario: <a href="Informe_Soporte_Tecnico_2025-001 (1).pdf" target="_blank">Descargar PDF</a></li>
            <li>Correo de soporte: <a href="mailto:morevierajesusdavid@gmail.com">soporte@tecnosoluciones.com</a></li>
        </ul>
    </div>
    <div class="card p-4">
        <h5>Envíanos tus comentarios</h5>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario o sugerencia</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <?php
        if (!empty($mensaje)) {
            echo $mensaje;
        }
        ?>
    </div>
</div>