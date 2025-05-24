<?php

include 'includes/heder_tarea.php';
include 'includes/database.php';

if (!isset($_GET['id'])) {
    header("Location: pagina_principal.php");
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarea = $_POST['tirulo'];
    $descripcion = $_POST['contenido'];
    $fecha_limite = $_POST['fecha'];
// Validar los datos que se van a editar
    $query = "UPDATE proyectos SET titulo = ?, contenido = ?, fecha = ? WHERE id_proyecto = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssi", $tarea, $descripcion, $fecha_limite, $id);
        if ($stmt->execute()) {
            header("Location: vista_proyectos.php?id=$id&editado=1");
            exit();
        } else {
            $mensaje = "<div class='alert alert-danger'>Error al actualizar la tarea.</div>";
        }
        $stmt->close();
    } else {
        $mensaje = "<div class='alert alert-danger'>Error en la consulta.</div>";
    }
}


$query = "SELECT * FROM proyectos WHERE id_proyecto = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "<div class='alert alert-warning'>proyecto no encontrado</div>";
    exit();
}
$tarea = $result->fetch_assoc();
?>

<div class="container mt-4" style="max-width: 500px;">
    <h2 class="text-center mb-4">Editar Proyecto</h2>
    <?php if (isset($mensaje)) echo $mensaje; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="proyecto" class="form-label">Proyecto</label>
            <input type="text" class="form-control" id="proyecto" name="proyecto" value="<?php echo htmlspecialchars($tarea['titulo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="3" required><?php echo htmlspecialchars($tarea['contenido']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha Límite</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $tarea['fecha']; ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="vista_proyectos.php?id=<?php echo $id; ?>" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>