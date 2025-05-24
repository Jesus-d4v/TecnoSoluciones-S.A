<?php
include 'includes/heder_tarea.php';
include 'includes/database.php';

if(!isset($_GET['id'])){
    header("location: pagina_principal.php");
    exit();
}
$id =$_GET['id'];
$query = "SELECT * FROM tareas WHERE id_tarea = ? ";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 0){
    echo "<div class='alert alert-warnig'>Publicacion no encontrada</div>";
    exit();
}

$publicacion = $result->fetch_assoc();
?>

<div class="d-flex justify-content-center">
    <div class="card mb-4" style="max-width: 500px; width: 100%;">
        <div class="card-body mb-4">
            <h2 class="text-center mt-4 mb-4"><?php echo $publicacion['tarea']; ?></h2>
            <p class="card-text"><?php echo $publicacion['descripcion']; ?></p>
            <p class="card-text">REALIZAR ANTES DE LA FECHA LIMITE: <?php echo $publicacion['fecha_limite']; ?></p>
            <small class="text-muted">Publicado el <?php echo $publicacion['fecha_creacion']; ?></small>

            <div class="d-flex justify-content-center mt-4">
                <a class="btn btn-primary">editar</a>
                <a class="btn btn-danger ms-2">Eliminar</a>
        </div>
    </div>
</div>