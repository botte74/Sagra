<?php
	$pagetitle = "Sagra Parrocchia di Mandria - CASSA";
	include_once("includes/head.php");

    $giorno = $_SESSION['giorno'];

	//COMPOSIZIONE DEL MEN�
	$piatti_query = "SELECT * FROM `" . $prefix . "piatti` WHERE `ordinabile` = 1 AND `" . $giorno . "` = 1 ORDER BY `tipologia`,`ordine`;";
	$piatti = mysqli_query($dbconn,$piatti_query);
	echo mysqli_error($dbconn);
	$tipologie = array('0-Menu','1-Primo','2-Secondo','3-Contorno','4-Bevanda');
	$nome_tipologie = array("Men�","Primo","Secondo","Contorno","Bevande");
	$contatore_tipologie = 0;


	$header = true;


	/*if (isset($_POST['ordine'])) {
		$nome = $_POST['nome-ordine'];
		$tavolo = $_POST['tavolo-ordine'];
		$coperto =$_POST['coperto-ordine'];

	}*/


	//CREAZIONE DELL'ORDINE (Solo Nome - Servizio e Coperto)
	if (isset($_POST['nome']) && $_POST['nome'] != null ) {
		$nome = $_POST['nome'];
		$coperto =$_POST['coperto'];
		if ($_POST['tavolo'] == 'asporto')
			$tavolo = "asporto";
		else
			$tavolo = "tavolo";
		$header = true;
		$ordine_query = "INSERT INTO `" . $prefix . "ordini` (`nome_cliente`,`tavolo`,`coperto`,`giorno`,`stato`) VALUES ('$nome','$tavolo','$coperto','$giorno', 'ibernato');";
		mysqli_query($dbconn, $ordine_query);
		echo mysqli_error($dbconn);
		$ordine = mysqli_insert_id($dbconn);
	}
	else {
		$ordine = $_POST['ordine'];
	}

	//AGGIUNTA QUANTITA AI PIATTI DELL'ORDINE
	if (isset($_POST['quantita'])) {
		$quantita = $_POST['quantita'];
		$piatto = $_POST['codice-piatto'];
		if (isset($_POST['modifica_quantita'])) {
			//MODIFICA ASSOCIAZIONE
			$query_modifica = "	UPDATE `" . $prefix . "ordini_composizione`
								SET `quantita`='$quantita'
								WHERE
									id_ordine = '$ordine' AND
									id_piatto = '$piatto';";
			mysqli_query($dbconn, $query_modifica);
			echo mysqli_error($dbconn);
		}
		else { //CREAZIONE ASSOCIAZIONE
			$query_inserimento = "INSERT INTO `" . $prefix . "ordini_composizione` (`id_ordine`, `id_piatto`, `quantita`) VALUES ('$ordine', '$piatto', '$quantita');";
			mysqli_query($dbconn, $query_inserimento);
			echo mysqli_error($dbconn);
		}
	}

	//CALCOLO DEL PREZZO
	if($ordine!=null){
		$query_prezzo="SELECT `id_piatto`, `quantita`, `prezzo`
					FROM	`" . $prefix . "piatti` AS piatti,
							`" . $prefix . "ordini` AS ordini,
							`" . $prefix . "ordini_composizione` AS oc
					WHERE
						oc.id_ordine = '$ordine' AND
						oc.id_ordine = ordini.id_ordine AND
						oc.id_piatto = piatti.codice;";
		$piatti_ordine = mysqli_query($dbconn, $query_prezzo);
		$array_piatti_ordine = array();
		$prezzo = 0.00;
		while ($piatto_ordine = mysqli_fetch_array($piatti_ordine) ) {
			$prezzo += $piatto_ordine['prezzo'] * $piatto_ordine['quantita'];
			$array_piatti_ordine[$piatto_ordine['id_piatto']] = $piatto_ordine['quantita'];
		}
		echo mysqli_error($dbconn);
	}
?>
<div class="ordini">
	<div id="menu">
		<table class="data-table">
			<tr class="data-table">
				<th class="data-table">Codice</th>
				<th class="data-table">Nome Piatto</th>
				<th class="data-table">Descrizione</th>
				<th class="data-table">Prezzo</th>
				<th class="data-table">Quantita</th>
			</tr>
		<?php while ($piatto = mysqli_fetch_array($piatti)) { ?>
			<?php if($tipologie[$contatore_tipologie] == $piatto['tipologia']) { ?>
				<tr><td colspan="5" id="tipologia" class="data-table"><?php echo $nome_tipologie[$contatore_tipologie]; ?></td></tr>
			<?php $contatore_tipologie++;}  ?>
			<tr class="data-table">
				<td class="data-table"><?php echo $piatto['codice']; ?></td>
				<td class="data-table"><?php echo $piatto['nome']; ?></td>
				<td class="data-table"><?php echo $piatto['descrizione']; ?></td>
				<td class="data-table"><?php echo number_format($piatto['prezzo'],2,","," "); ?></td>
				<td class="data-table">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
						<input type="hidden" value="<?php echo $ordine; ?>" name="ordine" />
						<input type="hidden" value="<?php echo $piatto['codice']; ?>" name="codice-piatto" />
						<input type="hidden" value="<?php echo $nome; ?>" name="nome-ordine" />
						<input type="hidden" value="<?php echo $coperto; ?>" name="coperto-ordine" />
						<input type="hidden" value="<?php echo $tavolo; ?>" name="tavolo-ordine" />
						<?php
							$codice_piatto = $piatto['codice'];
							$query_piatto = "SELECT * FROM `" . $prefix . "ordini_composizione` WHERE `id_ordine`='$ordine' AND `id_piatto`='$codice_piatto'";
							$riga = mysqli_fetch_array(mysqli_query($dbconn, $query_piatto));

							?>



							<?php if ($riga) { ?>
								<input type="hidden" name="modifica_quantita" />
							<?php } ?>


							<select onchange="this.form.submit()" name="quantita" >
							<?php for ($i=0;$i<=20;$i++) {
								if ($riga && $riga['quantita']==$i) { ?>
									<option value="<?php echo $i; ?>" selected="selected"><?php echo $i; ?></option>
								<?php } else { ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>


							<?php } ?>
							</select>
							<!--

							if ($riga) {//PIATTO GI� INSERITO: DA MODIFICARE
								$quantita_piatto = $riga['quantita']; ?>
								<p><?php echo $quantita_piatto; ?></p>
							<?php //} else {//RIGA NON ESISTE ?>




							-->
							<?php //} ?>
					</form></td>
			</tr>
		<?php } ?>
		</table>
	</div>
</div>
<?php
	if($_SESSION['user']=="admin")
		include("includes/footer.php"); ?>
