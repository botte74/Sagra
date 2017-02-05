<?php
	$pagetitle = "Sagra Parrocchia di Mandria - Fast Pay";
	$style = "../includes/style.css";
	include_once("../includes/head.php");

	if(isset($_POST['ordine'])){
		$ordine=$_POST['ordine'];
		$_SESSION['ordine']=$ordine;
		$query_ordine = "SELECT * FROM `" . $prefix . "ordini` WHERE `id_ordine` = '$ordine';";
		$ordine_database = mysqli_fetch_array(mysqli_query($dbconn, $query_ordine));
		echo mysqli_error($dbconn);

		$nome = $ordine_database['nome_cliente'];
		$coperto = $ordine_database['coperto'];
		$tavolo = $ordine_database['tavolo'];
		include("prezzo.php");
		//Prezzo in variabile $prezzo
	}//if

?>
	<div class="ordini">
		<div align="center">
			<h1>Inserisci il codice dell'Ordine</h1>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input class="textOrdine" type="text" name="ordine"></input><br/>
				<input class="button" type="submit" value="VISUALIZZA ORDINE"></input><br/>
			</form>
			<?php if($ordine!=0){ ?>
				<form action="conferma-ordine.php" method="POST">
					<table class="data-table">
						<tr>
							<th class="data-table">ORDINE</th>
							<th class="data-table">NOME</th>
							<th class="data-table">COPERTO</th>
							<th class="data-table">TAVOLO</th>
							<th class="data-table">PREZZO TOTALE</th>
						</tr>
						<tr>
							<td class="data-table"><h2><?php echo $ordine; ?></h2></td>
							<td class="data-table"><input class="fast-pay" type="text" name="nome" value="<?php echo $nome; ?>"/></td>
							<td class="data-table"><input class="fast-pay" type="text" name="coperto" value="<?php echo $coperto; ?>"/></td>
							<td class="data-table"><input class="fast-pay" type="text" name="tavolo" value="<?php echo $tavolo; ?>"/></td>
							<td class="data-table"><h2><?php echo $prezzo; ?></h2></td>
						</tr>
					</table><br/>
					<input class="button" type="submit" value="CONFERMA"/>
				</form>
			<?php }//IF
			$ordine=0;?>
		</div>
	</div>
<?php include("../includes/footer.php"); ?>
