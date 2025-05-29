<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/database.php';
require_once 'includes/fpdf.php';

function getWeekRange($year, $week) {
    $dto = new DateTime();
    $dto->setISODate($year, $week);
    $start = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $end = $dto->format('Y-m-d');
    return [$start, $end];
}

$reporte_generado = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = intval($_POST['year']);
    $week = intval($_POST['week']);
    list($fecha_inicio, $fecha_fin) = getWeekRange($year, $week);

    $stmtTareas = $conn->prepare("SELECT * FROM tareas WHERE fecha_inicio BETWEEN ? AND ?");
    $stmtTareas->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmtTareas->execute();
    $resultTareas = $stmtTareas->get_result();

    $stmtProyectos = $conn->prepare("SELECT * FROM proyectos WHERE fecha BETWEEN ? AND ?");
    $stmtProyectos->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmtProyectos->execute();
    $resultProyectos = $stmtProyectos->get_result();

    // Generar PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,"Informe Semanal ($fecha_inicio a $fecha_fin)",0,1,'C');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,"Tareas",0,1);
    $pdf->SetFont('Arial','',10);
    while($row = $resultTareas->fetch_assoc()) {
        $pdf->Cell(0,8,"- {$row['nombre']} ({$row['fecha']})",0,1);
    }

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,"Proyectos",0,1);
    $pdf->SetFont('Arial','',10);
    while($row = $resultProyectos->fetch_assoc()) {
        $pdf->Cell(0,8,"- {$row['nombre']} ({$row['fecha_inicio']})",0,1);
    }

    $reporte_generado = true;
    $pdf->Output('I', "informe_semanal_{$year}_semana_{$week}.pdf");
    exit();
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h2>Generar Informe Semanal</h2>
    <form method="post">
        <div class="form-group">
            <label for="year">Año:</label>
            <input type="number" name="year" id="year" class="form-control" value="<?php echo date('Y'); ?>" required>
        </div>
        <div class="form-group">
            <label for="week">Semana (1-53):</label>
            <input type="number" name="week" id="week" class="form-control" min="1" max="53" value="<?php echo date('W'); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Generar PDF</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>