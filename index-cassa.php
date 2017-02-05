<?php
	$pagetitle = "Cassa";
	$script = "cassa/index-cassa.js";
	$style = "includes/style.css";
	include_once("includes/config.php");

	if (isset($_POST['cassiere'])) {
		//Ottenimento variabili della cassa
		$cassiere = $_POST['cassiere'];
		$cassa = $_POST['cassa'];
		$data_inizio = date("Y-m-d H:i:s");
		$saldo_iniziale = $_POST['saldo'];

		//Scrittura nelle variabili di sessione
		$_SESSION['saldo_iniziale'] = $saldo_iniziale;
		$_SESSION['cassiere'] = $cassiere;
		$_SESSION['cassa'] = $cassa;
		$menu = true;

		//Nuova cassa
		$inserisci_cassa_query = "INSERT INTO `" . $prefix . "casse` (`cassiere`, `cassa`, `saldo_iniziale`, `ora_inizio`)
														VALUES ('$cassiere', '$cassa', '$saldo_iniziale', '$data_inizio');";
		mysqli_query($dbconn, $inserisci_cassa_query);
		echo mysqli_error($dbconn);
		$id_cassa = mysqli_insert_id($dbconn);
		$_SESSION['id_cassa'] = $id_cassa;
	}

	if (!isset($_SESSION['cassiere']))
		$menu = false;
	else {
		$cassiere = $_SESSION['cassiere'];
		$cassa = $_SESSION['cassa'];
		$saldo_iniziale = $_SESSION['saldo_iniziale'];
		$id_cassa = $_SESSION['id_cassa'];
		$menu = true;

		//Calcolo dei soldi in cassa
		$query_soldi_cassa = "SELECT SUM(`prezzo_totale`) AS `totale` FROM `" . $prefix . "ordini` WHERE `cassa` = '$id_cassa';";
		$risultato = mysqli_fetch_array(mysqli_query($dbconn, $query_soldi_cassa));
		$soldi_attuali = $risultato['totale'] + $saldo_iniziale;
	}
	include_once("includes/head.php");
?>
	<div id="header-ordini" class="dati">
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" onsubmit="return validaCassiere();">
		<div class="header-ordini">
			<label>Cassiere: </label>
			<?php if (!$menu) { ?>
			<input class="text_ordine" type="text" name="cassiere" value=""/>
			<?php } else { ?>
				<strong class="big"><?php echo $cassiere; ?></strong>
			<?php } ?>
		</div>
		<div class="header-ordini">
			<label>Cassa: </label>
			<?php if (!$menu) { ?>
			<input class="text_ordine" type="text" name="cassa" value=""/>
			<?php } else { ?>
				<strong class="big"><?php echo $cassa; ?></strong>
			<?php } ?>
		</div>
		<div class="header-ordini">
			<?php if (!$menu) { ?>
				<label>Saldo iniziale: </label>
				<input class="text_ordine" type="text" name="saldo" />
			<?php } else { ?>
				<label>In cassa hai</label>
				<strong class="big"><?php echo number_format($soldi_attuali,2,","," "); ?> €<strong>
			<?php } ?>
		</div>
		<?php if (!$menu) { ?>
		<div class="header-ordini">
			<br/><input class="continua" type="submit" value="Continua!" />
		</div>
		<?php } ?>
	</form>
	</div>
	<?php if ($menu) { ?>
	<div class="dati">
		<a class="button verde" href="cassa/cassa.php">Cassa</a><br/>
		<a class="button verde" href="cassa/vis-ordini.php">Visualizza Ordini</a><br/>
		<a class="button blu"   href="cassa/fast-pay.php">Fast Pay</a><br/>
		<a class="button rosso" href="cassa/ordine-speciale.php">Ordine Speciale</a>
	</div>
	<?php }
	include_once("includes/footer.php"); ?>
