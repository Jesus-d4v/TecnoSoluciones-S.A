<?php
include 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM proyectos WHERE id_proyecto= ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: pagina_principal.php?eliminado=1");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar la tarea.</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error en la consulta.</div>";
    }
} else {
    header("Location: pagina_principal.php");
    exit();
}
?>