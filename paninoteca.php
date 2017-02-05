<?php
	$pagetitle = "Sagra Parrocchia di Mandria - PANINOTECA";
	include_once("includes/head.php");
	
	//QUANTITA ALL'INTERNO DELL'ORDINE COMPOSIZIONE
	
	$cod_panino_porc=58;
	$cod_hot_dog=59;
	$cod_piatto_porc=60;
	$cod_peperoni=61;
	$cod_salse=62;
	
	$giorno=$_SESSION['giorno'];
	$data = date("Y-m-d H:i:s");
	$last_id=0;
		
	if(isset($_POST['panino_porc'])){ 
		$query_ordini= "INSERT INTO `".$prefix."ordini` (`nome_cliente`,`tavolo`,`coperto`,`giorno`,`data_ordine`,`fine`,`stato`)
						VALUES('Panino Porchetta', 'altro', 0, '$giorno', '$data', '$data', 'evaso')";			
		$result1=mysqli_query($dbconn,$query_ordini);
		$last_id=mysqli_insert_id($dbconn);
		
		$query_ordini_comp= "INSERT INTO `".$prefix."ordini_composizione`(`id_ordine`, `id_piatto`, `quantita`) VALUES ($last_id, $cod_panino_porc ,1)";
		$result2=mysqli_query($dbconn,$query_ordini_comp);
	}
	if(isset($_POST['hot_dog'])){ 
		$query_ordini= "INSERT INTO `".$prefix."ordini` (`nome_cliente`,`tavolo`,`coperto`,`giorno`,`data_ordine`,`fine`,`stato`)
						VALUES('Hot Dog','altro', 0, '$giorno', '$data', '$data', 'evaso')";
		$result1=mysqli_query($dbconn,$query_ordini);
		$last_id=mysqli_insert_id($dbconn);
		
		$query_ordini_comp= "INSERT INTO `".$prefix."ordini_composizione`(`id_ordine`, `id_piatto`, `quantita`) VALUES ($last_id, $cod_hot_dog ,1)";
		$result2=mysqli_query($dbconn,$query_ordini_comp);
	}
	if(isset($_POST['piatto_porc'])){ 
		$query_ordini= "INSERT INTO `".$prefix."ordini` (`nome_cliente`,`tavolo`,`coperto`,`giorno`,`data_ordine`,`fine`,`stato`)
						VALUES('Piatto Porchetta','altro', 0, '$giorno', '$data', '$data', 'evaso')";
		$result1=mysqli_query($dbconn,$query_ordini);
		$last_id=mysqli_insert_id($dbconn);
		
		$query_ordini_comp= "INSERT INTO `".$prefix."ordini_composizione`(`id_ordine`, `id_piatto`, `quantita`) VALUES ($last_id, $cod_piatto_porc ,1)";
		$result2=mysqli_query($dbconn,$query_ordini_comp);
	}
	if(isset($_POST['pep_grigliati'])){ 
		$query_ordini= "INSERT INTO `".$prefix."ordini` (`nome_cliente`,`tavolo`,`coperto`,`giorno`,`data_ordine`,`fine`,`stato`)
						VALUES('Aggiunta Peperoni','altro', 0, '$giorno', '$data', '$data', 'evaso')";
		$result1=mysqli_query($dbconn,$query_ordini);
		$last_id=mysqli_insert_id($dbconn);
		
		$query_ordini_comp= "INSERT INTO `".$prefix."ordini_composizione`(`id_ordine`, `id_piatto`, `quantita`) VALUES ($last_id, $cod_peperoni ,1)";
		$result2=mysqli_query($dbconn,$query_ordini_comp);
	}
	if(isset($_POST['salse'])){ 
		$query_ordini= "INSERT INTO `".$prefix."ordini` (`nome_cliente`,`tavolo`,`coperto`,`giorno`,`data_ordine`,`fine`,`stato`)
						VALUES('Aggiunta Salse','altro', 0, '$giorno', '$data', '$data', 'evaso')";
		$result1=mysqli_query($dbconn,$query_ordini);
		$last_id=mysqli_insert_id($dbconn);
		
		$query_ordini_comp= "INSERT INTO `".$prefix."ordini_composizione`(`id_ordine`, `id_piatto`, `quantita`) VALUES ($last_id, $cod_salse ,1)";
		$result2=mysqli_query($dbconn,$query_ordini_comp);
	}
	
?>

<style>
	.conferma_altro{
		float:left;
		position:relative;
		display:block;
		color:#000000;
		text-align:center;
		font-weight:bold;
		font-size:30px;
		padding:1%;
		border:2px solid #FFFFFF;
		width:40%;
		height:70px;
		margin:5px;
		outline:1px solid;
		background-color:#FFB99D;
		outline-color:red;
	}
	
	.link_bevande{
		float:left;
		position:relative;
		display:block;
		color:#FFFFFF;
		text-align:center;
		font-weight:bold;
		font-size:36px;
		padding:1%;
		border:2px solid green;
		width:37.5%;
		height:48px;
		margin:5px;
		outline:1px solid green;
		background-color:green;
		outline-color:red;
	}
</style>

<body>
	<div class="bevande">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input class="conferma_altro" name="panino_porc" type="submit" value="PANINO PORCHETTA" ></input>
				<input class="conferma_altro" name="hot_dog" type="submit" value="HOT DOG" ></input>
				<input class="conferma_altro" name="piatto_porc" type="submit" value="PIATTO PORCHETTA" ></input>
				<input class="conferma_altro" name="pep_grigliati" type="submit" value="PEPERONI GRIGLIATI" ></input>
				<input class="conferma_altro" name="salse" type="submit" value="SALSE" ></input>
				<a class="link_bevande" href="bevande-altro.php">LINK BEVANDE</a>
			</form><br/>
	</div>
</body>
<?php if($_SESSION['user']=="admin")
		include("includes/footer.php"); ?>
