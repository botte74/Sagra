<?php
	include_once("includes/config.php");

	//Se non c'Ã¨ la sessione torno alla pagina principale
	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

	// ricevo parametri da url
	if (isset($_GET["ordine"])) {
		$ordine = $_GET["ordine"];
	}
	else {
		die();
	}

require_once 'includes/fpdf17/pdf_js.php';


class PDF_AutoPrint extends PDF_JavaScript
{
function AutoPrint($dialog=false)
{
	//Open the print dialog or start printing immediately on the standard printer
	$param=($dialog ? 'true' : 'false');
	$script="print($param);";
	$this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
	//Print on a shared printer (requires at least Acrobat 6)
	$script = "var pp = getPrintParams();";
	if($dialog)
		$script .= "pp.interactive = pp.constants.interactionLevel.full;";
	else
		$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
	$script .= "print(pp);";
	$this->IncludeJS($script);
}
}
define('EURO',chr(128));


	$query = "SELECT * FROM c71po_ordini WHERE id_ordine = " .$ordine;

	$result = $mysqli->query($query);
	//echo var_dump($result);
	//$row = $result->fetch_assoc();

	if ($result->num_rows == 0){
		echo("<br />Ordine non trovato!!");
		die();
	}
	else{
		$row = $result->fetch_assoc();
		//Informazioni sull'utente
		$nome = $row['nome_cliente'];
		$prezzo = $row['prezzo_totale'];
		$tipo = $row['tipo'];
	}
	$result->close();

	// recupero il totale dell'ordine facendo la somma delle righe
	$query = "SELECT SUM(`oc`.quantita * `p`.prezzo) AS totaleordine FROM c71po_ordini as `o`, c71po_ordini_composizione as `oc`, c71po_piatti as `p` WHERE `p`.codice = `oc`.id_piatto AND `oc`.id_ordine = `o`.id_ordine AND `o`.id_ordine = " .$ordine;	
	$result = $mysqli->query($query);
	$row = $result->fetch_assoc();
	$totale_ordine = $row['totaleordine'];
	$result->close();
	

	$pdf=new PDF_AutoPrint('P','mm',array(80,400));
	$pdf->SetMargins(4, 0, 0);
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true , 0);
	$pdf->SetFont('Arial','',8);

	//lista articoli
	//reperisco dati da anagrafica
	$totale_ordine = number_format($totale_ordine, 2, ",", ".");
	$altriga = 8;
	stampa_testa();
	
$query = "SELECT * FROM c71po_ordini_composizione as `oc` JOIN c71po_piatti as `p` ON `oc`.id_piatto = `p`.codice WHERE id_ordine = $ordine ORDER BY `tipologia`,`ordine`";
//echo $query;	
$result = $mysqli->query($query, MYSQLI_USE_RESULT);
//echo $mysqli->error;
//echo var_dump($result);
	while($row = $result->fetch_assoc()) {
		// stampa riga pdf
		stampa_riga();
	}
	// stampo totale
	stampa_totale();

	$result->close();


	$pdf->Output("scontrini-bar/" . $ordine . ".pdf", "F");
	//$pdf->AutoPrint(true);
	$pdf->Output();


	// chiudo connessione
	$mysqli->close();


function stampa_testa() {
	global $pdf, $totaleordine, $row, $altriga, $nome, $ordine;

	$pdf->setxy(4,5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(68,$altriga,'Sagra della Mandria 2016',0,1,"C");
	$pdf->Cell(68,$altriga, iconv('UTF-8', 'windows-1252', "Ordine n° " . $ordine), "B", 1, "R");

}

function stampa_riga () {
	global $pdf, $row, $altriga;

	$totale_riga = number_format(($row['quantita'] * $row['prezzo']), 2);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(8,$altriga,$row['quantita'] . " -",0,0, "R");
	$my_string = iconv('UTF-8', 'windows-1252', strtoupper($row['nome']));
	$font_size = 10;
	$decrement_step = 0.1;
	$line_width = 60; // Line width (approx) in mm
	$pdf->SetFont('Arial', 'B', $font_size);
	while($pdf->GetStringWidth($my_string) > ($line_width - 2)) {
		$pdf->SetFontSize($font_size -= $decrement_step);
	}
	$pdf->Cell($line_width, $altriga, $my_string, 0, 1);

}

function stampa_totale () {
	global $pdf, $row, $totale_ordine, $altriga;

	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(8,10, "","TB",0, "C");
	$pdf->Cell(40, 10, "TOTALE", "TB", 0);
	$pdf->Cell(20,10, EURO . " " . $totale_ordine, "TB", 1, "R");
}
?>
