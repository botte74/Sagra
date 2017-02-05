<?php
	$pagetitle = "Sagra Parrocchia di Mandria - CASSA";
	$script = "cassa.js";
	$style = "../includes/style.css";

	include_once("../includes/config.php");

	$giorno = $_SESSION['giorno'];

	//Controllo sullo stato di cassa e cassiere
	if (!isset($_SESSION['id_cassa']))
		header("Location: ../index-cassa.php");

	//CREAZIONE DELL'ORDINE (Solo Stato)
	if (!isset($_SESSION['ordine']) ) {
		$id_cassa = $_SESSION['id_cassa'];
		$ordine_query = "INSERT INTO `" . $prefix . "ordini` (`stato`, `prezzo_totale`, `cassa`,`tipo`) VALUES ('ibernato', '0', '$id_cassa',1);";
		mysqli_query($dbconn, $ordine_query);
		echo mysqli_error($dbconn);
		$ordine = mysqli_insert_id($dbconn);
		$_SESSION['ordine'] = $ordine;
		$prezzo = "0.00";
		$nome="";
		$tavolo="";
		$coperto="";
	}

	else {
		//Dati dell'ordine che arrivano dalle pagine precedenti
		$ordine = $_SESSION['ordine'];
		if (isset($_GET['ordine'])) {
			$ordine = $_GET['ordine'];
		}

		$query_ordine = "SELECT * FROM `" . $prefix . "ordini` WHERE `id_ordine` = '$ordine';";
		$ordine_database = mysqli_fetch_array(mysqli_query($dbconn, $query_ordine));
		echo mysqli_error($dbconn);

		$nome = $ordine_database['nome_cliente'];
		$coperto = $ordine_database['coperto'];
		$tavolo = $ordine_database['tavolo'];
		$speciale = $ordine_database['speciale'];
		if ($speciale != null) {
			$_SESSION['ordine_speciale'] = true;
			$prezzo = $ordine_database['prezzo_totale'];
			$_SESSION['ordine_prezzo'] = $prezzo;
		} else {
			//Calcolo del prezzo
			include("prezzo.php");
			//Prezzo in variabile $prezzo
		}
	}

	//Composizione del menù
	$piatti_query = "SELECT * FROM `" . $prefix . "piatti` WHERE `ordinabile` = 1 AND `" . $giorno . "` = 1 ORDER BY `tipologia`,`ordine`;";
	$piatti = mysqli_query($dbconn,$piatti_query);
	echo mysqli_error($dbconn);
	$tipologie = array('0-Menu','1-Primo','2-Secondo','3-Contorno','6-paninoteca');
	$nome_tipologie = array("Menù","Primo","Secondo","Contorno","Bevande");
	$contatore_tipologie = 0;

	function quantita_variante($cod_piatto, $cod_variante, $ordine) {
		//OTTENIMENTO DELLA QUANTIT� INSERITA
		$query_piatto = "SELECT * FROM `" . $prefix . "ordini_composizione`
							WHERE `id_ordine`='$ordine'
							AND `id_piatto`='$cod_piatto'
							AND `var` = '$cod_variante'";
		$quantita = mysqli_fetch_array(mysqli_query($dbconn, $query_piatto));
		$ritorno = $quantita['quantita'];
		return $ritorno;
	}

	include_once("../includes/head.php");
?>
<div class="ordini">
	<form id="form-ordine" action="conferma-ordine.php" method="POST" onsubmit="return validaForm();">
	<p>Ordine Numero: <?php echo $ordine; ?></p>
	<div id="header-ordini">
		<div class="header-ordini">
			<label>Nome: </label>
			<input class="text_ordine" type="text" name="nome" value="<?php echo $nome; ?>"/>
		</div>
		<div class="header-ordini">
			<label>Numero Coperti: </label>
			<input class="text_ordine" type="text" name="coperto" value="<?php echo $coperto; ?>"/>
		</div>
		<div class="header-ordini">
			<label>Tipologia Ordine</label>
			<select class="tipologia" name="tavolo">
				<option value="tavolo" <?php if ($tavolo == "tavolo") { echo "selected"; } ?> >Servito</option>
				<option value="asporto" <?php if ($tavolo == "asporto") { echo "selected"; } ?> >Asporto</option>
			</select>
		</div>
		<div class="header-ordini">
			<label>Prezzo Totale:</label>
			<strong id="prezzo" class="big"><?php echo $prezzo; ?> €<strong>
		</div>
	</div>
	</form>

	<div id="menu">
		<table class="data-table">
			<tr class="data-table">
				<th class="data-table">Nome Piatto</th>
				<th class="data-table">Descrizione</th>
				<th class="data-table">Prezzo</th>
				<th class="data-table">Quantita</th>
			</tr>
		<?php while ($piatto = mysqli_fetch_array($piatti)) { ?>
			<!-- ###########      TIPOLOGIE DI PIATTO    ############-->
			<?php
			if(	$contatore_tipologie>=0 && $contatore_tipologie<count($nome_tipologie)){
				if($tipologie[$contatore_tipologie] == $piatto['tipologia']) {
						echo '<tr><td colspan="4" id="tipologia" class="data-table">'.$nome_tipologie[$contatore_tipologie].'</td></tr>';
						if ($contatore_tipologie < count($nome_tipologie))
							$contatore_tipologie++;
				}
			}
			$has_varianti = ($piatto['varianti'] == 1);
			$codice_piatto = $piatto['codice'];
			?>
			<!-- ############## Fine tipologie piatto ###############-->
			<?php if ($has_varianti) {
				//OTTENIMENTO DELLE VARIANTI

				$query_varianti = "SELECT `codice_alimento`, `nome` FROM `" . $prefix . "varianti`, `" . $prefix . "alimentari`
								WHERE `codice_piatto` = '$codice_piatto' AND `codice` = `codice_alimento` ORDER BY `codice_alimento`";
				$varianti = mysqli_query($dbconn, $query_varianti);
				echo mysqli_error($dbconn);
				$num_varianti = mysqli_num_rows($varianti);
				$contatore_varianti = 0;

				$query_varianti_quantita = "SELECT * FROM `" . $prefix . "ordini_composizione` WHERE id_ordine = '$ordine' AND id_piatto = '$codice_piatto' ORDER BY `var`;";
				$varianti_inserite = mysqli_query($dbconn, $query_varianti_quantita);
				echo mysqli_error($dbconn);
				//$num_varianti_inserite = mysqli_num_rows($varianti_inserite);
				$contatore_varianti_inserite = 0;

				$inserted_variants = array();

				//Tratto le varianti gi� inserite
				while ($variante_attuale = mysqli_fetch_array($varianti_inserite)) {
					$codice_variante = $variante_attuale['var'];

					$inserted_variants[$codice_variante] = true;

					$query_variante = "SELECT `nome` FROM `" . $prefix . "alimentari` WHERE `codice` = '$codice_variante'";
					$variante = mysqli_fetch_array($varianti);
					$nome_variante = $variante['nome'];
					$varianti_option = mysqli_query($query_variante);
					$variante_option = mysqli_fetch_array($varianti_option);

					 ?>

					<tr class="data-table" id="piatto-<?php echo $codice_piatto . "-" . $contatore_varianti; ?>">
						<td class="data-table"><?php echo $piatto['nome']; ?></td>
						<td class="data-table"><?php echo $piatto['descrizione'] . $variante_option['nome']; ?></td>
						<td class="data-table"><?php echo $piatto['prezzo']; ?></td>
						<td class="data-table">
						<form id="form-<?php echo $codice_piatto; ?>-<?php echo $contatore_varianti; ?>">
							<input type="hidden" value="<?php echo $codice_variante; ?>" name="variante" />
							<input type="hidden" name="azione" value="modifica" />
							<input class="quantita" type="text" onchange="inviaDati(<?php echo $codice_piatto; ?>, <?php echo $contatore_varianti; ?>)" name="quantita" id="select-<?php echo $codice_piatto; ?>-<?php echo $contatore_varianti; ?>" />
							<script type="text/javascript">quantita(<?php echo $codice_piatto; ?>, <?php echo $codice_variante; ?>, <?php echo $contatore_varianti; ?>)</script>
						</form>
						</td>
						<?php
						$contatore_varianti++;
				}

				$contatore_varianti_2 = 0;
				//Tratto quelle ancora da inserire
				while ($contatore_varianti < $num_varianti) {
					//Per ogni variante faccio sta roba
					$variante = mysqli_fetch_array($varianti);
					$codice_variante = $variante['codice_alimento'];
					$nome_variante = $variante['nome'];
					$varianti_option = mysqli_query($dbconn, $query_varianti);	?>
					<tr class="data-table" style="display:<?php echo ($contatore_varianti_2 == 0) ? "" : "none"; ?>;" id="piatto-<?php echo $codice_piatto . "-" . $contatore_varianti; ?>">
						<td class="data-table"><?php echo $piatto['nome']; ?></td>
						<td class="data-table">
							<form>
								<?php echo $piatto['descrizione']; ?>
								<select class="varianti" name="varianti" onchange="modificaID(this.value, <?php echo $codice_piatto; ?>, this, <?php echo $contatore_varianti; ?>)">
								<?php if (!$display_variante) { ?>
									<option value="nothing">Seleziona variante...</option>
									<?php while ($variante_option = mysqli_fetch_array($varianti_option)) {
										$code_variante = $variante_option['codice_alimento'];
										if ($inserted_variants[$code_variante] == true)
											$inserita = true;
										else
											$inserita = false;?>
										<option name="variante-<?php echo $codice_piatto; ?>-<?php echo $variante_option['codice_alimento']; ?>" value="<?php echo $variante_option['codice_alimento']; ?>" <?php if ($inserita) { echo 'disabled="disabled"'; } ?>><?php echo $variante_option['nome']; ?></option>
									<?php }//Ciclo per varianti possibili
								}// variante non gi� inserita
								else { ?>
									<option name="variante-<?php echo $codice_piatto; ?>-<?php echo $variante_option['codice_alimento']; ?>" value="<?php echo $variante_option['codice_alimento']; ?>"><?php echo $variante_option['nome']; ?></option>
								<?php } ?>
							</select></form>
						</td>
						<td class="data-table"><?php echo $piatto['prezzo']; ?></td>
						<td class="data-table">
							<form id="form-<?php echo $codice_piatto; ?>-<?php echo $contatore_varianti; ?>">
								<input type="hidden" value="0" name="variante" />
								<input type="hidden" name="azione" value="inserisci" />
								<input class="quantita" type="text" disabled="disabled" onchange="inviaDati(<?php echo $codice_piatto; ?>, <?php echo $contatore_varianti; ?>)" name="quantita" id="select-<?php echo $codice_piatto; ?>-<?php echo $contatore_varianti; ?>" />
								<script type="text/javascript">
									quantita(
										<?php echo $codice_piatto; ?>, <?php echo $codice_variante; ?>, <?php echo $contatore_varianti; ?>)
								</script>
							</form>
						</td>
					</tr><?php
					$contatore_varianti++;
					$contatore_varianti_2++;
				}//Fine riga per ogni variante
			}//Chiuso if $has_varianti
			else { ?>
				<tr class="data-table">
					<td class="data-table"><?php echo $piatto['nome']; ?></td>
					<td class="data-table"><?php echo $piatto['descrizione']; ?></td>
					<td class="data-table"><?php echo $piatto['prezzo']; ?></td>
					<td class="data-table">
						<form id="form-<?php echo $codice_piatto; ?>-0">
							<input type="hidden" value="0" name="variante" />
							<input type="hidden" name="azione" value="inserisci" />
							<input class="quantita" type="text" onchange="inviaDati(<?php echo $codice_piatto; ?>, 0)" name="quantita" id="select-<?php echo $codice_piatto; ?>-0" />
							<script type="text/javascript"> quantita( <?php echo $codice_piatto; ?> , 0, 0); </script>
						</form>
					</td>
				</tr>
		<?php }// Chiuso else se non ha varianti
	}//piatti ?>
		</table>
	</div>
	<div id="reset" >
		<a href="conferma-ordine.php?azione=nuovo" class="button rosso grande">Reset Ordine</a>
	</div>
	<div id="conferma">
		<a href="javascript:formSubmit();" class="button verde grande">Conferma Ordine</a>
	</div>
</div>
<?php include_once("../includes/footer.php"); ?>
