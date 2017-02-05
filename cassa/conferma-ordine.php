<?php
	$pagetitle = "Conferma Ordine";
	$script = "conferma-ordine.js";
	$style = "../includes/style.css";

	include_once("../includes/config.php");

	//Controllo sull'ordine
	if(isset($_POST['ordine'])){
		$_SESSION['ordine']= $_POST['ordine'];
		$ordine = $_SESSION['ordine'];
	}//if

	if(isset($_SESSION['ordine'])) {
		$ordine = $_SESSION['ordine'];
	} else {
		header("Location: cassa.php");
	}

	//Nuovo Ordine
	if (isset($_GET['azione'])) {
		$azione = $_GET['azione'];
		if ($azione == "nuovo") {
			$_SESSION['ordine'] = null;
			unset($_SESSION['ordine']);

			$_SESSION['ordine_speciale'] = null;
			$_SESSION['ordine_prezzo'] = null;
			unset($_SESSION['ordine_speciale']);
			unset($_SESSION['ordine_prezzo']);

			if (isset($_GET['speciale']))
				header("Location: ordine-speciale.php");
			else
				header("Location: cassa.php");
		}
	}

	//Modifica dei dati dell'ordine
	if (isset($_POST['nome'])) {
		//Ottenimento delle variabili
		$nome = $_POST['nome'];
		$coperto = $_POST['coperto'];
		$tavolo = $_POST['tavolo'];
		$data = date("Y-m-d H:i:s");
		$id_cassa = $_SESSION['id_cassa'];

		if(!(isset($_POST['stato'])))
			$stato = "confermato";
		else
			$stato = $_POST['stato'];

		//Calcolo del prezzo
		include("prezzo.php");
		//Prezzo in variabile $prezzo

		//Modifica nel database
		if (isset($_SESSION['ordine_speciale']))
			$ordine_query_update = "UPDATE `" . $prefix . "ordini`
								SET
									`tavolo` = '$tavolo',
									`nome_cliente` = '$nome',
									`coperto` = '$coperto',
									`cassa` = '$id_cassa',
									`prezzo_totale` = '$prezzo',
									`stato` = '$stato'
								WHERE id_ordine = '$ordine';";
		else
			$ordine_query_update = "UPDATE `" . $prefix . "ordini`
								SET
									`tavolo` = '$tavolo',
									`nome_cliente` = '$nome',
									`coperto` = '$coperto',
									`data_ordine` = '$data',
									`cassa` = '$id_cassa',
									`prezzo_totale` = '$prezzo',
									`stato` = '$stato'
								WHERE id_ordine = '$ordine';";
		mysqli_query($dbconn, $ordine_query_update);
		echo mysqli_error($dbconn);


		$query_riepilogo=
			"SELECT `piatti`.`nome`, `quantita`, `prezzo`, `codice`, `descrizione`, `var`
			FROM	`" . $prefix . "piatti` AS piatti,
					`" . $prefix . "ordini` AS ordini,
					`" . $prefix . "ordini_composizione` AS oc
			WHERE
				oc.id_ordine = '$ordine' AND
				oc.id_ordine = ordini.id_ordine AND
				oc.id_piatto = piatti.codice
			ORDER BY `tipologia`;";

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
	}

	$ordine_stampato = false;

	$piatti_query = "SELECT * FROM `" . $prefix . "piatti` ORDER BY `tipologia`,`ordine`";
	$piatti = mysqli_query($dbconn,$piatti_query);
	echo mysqli_error($dbconn);
	$tipologie = array('1-Menu','2-Primo','3-Secondo','4-Contorno','5-Bevanda');
	$nome_tipologie = array("Menù","Primo","Secondo","Contorno","Bevande");
	$contatore_tipologie = 0;

	include_once("../includes/head.php");
?>

<!-- Riepilogo... Il Cliente Paga... Altro link che rimanda alla cassa di nuovo -->
<div class="dati">
	<?php echo "Ordine numero: " . $ordine; ?>
	<div id="header-ordini">
		<div id="divNome" class="header-ordini">
			<p>Nome:<br /><strong class="big"><?php echo $nome; ?></strong></p>
		</div>
		<div id="divNome" class="header-ordini">
			<p>Coperti:<br /><strong class="big"><?php echo $coperto; ?></strong></p>
		</div>
		<div class="header-ordini">
			<p>Tipologia:<br /><strong class="big"><?php if ($tavolo == 'tavolo') { echo "Servito"; } else {echo "Asporto"; } ?></strong></p>
		</div>
		<div class="header-ordini">
			<p>Prezzo Totale:<br />
			<strong class="big" id="prezzo"><?php echo $prezzo ?> €<strong></p>
		</div>
		</form>
	</div>

	<table class="data-table">
		<tr class="data-table">
			<th class="data-table">Nome</th>
			<th class="data-table">Prezzo Unitario</th>
			<th class="data-table">Quantita</th>
			<th class="data-table">Prezzo Totale</th>
		</tr>
	<?php $piatti_ordine=mysqli_query($dbconn,$query_riepilogo);
		for($h=0;$h<$righe;$h++){ ?>
			<?php if($tipologie[$contatore_tipologie] == $piatto_ordine['tipologia']) { ?>
				<tr><td colspan="4" id="tipologia" class="data-table"><?php echo $nome_tipologie[$contatore_tipologie]; ?></td></tr>
			<?php if($contatore_tipologie < count($nome_tipologie)-1) {$contatore_tipologie++;}}  ?>
			<tr class="data-table">
				<td class="data-table"><?php echo $descrizione[$h]; ?></td>
				<td class="data-table"><?php echo $prezzo_unitario[$h]; ?></td>
				<td class="data-table"><?php echo $quantita[$h]; ?></td>
				<td class="data-table"><?php echo number_format($prezzo_unitario[$h] * $quantita[$h],2,'.',''); ?></td>
			</tr>
		<?php } ?>
	</table>
	<br />
	<div>
		<table border="0" align="center">
			<tr>
				<td><a id="modificaordine" class="button rosso grande" href="cassa.php">Modifica</a></td>
				<td><a id="pagaestampa" class="button verde grande" href="crea-pdf.php?pagato=true" target="_new" onclick="javascript:paga();">Paga e Stampa</a></td>
				<td><a id="nuovoordine" class="button rosso grande" href="conferma-ordine.php?azione=nuovo" style="visibility:hidden;">Nuovo Ordine</a></td>
			</tr>
			<?php if (isset($_SESSION['ordine_speciale'])) { ?>
				<tr>
					<td colspan="2"></td>
					<td><a id="nuovospeciale" class="button rosso grande" href="conferma-ordine.php?azione=nuovo&speciale=true" style="visibility:hidden;">Nuovo Ordine SPECIALE</a></td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<div style="width:50%; margin:auto;">
		<h1>Resto</h1>
		<h2>Ti danno:</h2>
		<input class="text_ordine" type="text" id="acconto" onchange="resto()" />
		<h2>Devi dare:</h2><h3 id="resto"></h3>
	</div>
</div>
<?php include("../includes/footer.php"); ?>
