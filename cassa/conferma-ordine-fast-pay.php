<?php
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
		header("Location: ../index.php");
	}
	
	//Nuovo Ordine
	if (isset($_GET['azione'])) {
		$azione = $_GET['azione'];
		if ($azione == "nuovo") {
			$_SESSION['ordine'] = null;
			unset($_SESSION['ordine']);
			header("Location: ../index.php");
		}
	}

	if (!isset($_POST['pagina']))
		header("Location: ../index.php");
	else
		$pagina = $_POST['pagina'];

	if ($pagina == "riepilogo") {
		//Ottenimento delle variabili
		$nome = $_POST['nome'];
		$coperto = $_POST['coperto'];
		$tavolo = $_POST['tavolo'];
		$data = date("Y-m-d H:i:s");
		$stato = "confermato-FP";

		//Calcolo del prezzo
		include("prezzo.php");
		//Prezzo in variabile $prezzo

		//Modifica nel database
		$ordine_query_update = "UPDATE `" . $prefix . "ordini`
								SET
									`tavolo` = '$tavolo',
									`nome_cliente` = '$nome',
									`coperto` = '$coperto',
									`prezzo_totale` = '$prezzo'
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
			$nome_variante = $piatto_ordine['nome'];
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
				$nome_variante = $variante['nome'];
			}
			else{
				$piatto_ordine['descrizione']="";
				$descrizione[$i]=$piatto_ordine['nome'];
			}//else
			$nome_ordine[$i]				= $piatto_ordine['nome'];
			$descrizione[$i]				= $piatto_ordine['descrizione'] . $nome_variante  ;
			$prezzo_unitario[$i] 			= $piatto_ordine['prezzo'];
			$quantita[$i] 					= $piatto_ordine['quantita'];
			$somma+=$quantita[$i]*$prezzo_unitario[$i];
			$i++;
		}

	$piatti_query = "SELECT * FROM `" . $prefix . "piatti` ORDER BY `tipologia`,`ordine`";
	$piatti = mysqli_query($dbconn,$piatti_query);
	echo mysqli_error($dbconn);
	$tipologie = array('1-Menu','2-Primo','3-Secondo','4-Contorno','5-Bevanda');
	$nome_tipologie = array("Menù","Primo","Secondo","Contorno","Bevande");
	$contatore_tipologie = 0;
	}
	
	
	//Modifica dei dati dell'ordine
	if ($pagina == "conferma") {
		$stato = "confermato-FP";
		//Modifica nel database
		$ordine_query_update = "UPDATE `" . $prefix . "ordini`
								SET
									`stato` = '$stato'
								WHERE id_ordine = '$ordine';";
		mysqli_query($dbconn, $ordine_query_update);
		echo mysqli_error($dbconn);
	}

	require_once '../mobile-detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
?>
<!DOCTYPE html>
	<head>
		<title><?php echo $pagetitle; ?></title>
		<meta charset="ISO-8859-15">
		<link type="text/css" rel="stylesheet" href="<?php echo $style; ?>" />
		<?php if ( $detect->isMobile() ) { ?>
			<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php } ?>
	</head>
	<body>
		<div id="wrapper">
			<h1>Parrocchia di Mandria</h1>
			<h2>Sagra - Conferma</h2>
		<?php if ($pagina == "riepilogo") { ?>
			<p>Rileggi i dati inseriti, controlla se hai fatto giusto.</p>
			<p>Se sei sicuro, conferma l'ordine, oppure modificalo.</p>
		<?php } ?>
<div class="dati">
	<?php if ($pagina == "riepilogo") { ?>
	<div class="riepilogo">
		<div id="header-ordini">
			<div class="header_fast">
				<p>Nome:<br /><strong class="big"><?php echo $nome; ?></strong></p>
			</div>
			<div class="header_fast">
				<p>Coperti:<br /><strong class="big"><?php echo $coperto; ?></strong></p>
			</div>
			<div class="header_fast">
				<p>Tipologia:<br /><strong class="big"><?php if ($tavolo == 'tavolo') { echo "Servito"; } else {echo "Asporto"; } ?></strong></p>
			</div>
			<div class="header_fast">
				<p>Prezzo Totale:<br />
				<strong class="big"><?php echo number_format($prezzo,2,","," "); ?></strong></p>
			</div>
		</div>
		<div id="menu">
		<table class="fast">
			<tr class="fast">
				<th class="fast">Prodotto</th>
				<th class="fast">Prezzo</th>
				<th class="fast">Quantita</th>
			</tr>
		<?php $piatti_ordine=mysqli_query($dbconn,$query_riepilogo);
			for($h=0;$h<$righe;$h++){ ?>
				<tr class="fast">
					<td class="fast"><?php echo $descrizione[$h]; ?></td>
					<td class="fast"><?php echo $prezzo_unitario[$h]; ?></td>
					<td class="fast"><?php echo $quantita[$h]; ?></td>
				</tr>
			<?php } ?>
		</table>
		</div>
	</div>
	<?php }// riepilogo
	if ($pagina == "conferma") { ?>
	<div id="menu">
	<p>
		<span class="conferma">Complimenti. Hai effettuato un ordine!</span>
		<span class="conferma">Tieni a mente questo numero, e riferiscilo alla cassa della paninoteca!</span>
		<span class="conferma ordine"> <?php echo $_SESSION['ordine']; ?></span>
	</p>
	<?php } ?>
	<div class="pulsanti">
	<?php if ($pagina == "riepilogo") { ?>
		<a class="button rosso" href="../index.php" style="float:left; margin:15px 50px;">Modifica</a>
		<form method="POST" action="conferma-ordine-fast-pay.php">
			<input type="hidden" value="conferma" name="pagina" />
			<input style="float:left; margin:15px 50px;" type="submit" class="button verde" value="Conferma" />
		</form>
	<?php }
	if ($pagina == "conferma") { ?>
		<a class="button rosso" href="conferma-ordine.php?azione=nuovo">Nuovo Ordine</a>
	<?php } ?>
	</div>
	</div>
</div>
<?php 
	if($_SESSION['user']=="admin")
		include("../includes/footer.php"); ?>
