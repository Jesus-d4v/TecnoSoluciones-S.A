<?php
include 'includes/heder_tarea.php';
include 'includes/database.php';

if (!isset($_GET['id'])) {
    header("location: pagina_principal.php");
    exit();
}
$id = $_GET['id'];
$query = "SELECT * FROM proyectos WHERE id_proyecto = ? ";
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
            <h2 class="text-center mt-4 mb-4"><?php echo $tarea['titulo']; ?></h2>
            <p class="card-text"><?php echo $tarea['contenido']; ?></p>
            <p class="card-text">REALIZAR ANTES DE LA FECHA LIMITE: <?php echo $tarea['fecha']; ?></p>
            <small class="text-muted">Publicado el <?php echo $tarea['fecha_crea']; ?></small>

            <div class="d-flex justify-content-center mt-4">
                <a href="editar_proyecto.php?id=<?php echo $tarea['id_proyecto']; ?>" class="btn btn-primary">Editar</a>
                <form action="eliminar_proyecto.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $tarea['id_proyecto']; ?>">
                    <button type="submit" class="btn btn-danger ms-2" onclick="return confirm('¿Estás seguro de que deseas eliminar esta proyecto?');">
                        Eliminar
                    </button>
                    <a href="arcrivoPDFproyec.php" class="btn btn-success">Descargar PDF</a>
                </form>
            </div>
        </div>
    </div>
</div>
