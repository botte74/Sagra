<?php
	include_once("../includes/config.php");

	if (isset($_GET['pagato']))
		$pagato = $_GET['pagato'];
	else
		$pagato = false;
	if(isset($_SESSION['ordine'])) {
		$ordine = $_SESSION['ordine'];

		if ($pagato) {


			$query_ordine_pagato = "UPDATE `" . $prefix . "ordini`
															SET
																	`stato` = 'pagato'
															WHERE id_ordine = '$ordine';";
			mysqli_query( $dbconn, $query_ordine_pagato);

			$query_ordine_totale = "SELECT `nome_cliente`, `tavolo` ,`coperto`,`data_ordine`, `speciale`, `prezzo_totale` FROM `" . $prefix . "ordini` WHERE `id_ordine` = '$ordine';";
			$ordini_totale = mysqli_query( $dbconn, $query_ordine_totale);
			//echo mysql_error();

			$ordine_totale = mysqli_fetch_array($ordini_totale);

			$nome = $ordine_totale['nome_cliente'];
			$tavolo = $ordine_totale['tavolo'];
			$coperto = $ordine_totale['coperto'];

			$data_ordine = $ordine_totale['data_ordine'];
			$data= explode(" ",$data_ordine);

			$anno= $data[0];
			$ora= $data[1];


			if($tavolo=='tavolo')
				$tavolo='servito';
			else
				$tavolo='asporto';


			//-----------CIBO------------------------//
			$query_riepilogo_cibo=
				"SELECT `piatti`.`nome`, `quantita`, `prezzo`, `codice`, `descrizione`, `var`
				FROM	`" . $prefix . "piatti` AS piatti,
						`" . $prefix . "ordini` AS ordini,
						`" . $prefix . "ordini_composizione` AS oc
				WHERE
					oc.id_ordine = '$ordine' AND
					oc.id_ordine = ordini.id_ordine AND
					oc.id_piatto = piatti.codice AND
					(piatti.tipologia = '0-Menu' OR piatti.tipologia = '1-Primo' OR piatti.tipologia = '2-Secondo' OR piatti.tipologia = '3-Contorno')
				ORDER BY `tipologia`,`ordine`;";


			$piatti_ordine_cibo = mysqli_query($dbconn, $query_riepilogo_cibo);

			$nome_cibo				= array();
			$descrizione_cibo		= array();
			$variante_cibo			= array();
			$quantita_cibo 			= array();
			$prezzo_cibo_unitario 	= array();
			$somma_cibo=0.00;
			$i_cibo=0;

			$righe_cibo=mysqli_num_rows($piatti_ordine_cibo);

			while ($piatto_ordine_cibo = mysqli_fetch_array($piatti_ordine_cibo) ) {
				$codice = $piatto_ordine_cibo['codice'];
				$nome_variante = $piatto_ordine_cibo['nome'];
				if ($piatto_ordine_cibo['var'] != 0) {
					$var = $piatto_ordine_cibo['var'];
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
													`var` = '$var';";
					$variante = mysqli_fetch_array(mysqli_query( $dbconn, $query_varianti_piatto));
					$nome_variante = $variante['nome'];
					$descrizione_piatto =  $piatto_ordine_cibo['descrizione'] . " " . $nome_variante;
				}
				else{
					//NO Varianti
					$descrizione_piatto = $piatto_ordine_cibo['nome'] . " " . $piatto_ordine_cibo['descrizione'];
				}//else
				$nome_cibo[$i_cibo]						= $piatto_ordine_cibo['nome'];
				$descrizione_cibo[$i_cibo]				= $descrizione_piatto;
				$prezzo_cibo_unitario[$i_cibo] 			= $piatto_ordine_cibo['prezzo'];
				$quantita_cibo[$i_cibo] 				= $piatto_ordine_cibo['quantita'];
				$somma_cibo								+=$quantita_cibo[$i_cibo]*$prezzo_cibo_unitario[$i_cibo];

				$i_cibo++;
			}

			$query_riepilogo_bevande=
				"SELECT *
				FROM	`" . $prefix . "piatti` AS piatti,
						`" . $prefix . "ordini` AS ordini,
						`" . $prefix . "ordini_composizione` AS oc
				WHERE
					oc.id_ordine = '$ordine' AND
					oc.id_ordine = ordini.id_ordine AND
					oc.id_piatto = piatti.codice AND (
					piatti.tipologia='6-paninoteca' OR piatti.tipologia='0-Menu')";


			$piatti_ordine_bevande = mysqli_query($dbconn, $query_riepilogo_bevande);

			$nome_bevande				= array();
			$quantita_bevande 			= array();
			$prezzo_bevande_unitario 	= array();
			$somma_bevande=0.00;
			$i_bevande=0;

			$righe_bevande=mysqli_num_rows($piatti_ordine_bevande);

			while ($piatto_ordine_bevande = mysqli_fetch_array($piatti_ordine_bevande) ) {
				if($piatto_ordine_bevande['tipologia']=='0-Menu'){
					$codice_variante = $piatto_ordine_bevande['var'];
					$codice=$piatto_ordine_bevande['codice'];
					$query_varianti_piatto = "	SELECT `AL`.`nome`
												FROM	`" . $prefix . "piatti` AS `PIA`, `" . $prefix . "varianti`,
														`" . $prefix . "alimentari` AS `AL`, `" . $prefix . "ordini_composizione`,
														`" . $prefix . "piatti_composizione` AS `PC`
												WHERE
													`PIA`.`codice` = '$codice' AND
													`PIA`.`codice` = `cod_piatto` AND
													`cod_alimentari` = `AL`.`codice` AND
													`var` = `cod_alimentari` AND
													`var` = '$codice_variante'";
					$variante = mysqli_fetch_array(mysqli_query( $dbconn, $query_varianti_piatto));
					$nome_variante = $variante['nome'];
					//echo $query_varianti_piatto;
					$descrizione_piatto = $nome_variante;
				}
				else{
					$descrizione_piatto =  $piatto_ordine_bevande['nome'];
				}
				//echo $descrizione_piatto;
				$nome_bevande[$i_bevande]				= $descrizione_piatto;
				$prezzo_bevande_unitario[$i_bevande] 	= $piatto_ordine_bevande['prezzo'];
				$quantita_bevande[$i_bevande] 			= $piatto_ordine_bevande['quantita'];
				$somma_bevande+=$quantita_bevande[$i_bevande]*$prezzo_bevande_unitario[$i_bevande];
				$i_bevande++;
			}


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
					$this->Cell(0, 15, 'Antica Sagra alla Mandria 2016', 10, false, 'C', 0, '', 0, false, 'M', 'M');
				}

				// Page footer
				public function Footer() {
					// Position at 15 mm from bottom
					$this->SetY(-15);
					// Set font
					$this->SetFont('helvetica', 'I', 10);
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
			$pdf->SetFont('', '', 11);
			if($righe_cibo>0){
				// add a page
				$pdf->AddPage('P', 'A5');

				if(($ordine_totale['speciale'])!=NULL)
					$speciale=true;

				//-------------------------------------------------//
				//--------------------------CIBO-------------------//
				//-------------------------------------------------//
				include("prezzo.php");
				// set some text to print
				$txt = 	'
				<table style="border: 1px solid #9A9A9A; padding:5px;">
					<tr style="border: 1px solid #9A9A9A;">
						<td style="border: 1px solid #9A9A9A;">ORDINE:</td>
						<td style="border: 1px solid #9A9A9A; font-size:30px;"><b>'.$ordine.'</b></td>
						<td style="border: 1px solid #9A9A9A;">NOME:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$nome.'</b></td>
					</tr>
					<tr style="border: 1px solid #9A9A9A;">
						<td rowspan="2" valign="middle" style="border: 1px solid #9A9A9A;">TAVOLO:</td>';
						if($tavolo=='servito')
							$txt.='<td rowspan="2" style="border: 1px solid #9A9A9A;"></td>';
						else
							$txt.='<td rowspan="2" style="border: 1px solid #9A9A9A;"><b>'.$tavolo.'</b></td>';
						$txt.='<td style="border: 1px solid #9A9A9A;">COPERTO:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$coperto.'</b></td>
					</tr>
					<tr style="border: 1px solid #9A9A9A;">
						<td style="border: 1px solid #9A9A9A;">DATA - ORA:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$anno."\n".$ora.'</b></td>
					</tr>
					<tr style="border: 1px solid #9A9A9A;">
						<td style="border: 1px solid #9A9A9A;">PREZZO TOT:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$prezzo.' €</b></td>
						<td style="border: 1px solid #9A9A9A;">CASSA:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$_SESSION['cassa'].'</b></td>
					</tr>';
				if($speciale){
					$txt.=	'<tr>
								<td style="border: 1px solid #9A9A9A;">SCONTO: </td>
								<td style="border: 1px solid #9A9A9A;"><b>'.$ordine_totale['speciale'].'</b></td>
							</tr>';
				}
				$txt.='</table>';
				$pdf->writeHTML($txt, true, false, true, false, '');

				$txt2='<table style="border: 1px solid #9A9A9A; padding:5px;">
						<tr>
							<td colspan="5" style="border: 1px solid #9A9A9A;"><b>NOME</b></td>
							<td style="border: 1px solid #9A9A9A;"><b>Q.TA</b></td>';

							if(!$speciale){
								$txt2.= '<td style="border: 1px solid #9A9A9A;"><b>P. UNIT</b></td>
										<td style="border: 1px solid #9A9A9A;"><b>P. TOT</b></td>';
							}//if
						$txt2.='</tr>';

				for($h=0;$h<$righe_cibo;$h++){
					$txt2.='
					<tr>';
						if(($descrizione_cibo[$h]=="Bistecca di cavallo + Polenta")||($descrizione_cibo[$h]=="Tagliata con Rucola + Polenta")||($descrizione_cibo[$h]=="Tagliata Aceto Balsamico + Polenta")||($descrizione_cibo[$h]=="Tagliata al rosmarino + Polenta")){
							$txt2.='<td colspan="5" style="border: 1px solid #9A9A9A;"><strong>'. $descrizione_cibo[$h] . '</strong></td>';
						}
						else
							$txt2.='<td colspan="5" style="border: 1px solid #9A9A9A;">'. $descrizione_cibo[$h] . '</td>';
						$txt2.='<td style="border: 1px solid #9A9A9A;">'.$quantita_cibo[$h].'</td>';
						if(!$speciale){
							$txt2.='<td style="border: 1px solid #9A9A9A;">'.$prezzo_cibo_unitario[$h].'€</td>
							<td style="border: 1px solid #9A9A9A;">'.number_format($prezzo_cibo_unitario[$h] * $quantita_cibo[$h],2,'.','').'€</td>';
						}//if
					$txt2.='</tr>';
					if(($h%11==0)&&($h!=0)){
						$txt2.= '</table>';
						$pdf->writeHTML($txt2, true, false, true, false, '');
						$pdf->AddPage('P', 'A5');
						$txt2=$txt;
						$pdf->writeHTML($txt2, true, false, true, false, '');
						$txt2='<table style="margin-top:10px; border: 1px solid #9A9A9A; padding:5px;">';
					}

				}//for
				$txt2.='</table>';
				$pdf->writeHTML($txt2, true, false, true, false, '');
				//echo $txt2;

			}//if se le righe del cibo sono zero

			//-------------------------------------------------//
			//-----------------------BEVANDE-------------------//
			//-------------------------------------------------//
			include("prezzo.php");
			if($righe_bevande>0){
				include("prezzo.php");
				$prezzo_tot=$somma_cibo+$somma_bevande;
				// add a page
				$pdf->AddPage('P', 'A5');
				// set some text to print
				$txt = 	'
				<table style="border: 1px solid #9A9A9A; padding:5px;">
					<tr>
						<td style="border: 1px solid #9A9A9A;">ORDINE:</td>
						<td style="border: 1px solid #9A9A9A; font-size:30px;"><b>'.$ordine.'</b></td>
						<td style="border: 1px solid #9A9A9A;">NOME:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$nome.'</b></td>
					</tr>
					<tr>
						<td rowspan="2" valign="middle" style="border: 1px solid #9A9A9A;">TAVOLO:</td>
						<td rowspan="2" style="border: 1px solid #9A9A9A;"></td>
						<td style="border: 1px solid #9A9A9A;">COPERTO:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$coperto.'</b></td>
					</tr>
					<tr>
						<td style="border: 1px solid #9A9A9A;">DATA:<br/> ORA:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$anno."\n".$ora.'</b></td>
					</tr>
					<tr style="border: 1px solid #9A9A9A;">
						<td style="border: 1px solid #9A9A9A;">PREZZO TOT:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$prezzo.' €</b></td>
						<td style="border: 1px solid #9A9A9A;">CASSA:</td>
						<td style="border: 1px solid #9A9A9A;"><b>'.$_SESSION['cassa'].'</b></td>
					</tr>';
				if($speciale){
				$txt.=	'<tr>
							<td style="border: 1px solid #9A9A9A;">SCONTO: </td>
							<td style="border: 1px solid #9A9A9A;"><b>'.$ordine_totale['speciale'].'</b></td>
						</tr>';
				}
				$txt.='</table>';
				$pdf->writeHTML($txt, true, false, true, false, '');

				$txt2='<table style="border: 1px solid #9A9A9A; padding:5px;">
						<tr>
							<td colspan="5" style="border: 1px solid #9A9A9A;"><b>NOME</b></td>
							<td style="border: 1px solid #9A9A9A;"><b>Q.TA</b></td>';
							if(!$speciale){
								$txt2.='<td style="border: 1px solid #9A9A9A;"><b>PR.ZO UNIT.</b></td>
								<td style="border: 1px solid #9A9A9A;"><b>PR.ZO TOTALE</b></td>';
							}//if
						$txt2.='</tr>';

				for($h=0;$h<$righe_bevande;$h++){
					$txt2.='
					<tr>
						<td colspan="5" style="border: 1px solid #9A9A9A;">'.$nome_bevande[$h].'</td>
						<td style="border: 1px solid #9A9A9A;">'.$quantita_bevande[$h].'</td>';
						if(!$speciale){
							$txt2.='<td style="border: 1px solid #9A9A9A;">'.$prezzo_bevande_unitario[$h].'€</td>
							<td style="border: 1px solid #9A9A9A;">'.number_format($prezzo_bevande_unitario[$h] * $quantita_bevande[$h],2,'.','').'€</td>';
						}//if
						$txt2.='</tr>';
						if(($h%12==0)&&($h!=0)){
						$txt2.= '</table>';
						$pdf->writeHTML($txt2, true, false, true, false, '');
						$pdf->AddPage('P', 'A5');
						$txt2=$txt;
						$pdf->writeHTML($txt2, true, false, true, false, '');
						$txt2='<table style="margin-top:10px; border: 1px solid #9A9A9A; padding:5px;">';
					}
				}//for
				$txt2.='</table>';
				$pdf->writeHTML($txt2, true, false, true, false, '');

			}//if se le bevande sono a zero
			// ---------------------------------------------------------
			// write some JavaScript code
			$js = 'app.alert("JavaScript Popup Example", 3, 0, "Welcome");';

			// force print dialog
			$js .= 'print(true);';

			// set javascript
			$pdf->IncludeJS($js);

			//Close and output PDF document
			$pdf->Output('../ordini/ordine'.$ordine.'.pdf', 'FI');
		}
	}
?>
