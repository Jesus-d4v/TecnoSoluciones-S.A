<?php

include 'includes/heder_tarea.php';
include 'includes/database.php';

if (!isset($_GET['id'])) {
    header("Location: pagina_principal.php");
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarea = $_POST['tarea'];
    $descripcion = $_POST['descripcion'];
    $fecha_limite = $_POST['fecha_limite'];
// Validar los datos que se van a editar
    $query = "UPDATE tareas SET tarea = ?, descripcion = ?, fecha_limite = ? WHERE id_tarea = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssi", $tarea, $descripcion, $fecha_limite, $id);
        if ($stmt->execute()) {
            header("Location: vista_tareas.php?id=$id&editado=1");
            exit();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al actualizar la tarea.</div>";
        }
        $stmt->close();
    } else {
        $mensaje = "<div class='alert alert-danger'>Error en la consulta.</div>";
    }
}


$query = "SELECT * FROM tareas WHERE id_tarea = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "<div class='alert alert-warning'>Tarea no encontrada</div>";
    exit();
}
$tarea = $result->fetch_assoc();
?>

<div class="container mt-4" style="max-width: 500px;">
    <h2 class="text-center mb-4">Editar Tarea</h2>
    <?php if (isset($mensaje)) echo $mensaje; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="tarea" class="form-label">Tarea</label>
            <input type="text" class="form-control" id="tarea" name="tarea" value="<?php echo htmlspecialchars($tarea['tarea']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($tarea['descripcion']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="fecha_limite" class="form-label">Fecha Límite</label>
            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" value="<?php echo $tarea['fecha_limite']; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="vista_tareas.php?id=<?php echo $id; ?>" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>