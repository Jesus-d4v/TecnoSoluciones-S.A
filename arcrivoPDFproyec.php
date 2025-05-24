<?php
require('includes/fpdf.php'); 
include 'includes/database.php';
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Proyectos:', 0, 1);

$query = "SELECT titulo, contenido, fecha_crea FROM proyectos";
$result = $conn->query($query);
$pdf->SetFont('Arial', '', 11);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(0, 8, 'Proyecto: ' . $row['titulo'], 0, 1);
        $pdf->MultiCell(0, 8, 'Descripcion: ' . $row['contenido']);
        $pdf->Cell(0, 8, 'Fecha de creacion: ' . $row['fecha_crea'], 0, 1);
        $pdf->Ln(2);
    }
} else {
    $pdf->Cell(0, 8, 'No hay proyectos registrados.', 0, 1);
}

$pdf->Output('D', 'proyectos.pdf');
exit;
?>