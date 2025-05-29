<?php 
include 'includes/heder_tarea.php';
include 'includes/database.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarea = $_POST['tarea'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_limite = $_POST['fecha_limite'];

    $sql = "INSERT INTO tareas (tarea, descripcion,fecha_inicio , fecha_limite) VALUES (?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssss", $tarea, $descripcion, $fecha_inicio,$fecha_limite);
        if ($stmt->execute()) {
            $mensaje = '<div class="alert alert-success">Tarea creada correctamente.</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al crear la tarea.</div>';
        }
        $stmt->close();
    } else {
        $mensaje = '<div class="alert alert-danger">Error en la consulta.</div>';
    }
}
?>

<div class="container mt-3" style="max-width: 400px;">
    <h2 class="text-center">Crear Tarea</h2>
    <?php if (isset($mensaje)) echo $mensaje; ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="tarea" class="form-label">Tarea</label>
            <input type="text" class="form-control" id="tarea" name="tarea" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
        </div>
         <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required> 
        </div>
        <div class="mb-3">
            <label for="fecha_limite" class="form-label">Fecha Límite</label>
            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" required> 
        </div>
        <button type="submit" class="btn btn-primary">Subir</button>
    </form>