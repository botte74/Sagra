<?php

function stampa_testa() {
	global $pdf, $totaleordine, $sezione, $righestampate, $row, $altriga, $nome, $ordine, $tipo;

	// in base alla sezione calcolo la posizione di Y
	if ($sezione == 1) $y = 5;
	if ($sezione == 2) $y = 100;
	if ($sezione == 3) $y = 200;

	$pdf->SetLineWidth(1);
	$pdf->setxy(10,$y);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(190,10,'MandriaFest 2016',0,1,"C");
	$y += 10;

	// stampo testatina
	$pdf->SetLineWidth(0.2);
	$pdf->setxy(10,$y);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(18,$altriga, iconv('UTF-8', 'windows-1252', "Q.tà"),1,0, "C");
	//$pdf->Cell(40,$altriga,"Codice",1,0);
	$pdf->Cell(122,$altriga,"Descrizione",1,0);
	$pdf->Cell(20,$altriga,"Totale", 1,1);

	// imposto le celle a destra della stampa
	$pdf->SetLineWidth(1);
	// Tavolo
	$pdf->SetFont('Arial','',12);
	$pdf->setxy(170,$y);
	$pdf->Cell(30,$altriga, iconv('UTF-8', 'windows-1252', "Tavolo N°"),"LTR",1, "C");
	$y += $altriga;
	if ($tipo == 'A') {
		$tavolo = "ASPORTO";
	}
	else {
		$tavolo = "";
	}
	$pdf->setxy(170,$y);
	$pdf->Cell(30,$altriga * 2, $tavolo,"LBR",1, "C");
	$y += $altriga * 2;

	// preparo 2 righe per il nome
	$nome1 = "";
	$nome2 = "";
	$array_nomi = explode(" ", $nome);
	if (count($array_nomi) == 1) {
		$nome1 = $array_nomi[0];
	}
	if (count($array_nomi) == 2) {
		$nome1 = $array_nomi[0];
		$nome2 = $array_nomi[1];
	}
	if (count($array_nomi) >= 3) {
		if ((strlen($array_nomi[0] . $array_nomi[1])) < (strlen($array_nomi[1] . $array_nomi[2]))) {
			$nome1 = $array_nomi[0] . " " . $array_nomi[1];
			$nome2 = $array_nomi[2];
		}
		else {
			$nome1 = $array_nomi[0];
			$nome2 = $array_nomi[1] . " " . $array_nomi[2];
		}
	}

	if ($nome2 == "") {
		$pdf->setxy(170,$y);
		$my_string = iconv('UTF-8', 'windows-1252', $nome1);
		$font_size = 14;
		$decrement_step = 0.1;
		$line_width = 30; // Line width (approx) in mm
		$pdf->SetFont('Arial', '', $font_size);
		while($pdf->GetStringWidth($my_string) > ($line_width - 2)) {
			$pdf->SetFontSize($font_size -= $decrement_step);
		}
		$pdf->Cell($line_width, $altriga * 2, $my_string, 1, 0, "C");
		$y += $altriga * 2;
	}
	else {
		$pdf->setxy(170,$y);
		// prima parte del nome
		$my_string = iconv('UTF-8', 'windows-1252', $nome1);
		$font_size = 14;
		$decrement_step = 0.1;
		$line_width = 30; // Line width (approx) in mm
		$pdf->SetFont('Arial', '', $font_size);
		while($pdf->GetStringWidth($my_string) > ($line_width - 2)) {
			$pdf->SetFontSize($font_size -= $decrement_step);
		}
		$pdf->Cell($line_width, $altriga, $my_string, "LTR", 0, "C");
		$y += $altriga;

		$pdf->setxy(170,$y);
		// seconda parte del nome
		$my_string = iconv('UTF-8', 'windows-1252', $nome2);
		$font_size = 14;
		$decrement_step = 0.1;
		$line_width = 30; // Line width (approx) in mm
		$pdf->SetFont('Arial', '', $font_size);
		while($pdf->GetStringWidth($my_string) > ($line_width - 2)) {
			$pdf->SetFontSize($font_size -= $decrement_step);
		}
		$pdf->Cell($line_width, $altriga , $my_string, "LBR", 0, "C");
		$y += $altriga;
	}

	// Ordine
	$pdf->SetFont('Arial','',12);
	$pdf->setxy(170,$y);
	$pdf->Cell(30,$altriga, iconv('UTF-8', 'windows-1252', "Ordine N°"),"LTR",1, "C");
	$y += $altriga;
	$pdf->SetFont('Arial','B',22);
	$pdf->setxy(170,$y);
	$pdf->Cell(30,($altriga * 2), $ordine,"LBR",1, "C");
	$y += $altriga * 2;

	// Totale
	$pdf->SetFont('Arial','',12);
	$pdf->setxy(170,$y);
	$pdf->Cell(30,$altriga, "Totale","LTR",1, "C");
	$y += $altriga;
	$pdf->SetFont('Arial','B',20);
	$pdf->setxy(170,$y);
	$pdf->Cell(30,($altriga * 2), EURO . " " . $totaleordine,"LBR",1, "C");

	// azzero numero righe stampate
	$righestampate = 0;

	$pdf->SetLineWidth(0.2);

	// mi riposizione il cursore per la stampa delle righe
	if ($sezione == 1) $pdf->setxy(10, (5 + 10 + $altriga));
	if ($sezione == 2) $pdf->setxy(10, (100 + 10 + $altriga));
	if ($sezione == 3) $pdf->setxy(10, (200 + 10 + $altriga));

}

function stampa_riga () {
	global $pdf, $row, $righestampate, $altriga;

	$totale_riga = number_format(($row['ri_quantita'] * $row['ri_prezzo']), 2);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(18,$altriga,$row['ri_quantita'],1,0, "C");
	$pdf->SetFont('Arial','',12);

	// se la riga è stata modificata lo segnalo con *** all'inizio
	if ($row['ri_mod'] == '*' ) {
		$descrizione = '*** ' . $row['ri_descrizione'];
	}
	else {
		$descrizione = $row['ri_descrizione'];
	}
	$my_string = iconv('UTF-8', 'windows-1252', $descrizione);
	$font_size = 12;
	$decrement_step = 0.1;
	$line_width = 122; // Line width (approx) in mm
	$pdf->SetFont('Arial', '', $font_size);
	while($pdf->GetStringWidth($my_string) > ($line_width - 2)) {
		$pdf->SetFontSize($font_size -= $decrement_step);
	}
	$pdf->Cell($line_width, $altriga, $my_string, 1, 0);
	//$pdf->Cell(80,10,$row['ri_descrizione'],1,0);

	$pdf->SetFont('Arial','',12);
	$pdf->Cell(20,$altriga, EURO . " " . $totale_riga,1,1, "R");
	$righestampate += 1;
}

function stampa_riga_vuota() {
	global $pdf, $righestampate, $altriga;
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(18,$altriga, "",1,0);
	//$pdf->Cell(40,$altriga, "",1,0);
	$pdf->Cell(122,$altriga, "", 1, 0);
	$pdf->Cell(20,$altriga, "",1,1);
	$righestampate += 1;
}

?>
