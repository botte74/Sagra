<?php
	$pagetitle = "Sagra Parrocchia di Mandria - RENDICONTO GIORNALIERO";
	$script="riepilogo/coperti-giorno.js";
	include_once("includes/head.php");

	$giorno=$_SESSION['giorno'];


	$data=date("Y-m-d");

	//------------------COPERTI GIORNALIERI ----------------------------------------//
	$coperti_giorno=0;
	$query_coperti_giorno="SELECT SUM(coperto) AS somma_coperti FROM `".$prefix."ordini` WHERE `data_ordine` LIKE '$data %'";
	$result_giorno=mysqli_query($dbconn,$query_coperti_giorno);
	if($result_giorno) {
		$row_coperti_giorno = mysqli_fetch_array($result_giorno);
		$coperti_giorno+=$row_coperti_giorno['somma_coperti'];
	}//if

	//---------------TOTALE GUADAGNO GIORNALIERO-----------------------------------//
	$tot_giorno=0;
	$query_prezzo_giorno="SELECT SUM(prezzo_totale) AS prezzo_giorno FROM `".$prefix."ordini` WHERE `data_ordine` LIKE '$data %'";
	$result_giorno=mysqli_query($dbconn,$query_prezzo_giorno);
	if($result_giorno){
		$row_prezzo_giorno = mysqli_fetch_array($result_giorno);
		$tot_giorno+=$row_prezzo_giorno['prezzo_giorno'];
	}

	//--------------RIEPILOGO-------------------------------------------------//
	$query_riepilogo=
			"SELECT `piatti`.`nome`, SUM(quantita) AS `quantita`, `prezzo`, `codice`, `descrizione`, `var`
			FROM	`" . $prefix . "piatti` AS piatti,
					`" . $prefix . "ordini` AS ordini,
					`" . $prefix . "ordini_composizione` AS oc
			WHERE
				ordini.data_ordine LIKE '$data %' AND
				oc.id_ordine = ordini.id_ordine AND
				oc.id_piatto = piatti.codice
			GROUP BY `id_piatto`
			ORDER BY `tipologia`";

		$piatti_ordine = mysqli_query($dbconn,$query_riepilogo);

		$nome_ordine				= array();
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
												`var` = '$var';";
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
 ?>

<body>

	<div class="bevande">
		<table>
			<tr>
				<td>GIORNO:</td>
				<td><strong><?php echo $giorno; ?></strong></td>
			</tr>
			<tr>
				<td>COPERTI:</td>
				<td>
					<select onchange="coperti()" id="coperti_minuti">
						<option value="nothing">Seleziona intervallo...</option>
						<option value="15 minuti">15 minuti</option>
						<option value="30 minuti">30 minuti</option>
						<option value="1 ora">1 ora</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>GUADAGNO:</td>
				<td><strong><?php echo number_format($tot_giorno,2,","," ") . " euro"; ?></strong></td>
			</tr>
		</table><br/>

		<table class="data-table" id="chelcazzochetevoi"></table><br/>

		<table class="data-table">
			<tr>
				<th class="data-table">DESCRIZIONE PIATTO</th>
				<th class="data-table">PREZZO UNITARIO</th>
				<th class="data-table">QUANTITA</th>
				<th class="data-table">PREZZO TOTALE</th>
			</tr>
			<?php for($i=0;$i<$h;$i++){ ?>
				<tr class="data-table">
					<td class="data-table"><?php echo $descrizione[$i]; ?></td>
					<td class="data-table"><?php echo $prezzo_unitario[$i]; ?></td>
					<td class="data-table"><?php echo $quantita[$i]; ?></td>
					<td class="data-table"><?php echo number_format($prezzo_unitario[$i] * $quantita[$i],2,"."," "); ?></td>
				</tr>
			<?php } ?>
		</table>
		<form action="riepilogo/pdf-giorno.php" method="POST">
			<input class="conferma" type="submit" name="D" value="SCARICA"/>
		</form><br/>
	</div>

	<div align="right">
		<a class="button verde" href="statistiche.php">Indietro</a>
	</div>
</body>
 <?php include("includes/footer.php"); ?>
