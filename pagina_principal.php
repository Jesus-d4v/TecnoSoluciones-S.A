<?php
include 'includes/headerlogin.php';
include 'includes/database.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Mostrar tareas
$query = "SELECT * FROM tareas ORDER BY fecha_creacion DESC";
$result = $conn->query($query);

echo '<h3>Tareas</h3>';
if ($result && $result->num_rows > 0) {
    echo '<div class="row">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['tarea']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars(substr($row['descripcion'], 0, 150)) . '...</p>';
        echo '<small class="text-muted">Publicado el ' . htmlspecialchars($row['fecha_creacion']) . '</small>';
        echo '</div>';
        echo '<div class="card-footer bg-transparent">';
        echo '<a href="vista_tareas.php?id=' . urlencode($row['id_tarea']) . '" class="btn btn-sm btn-primary float-end">Ver más</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p class="text-muted">No hay tareas disponibles.</p>';
}

// Mostrar proyectos
$query = "SELECT * FROM proyectos ORDER BY fecha_crea DESC";
$result = $conn->query($query);

echo '<h3>Proyectos</h3>';
if ($result && $result->num_rows > 0) {
    echo '<div class="row">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-5">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['titulo']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars(substr($row['contenido'], 0, 150)) . '...</p>';
        echo '<small class="text-muted">Publicado el ' . htmlspecialchars($row['fecha']) . '</small>';
        echo '</div>';
        echo '<div class="card-footer bg-transparent">';
        echo '<a href="vista_proyectos.php?id=' . urlencode($row['id_proyecto']) . '" class="btn btn-sm btn-primary float-end">Ver más</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p class="text-muted">No hay proyectos disponibles.</p>';
}

$conn->close();
?>
