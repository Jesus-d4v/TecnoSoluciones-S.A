<?php 
include 'includes/heder_tarea.php'; 
include 'includes/database.php';?>
<?php
//consulta para obtener las publicaciones
$query = "SELECT * FROM tareas ORDER BY fecha_creacion DESC";  
$result = $conn->query($query);

if ($result->num_rows > 0)
{
    //recorrer el resultado de la consulta
    //agregar columnas de dos
    echo '<div class="row">';

    while($row = $result->fetch_assoc()){
        echo '<div class="col-md-6 mb-5>';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$row['tarea'].'</h5>';
        echo '<p class="card-text">'.substr($row['descripcion'],0,150).'......</p>';
        echo '<small class="text-muted">Publicado el '.$row['fecha_creacion'].'</small>';
        echo'<div class= "card-footer bg-transparent">';
        echo '<a href="post.php? id='.$row['id_tarea'].'" class="btn btn-sm btn-primary float-end">Ver más</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
       
    }echo '</div>';
} else {
    echo '<p class="text-muted">No hay publicaciones disponibles.</p>';   
}
$conn->close(); //cerrar la conexion a la base de datos
?>