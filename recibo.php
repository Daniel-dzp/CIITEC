<?php
	if(!isset($_POST['folio']))
		header('location: home.php');

	include "tools/tools.php";
	include "tools/fpdf/fpdf.php";

	$consulta = "select monto, concat( nombre, ' ', apellidos) as persona from pagos_efectivo pe join usuario u on pe.id_user=u.id where pe.id=".$_POST['folio'];
	$db->consulta($consulta);

	$row = $db->obtenerRegistro();


	$pdf = new FPDF();
	$pdf->addPage();
	$pdf->SetFont('Arial', 'BIU', 13);
	$pdf->setTextColor(0,0,0);
	$pdf->setFillColor(200, 200, 200);
	$pdf->Ln(10);
	$pdf->Cell(0,6, "CIITEC 2018", 0, 1, 'C');
	$pdf->image("img/logo_CITEC.png", 160, 8, 45, 20);
	$pdf->image("img/barCode.jpg", 95, 275, 40, 10);
	$pdf->Ln(15);
	$pdf->SetFont('Arial', '', 11);
	$pdf->MultiCell(0, 6, "Recibi de ".$row['persona']." la cantidad de $".$row['monto']." M/N, por concepto de pago del congreso.", 0, 1);


	$pdf->output();
?>