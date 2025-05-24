<?php

include 'includes/header.php';
include 'includes/database.php';

// Procesar formulario para agregar proyecto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO proyectos (titulo, contenido, fecha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sss", $titulo, $contenido, $fecha);
        if ($stmt->execute()) {
            $mensaje = '<div class="alert alert-success">Proyecto creado correctamente.</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al crear el proyecto.</div>';
        }
        $stmt->close();
    } else {
        $mensaje = '<div class="alert alert-danger">Error en la consulta.</div>';
    }
}
?>

<div class="container mt-3" style="max-width: 500px;">
    <h2 class="text-center">Crear Proyecto</h2>
    <?php if (isset($mensaje)) echo $mensaje; ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="contenido" class="form-label">Descripción</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Crear Proyecto</button>
    </form>
</div>