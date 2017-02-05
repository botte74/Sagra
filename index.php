<?php
	$pagetitle = "Sagra Parrocchia di Mandria - Fast Pay";
	$script = "cassa/cassa-fast-pay.js";
	$style = "includes/style.css";

	include_once("includes/config.php");

	//Salvataggio giorno settimana
		$giorni = array('domenica','lunedi','martedi','mercoledi','giovedi','venerdi','sabato');
		$_SESSION['giorno'] = $giorni[date('w',strtotime("now"))];
		$giorno = $_SESSION['giorno'];
		//$giorno = 'sabato';

	//CREAZIONE DELL'ORDINE (Solo Stato)
	if (!isset($_SESSION['ordine']) ) {
		$ordine_query = "INSERT INTO `" . $prefix . "ordini` (`stato`, `prezzo_totale`) VALUES ('fastpay', '0');";
		mysqli_query($dbconn, $ordine_query);
		echo mysqli_error($dbconn);
		$ordine = mysqli_insert_id($dbconn);
		$_SESSION['ordine'] = $ordine;
		$prezzo = "0,00";
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
			include("cassa/prezzo.php");
			//Prezzo in variabile $prezzo
		}
	}

	//Composizione del men�
	$piatti_query = "SELECT * FROM `" . $prefix . "piatti` WHERE `ordinabile` = 1 AND `" . $giorno . "` = 1 ORDER BY `tipologia`,`ordine`;";
	$piatti = mysqli_query($dbconn,$piatti_query);
	echo mysqli_error($dbconn);
	$tipologie = array('0-Menu','1-Primo','2-Secondo','3-Contorno','4-Bevanda');
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

	require_once 'mobile-detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
?>
<!DOCTYPE html>
	<head>
		<title><?php echo $pagetitle; ?></title>
		<meta charset="ISO-8859-15">
		<?php if ( $detect->isMobile() ) { ?>
			<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php } ?>
		<link type="text/css" rel="stylesheet" href="includes/style.css" />
		<?php if (isset($script)) { ?>
			<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
	</head>
	<body <?php if ( $detect->isMobile() ) { /*echo 'style="width:310px"'*/; } ?>>
		<div id="wrapper">
			<h1>Parrocchia di Mandria</h1>
			<h2>Sagra - Fast Pay</h2>
			<p>Inserisci i tuoi dati, e compila il tuo menu! Potrai saltare la coda alle casse!</p>
			<p>Una volta ultimato, tieni a mente il codice dell'ordine, e vai alla cassa dedicata al fast pay, alla paninoteca.</p>
			<p>Buona Cena!</p><br/>
	<div id="header-ordini">
		<form id="form-ordine" action="cassa/conferma-ordine-fast-pay.php" method="POST" onsubmit="return validaForm();">
			<input type="hidden" value="riepilogo" name="pagina" />
			<div class="header_fast">
				<p>Nome: </p>
				<input class="text_ordine" type="text" name="nome" value="<?php echo $nome; ?>"/>
			</div>
			<div class="header_fast">
				<p>Numero Coperti: </p>
				<select class="tipologia" name="coperto" value="<?php echo $coperto; ?>">
					<?php for ($i = 1; $i < 21; $i++) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="header_fast">
				<p>Tipologia Ordine</p>
				<select class="tipologia" name="tavolo">
					<option value="tavolo" <?php if ($tavolo == "tavolo") { echo "selected"; } ?> >Servito</option>
					<option value="asporto" <?php if ($tavolo == "asporto") { echo "selected"; } ?> >Asporto</option>
				</select>
			</div>
			<div class="header_fast">
				<p>Prezzo Totale:</p>
				<strong id="prezzo" class="big"><?php echo $prezzo; ?> €<strong>
			</div>
		</form>
	</div>

	<div id="menu">
		<?php while ($piatto = mysqli_fetch_array($piatti)) { ?>
			<!-- ###########      TIPOLOGIE DI PIATTO    ############-->
			<?php if($tipologie[$contatore_tipologie] == $piatto['tipologia']) { ?>
				<div class="tipologia_piatto">
					<?php echo $nome_tipologie[$contatore_tipologie]; ?>
				</div>
			<?php $contatore_tipologie++;
				}
				$has_varianti = ($piatto['varianti'] == 1);
				$codice_piatto = $piatto['codice'];
			?>
			<!-- ############## Fine tipologie piatto ###############-->
			<?php if ($has_varianti) {
				//OTTENIMENTO DELLE VARIANTI
				$query_varianti = "SELECT `codice_alimento`, `nome` FROM `" . $prefix . "varianti`, `" . $prefix . "alimentari`
								WHERE `codice_piatto` = '$codice_piatto' AND `codice` = `codice_alimento`";
				$varianti = mysqli_query($dbconn, $query_varianti);
				echo mysqli_error($dbconn);
				$num_varianti = mysqli_num_rows($varianti);

				//Array con indice il codice variante, e come valore il suo nome
				$possibili_varianti = array();
				while ($possibile_variante = mysqli_fetch_array($varianti)) {
					$possibili_varianti_nome = $possibile_variante['nome'];
					$possibili_varianti_codice = $possibile_variante['codice_alimento'];
					$possibili_varianti[$possibili_varianti_nome] = $possibili_varianti_codice;
				}

				//for per ogni variante
				foreach ($possibili_varianti as $nome_variante => $codice_variante) {
					//Per ogni variante faccio sta roba
				?>
				<div class="piatto" id="piatto-<?php echo $codice_piatto . "-" . $codice_variante; ?>">
					<h4><?echo $piatto['nome']; ?></h4>
					<div class="immaginequantita">
						<img class="piatto" width="120px" height="120px" src="immagini/<?php echo $piatto['immagine']; ?>" >
						<div class="quantita" id="qta-<?php echo $codice_piatto; ?>-<?php echo $codice_variante; ?>" style="visibility:hidden;">
							<div class="quantitavalore" id="val-<?php echo $codice_piatto; ?>-<?php echo $codice_variante; ?>">0</div>
						</div>
					</div>
						<div class="prezzo_piatto"><?echo $piatto['prezzo']; ?> €</div>
						<div class="descrizione"><span class="descrizione"><?php echo $piatto['descrizione']; ?></span>
						<span class="variante"><?php echo $nome_variante; ?></span></div>
					<div class="clearfix"></div>
					<div align="center" class="modificaquantita">
						<button class="btn btn-danger" onclick="inviaDati(<?php echo $codice_piatto; ?>, <?php echo $codice_variante; ?>, -1)" value="-1">-1</button>
						<button class="btn btn-primary" onclick="inviaDati(<?php echo $codice_piatto; ?>, <?php echo $codice_variante; ?>, 1)">+1</button>
						<script type="text/javascript">quantita(<?php echo $codice_piatto; ?>, 0)</script>
					</div>
					<script type="text/javascript">quantita(<?php echo $codice_piatto; ?>, <?php echo $codice_variante; ?>)</script>
				</div>
				<?php }//for per ogni variante
			}//Chiuso if $has_varianti
			else { ?>
				<div class="piatto">
					<h4><?echo $piatto['nome']; ?></h4>
					<div class="immaginequantita">
						<img class="piatto" width="120px" height="120px" src="immagini/<?php echo $piatto['immagine']; ?>" >
						<div class="quantita" id="qta-<?php echo $codice_piatto; ?>-0" style="visibility:hidden;">
							<div class="quantitavalore" id="val-<?php echo $codice_piatto; ?>-0">0</div>
						</div>
					</div>
						<div class="prezzo_piatto"><?echo $piatto['prezzo']; ?> €</div>
						<div class="descrizione"><span class="descrizione"><?php echo $piatto['descrizione']; ?></span></div>
					<div class="clearfix"></div>
					<div align="center" class="modificaquantita">
						<button class="btn btn-danger" onclick="inviaDati(<?php echo $codice_piatto; ?>, 0, -1)" value="-1">-1</button>
						<button class="btn btn-primary" onclick="inviaDati(<?php echo $codice_piatto; ?>, 0, 1)">+1</button>
						<script type="text/javascript">quantita(<?php echo $codice_piatto; ?>, 0)</script>
					</div>
				</div>
		<?php }// Chiuso else se non ha varianti
		} ?>
	</div>
		<a href="javascript:formSubmit();" class="button verde">Conferma Ordine</a>
<?php include_once("includes/footer.php"); ?>
