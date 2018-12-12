<?php
	include "tools/tools.php";
	include "tools/fpdf/fpdf.php";

	$pdf = new FPDF();

	$pdf->addPage();
	$pdf->setTextColor(0,0, 0);
	$consulta = "select * from datos_reconocimientos order by orden";
	$db->consulta($consulta);
	while($row = $db->obtenerRegistro())
	{
		if($row['tipo'] == 'T')
		{
			$atributos = "";
			if($row['I'])
				$atributos .= "I";
			if($row['N'])
				$atributos .= "B";
			if($row['S'])
				$atributos .= "U";

			$pdf->SetFont('Arial', $atributos, $row['TLetra']);
			$pdf->setXY($row['posiX']/4.4921723, $row['posiY']/4.4921723); // se divide entre 44.921723 para mantener la escala ya que se guarda en pixeles y se tiene que combertir en milimetros
			$pdf->MultiCell($row['ancho'], $row['alto'], $row['Contenido'], 0, 1);
		}
		else
		{
			$pdf->image("data/archivosReconocimiento/".$row['Contenido'], $row['posiX']/4.4921723, $row['posiY']/4.4921723,  $row['ancho'], $row['alto']);
		}
	}

	$pdf->output();
?>