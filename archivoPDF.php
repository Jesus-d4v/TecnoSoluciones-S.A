<?php
require('includes/fpdf.php'); 
include 'includes/database.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);


$pdf->Cell(0, 10, 'Listado de Tareas y Proyectos', 0, 1, 'C');


$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Tareas:', 0, 1);

$query = "SELECT tarea, descripcion, fecha_limite FROM tareas";
$result = $conn->query($query);
$pdf->SetFont('Arial', '', 11);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(0, 8, 'Tarea: ' . $row['tarea'], 0, 1);
        $pdf->MultiCell(0, 8, 'Descripcion: ' . $row['descripcion']);
        $pdf->Cell(0, 8, 'Fecha limite: ' . $row['fecha_limite'], 0, 1);
        $pdf->Ln(2);
    }
} else {
    $pdf->Cell(0, 8, 'No hay tareas registradas.', 0, 1);
}
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Proyectos:', 0, 1);

$query = "SELECT Titulo, Contenido, Fecha FROM publicaciones";
$result = $conn->query($query);
$pdf->SetFont('Arial', '', 11);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(0, 8, 'Proyecto: ' . $row['Titulo'], 0, 1);
        $pdf->MultiCell(0, 8, 'Descripcion: ' . $row['Contenido']);
        $pdf->Cell(0, 8, 'Fecha: ' . $row['Fecha'], 0, 1);
        $pdf->Ln(2);
    }
} else {
    $pdf->Cell(0, 8, 'No hay proyectos registrados.', 0, 1);
}

// Salida del PDF para descarga
$pdf->Output('D', 'tareas_proyectos.pdf');
exit;
?>