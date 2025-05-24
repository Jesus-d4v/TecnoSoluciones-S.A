<?php
include 'includes/heder_tarea.php';
include 'includes/database.php';

if (!isset($_GET['id'])) {
    header("location: pagina_principal.php");
    exit();
}
$id = $_GET['id'];
$query = "SELECT * FROM tareas WHERE id_tarea = ? ";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "<div class='alert alert-warnig'>Publicacion no encontrada</div>";
    exit();
}

$tarea = $result->fetch_assoc();
?>

<div class="d-flex justify-content-center">
    <div class="card mb-4" style="max-width: 500px; width: 100%;">
        <div class="card-body mb-4">
            <h2 class="text-center mt-4 mb-4"><?php echo $tarea['tarea']; ?></h2>
            <p class="card-text"><?php echo $tarea['descripcion']; ?></p>
            <p class="card-text">REALIZAR ANTES DE LA FECHA LIMITE: <?php echo $tarea['fecha_limite']; ?></p>
            <small class="text-muted">Publicado el <?php echo $tarea['fecha_creacion']; ?></small>

            <div class="d-flex justify-content-center mt-4">
                <a href="editar.php?id=<?php echo $tarea['id_tarea']; ?>" class="btn btn-primary">Editar</a>
                <form action="eliminar.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $tarea['id_tarea']; ?>">
                    <button type="submit" class="btn btn-danger ms-2" onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?');">
                        Eliminar
                    </button>
                    <a href="archivoPDF.php" class="btn btn-success">Descargar PDF</a>
                </form>
            </div>
        </div>
    </div>
</div>