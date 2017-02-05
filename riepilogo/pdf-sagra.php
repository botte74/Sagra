<?php
	include_once("../includes/config.php");

							
	$giorno=$_SESSION['giorno'];
	

	$data=date("Y-m-d");
	
	//---------------------- COPERTI TOTALE ----------------------------------//
	$query_coperti="SELECT SUM(coperto) AS somma FROM `".$prefix."ordini` WHERE `stato`='evaso'";
	$result_coperti=mysqli_query($dbconn,$query_coperti);
	$result=mysqli_fetch_array($result_coperti);
	$coperti=$result['somma'];
		
	//--------------- TOTALE GUADAGNO SAGRA -----------------------------------//
	$tot_sagra=0;
	$query_prezzo_sagra="SELECT SUM(prezzo_totale) AS prezzo_sagra FROM `".$prefix."ordini`";
	$result_sagra=mysqli_query($dbconn, $query_prezzo_sagra);
	if($result_sagra){
		$row_prezzo_sagra = mysqli_fetch_array($result_sagra);
		$tot_sagra+=$row_prezzo_sagra['prezzo_sagra'];
	}
	
	//--------------RIEPILOGO-------------------------------------------------//
	$query_riepilogo=
			"SELECT `piatti`.`nome`, SUM(quantita) AS `quantita`, `prezzo`, `codice`, `descrizione`, `var`
			FROM	`" . $prefix . "piatti` AS piatti,
					`" . $prefix . "ordini` AS ordini,
					`" . $prefix . "ordini_composizione` AS oc
			WHERE
				oc.id_ordine = ordini.id_ordine AND
				oc.id_piatto = piatti.codice
			GROUP BY `id_piatto`
			ORDER BY `tipologia`";
		
	$piatti_ordine = mysqli_query($dbconn,$query_riepilogo);

	$nome_ordine		= array();
	$descrizione		= array();
	$variante			= array();
	$quantita 			= array();
	$prezzo_unitario 	= array();
	$somma=0.00;
	$i=0;
	
	$righe=mysqli_num_rows($piatti_ordine);	
	
	while ($piatto_ordine = mysqli_fetch_array($piatti_ordine) ) {
		$codice = $piatto_ordine['codice'];
		$nome_piatto = $piatto_ordine['nome'];
		if ($piatto_ordine['var'] != 0) {
			$var = $piatto_ordine['var'];
			//Piatto con varianti
			$query_varianti_piatto = "	SELECT `AL`.`nome`
										FROM	`" . $prefix . "piatti` AS `PIA`, `" . $prefix . "varianti`,
												`" . $prefix . "alimentari` AS `AL`, `" . $prefix . "ordini_composizione`
										WHERE
											`PIA`.`codice` = '$codice' AND
											`id_ordine` = '$ordine' AND
											`id_piatto` = `PIA`.`codice` AND
											`codice_alimento` = `AL`.`codice` AND
											`var` = `codice_alimento` AND
											`var` = '$var'";
			$variante = mysqli_fetch_array(mysqli_query($dbconn, $query_varianti_piatto));
			$descrizione_piatto = $piatto_ordine['descrizione'] . " " . $variante['nome'];
			
		}
		else{
			//No Variante
			$descrizione_piatto = $nome_piatto . " " . $piatto_ordine['descrizione'];
		}//else
		$nome_ordine[$i]				= $piatto_ordine['nome'];
		$descrizione[$i]				= $descrizione_piatto;
		$prezzo_unitario[$i] 			= $piatto_ordine['prezzo'];
		$quantita[$i] 					= $piatto_ordine['quantita'];
		$somma+=$quantita[$i]*$prezzo_unitario[$i];
		$i++;
	}
	$h=$i;	
	
	//----------------------------------------------------------------------//
	//------------------------------PDF CREAZIONE---------------------------//
	//----------------------------------------------------------------------//
	
	//Include the main TCPDF library (search for installation path).
	require_once('../tcpdf/tcpdf.php');
	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF {

		//Page header
		public function Header() {
			// Set font
			$this->SetFont('courier', 'B', 16);
			// Title
			$this->Cell(0, 15, 'Sagra Mandria 2015 - RIEPILOGO GENERALE', 10, false, 'C', 0, '', 0, false, 'M', 'M');
		}

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}

	// create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set font
	$pdf->SetFont('', '', 9);
	$pdf->AddPage('P', 'A4');
	// set some text to print
	$txt = '<table style="border: 1px solid #9A9A9A; padding:5px;">
				<tr style="border: 1px solid #9A9A9A;">
					<td colspan="2" style="border: 1px solid #9A9A9A;"><b>TOT COPERTI</b></td>
					<td style="border: 1px solid #9A9A9A;">'.$coperti.'</td>
					<td style="border: 1px solid #9A9A9A;"><b>GUADAGNO</b></td>
					<td style="border: 1px solid #9A9A9A;">'.number_format($tot_sagra,2,".","").' €</td>
				</tr>
			</table>';
	$pdf->writeHTML($txt, true, false, true, false, '');
	$txt2 = 	'
	<table style="border: 1px solid #9A9A9A; padding:5px;">
		<tr style="border: 1px solid #9A9A9A;">
			<td colspan="2" style="border: 1px solid #9A9A9A;"><b>NOME PIATTO</b></td>
			<td style="border: 1px solid #9A9A9A;"><b>PREZZO UNITARIO</b></td>
			<td style="border: 1px solid #9A9A9A;"><b>QUANTITA</b></td>
			<td style="border: 1px solid #9A9A9A;"><b>PREZZO TOTALE</b></td>
		</tr>';
	for($i=0;$i<$h;$i++){ 
		$txt2.='<tr>
				<td colspan="2" style="border: 1px solid #9A9A9A;">'.$descrizione[$i].'</td>
				<td style="border: 1px solid #9A9A9A;">'.$prezzo_unitario[$i].' €</td>
				<td style="border: 1px solid #9A9A9A;">'.$quantita[$i].'</td>
				<td style="border: 1px solid #9A9A9A;">'.number_format($prezzo_unitario[$i]*$quantita[$i],2,".","").' €</td>
			</tr>';
		if(($i%30==0)&&($i!=0)){
			$txt2.= '</table>';
			$pdf->writeHTML($txt2, true, false, true, false, '');
			$pdf->AddPage('P', 'A4');
			$txt2=$txt;
			$pdf->writeHTML($txt2, true, false, true, false, '');
			$txt2='<table style="margin-top:10px; border: 1px solid #9A9A9A; padding:5px;">';
		}
	}//for
	$txt2.='</table>';
	$pdf->writeHTML($txt2, true, false, true, false, '');
		
	
	// ---------------------------------------------------------

	//Close and output PDF document
	$pdf->Output('rendiconto.pdf', 'I');
?>
