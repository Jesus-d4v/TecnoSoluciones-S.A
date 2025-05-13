<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registrar Nueva Tarea</h4>
        </div>
        <div class="card-body">
            <form action="guardar_tarea.php" method="POST">
                <div class="mb-3">
                    <label for="nombre_tarea" class="form-label">Nombre de la tarea</label>
                    <input type="text" class="form-control" id="nombre_tarea" name="nombre_tarea" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                    <input type="datetime-local" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de fin</label>
                    <input type="datetime-local" class="form-control" id="fecha_fin" name="fecha_fin" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Guardar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
