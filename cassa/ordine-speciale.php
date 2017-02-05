<?php
	include_once("../includes/config.php");

	$pagetitle = "Ordini Speciali";
	$style = "../includes/style.css";
	$script = "ordine-speciale.js";

	if (isset($_POST['nome'])) {
		$tavolo 	= "tavolo";
		$nome 		= $_POST['nome'];
		$coperto 	= $_POST['coperto'];
		$prezzo 	= $_POST['prezzo'];
		$sconto 	= $_POST['sconto'];
		$ora		= $_POST['ora'];

		$data_speciale = date("Y-m-d H:i:s");
		$data= explode(" ",$data_speciale);
		$anno = $data[0];

		$data_ordine = $anno . " " . $ora;

		$id_cassa = $_SESSION['id_cassa'];

		$query_ordine_speciale = "	INSERT INTO `" . $prefix . "ordini`
									(`stato`, `prezzo_totale`, `cassa`, `nome_cliente`, `tavolo`, `coperto`, `data_ordine`, `fine`, `speciale`)
									VALUES
									('ibernato', '$prezzo', '$id_cassa', '$nome', '$tavolo', '$coperto', '$data_ordine', '$data_ordine', '$sconto')";
		mysqli_query($dbconn,$query_ordine_speciale);
		echo mysqli_error($dbconn);

		$ordine = mysqli_insert_id($dbconn);
		$_SESSION['ordine'] = $ordine;
		$_SESSION['ordine_speciale'] = true;
		$_SESSION['ordine_prezzo'] = $prezzo;

		//echo $data;
		//echo $data_speciale;
		//echo $data_ordine;

		header('Location: cassa.php');
	}

	include_once("../includes/head.php");
?>
<div class="ordini">
	<form id="form-speciale" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
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
			<label>Categoria Sconto</label>
			<select class="tipologia" name="sconto">
				<option value="programmatori">Programmatori</option>
				<option value="volontario">Volontario</option>
				<option value="band">Band</option>
				<option value="animatore">Animatore</option>
				<option value="grest">Grest</option>
			</select>
		</div>
		<div class="header-ordini">
			<label>Orario Cena:</label>
			<select class="tipologia" name="ora">
				<option value="19:00:00">19:00</option>
				<option value="19:30:00">19:30</option>
				<option value="20:00:00">20:00</option>
				<option value="20:30:00">20:30</option>
				<option value="21:00:00">21:00</option>
				<option value="21:30:00">21:30</option>
				<option value="22:00:00">22:00</option>
				<option value="22:30:00">22:30</option>
				<option value="23:00:00">23:00</option>
				<option value="23:30:00">23:30</option>
				<option value="23:59:59">23:59</option>
			</select>
		</div>
		<div class="header-ordini">
			<label>Prezzo Totale:</label>
			<input class="text_ordine" type="text" name="prezzo" value="0.00" />
		</div>
	</div>
	</form>
	<div id="conferma">
		<a href="javascript:inviaForm();" class="button verde grande">Prosegui</a>
	</div>
</div>
<?php include_once("../includes/footer.php"); ?>
