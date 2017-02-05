<?php
	$pagetitle = "Sagra Parrocchia di Mandria - BEVANDE - ALTRO";
	include_once("includes/config.php");
	
	//QUANTITA ALL'INTERNO DELL'ORDINE COMPOSIZIONE
	$cod_ac_nt=109;			$cod_ac_gs=108;			$cod_pros=106;		$cod_pros_bicc=48;
	$cod_bionda_pic=49;		$cod_bionda_med=50;		$cod_white_friz05=39;	$cod_white_friz1=38;
	$cod_rossa_pic=51;		$cod_rossa_med=52;		$cod_arancio=107;	$cod_arancio_bicc=47;
	$cod_rab05=37;			$cod_red05=35;			$cod_white05=34;	$cod_fanta=111;
	$cod_rab1=36;			$cod_red1=33;			$cod_white1=32;		$cod_coca=110;
	$cod_rab_om=46;			$cod_red_om=45;			$cod_white_om=44;	$cod_arancio=39;
	$cod_spritz_camp=56;	$cod_spritz_aperol=57;	$cod_mojito=53;		$cod_cuba_libre=54;	$cod_rum_pera=55;
	$cod_pan_porch=58;		$cod_piatto_porch=60;	$cod_hot_dog=59;	$cod_peperoni=61;
	$cod_salse=62;
	
	$giorno=$_SESSION['giorno'];
	$data = date("Y-m-d H:i:s");
	$last_id=0;
	
	$array_paninoteca=array();
	
	$query_paninoteca="SELECT `quantita` FROM `".$prefix."paninoteca`";
	$result_paninoteca=mysqli_query($dbconn, $query_paninoteca);
	$i=0;
	
	while($result=mysqli_fetch_array($result_paninoteca)){
			$array_paninoteca[$i]=$result['quantita'];
			$i++;
	}
	include_once("includes/head.php");
?>

<style>
	.conferma_altro{
		float:left;
		position:relative;
		display:block;
		color:#000000;
		text-align:center;
		font-weight:bold;
		font-size:16px;
		padding:1%;
		border:2px solid #FFFFFF;
		width:19.5%;
		height:35px;
		margin:6px;
		outline:1px solid;
		background-color:#FFB99D;
		outline-color:red;
	}
	
	.svuota{
		background-color:#248900;
		outline-color:#248900;
	}
	
	.fast{
		float:left;
		position:relative;
		display:block;
		color:#000000;
		text-align:center;
		font-weight:bold;
		font-size:30px;
		padding:1%;
		border:2px solid #FFFFFF;
		width:17.1%;
		height:42px;
		margin:5px;
		outline:1px solid;
		background-color:#00B5FF;
		outline-color:#00B5FF;
	}
	
	.contatore{
		float:left;
		position:relative;
		display:block;
		color:#000000;
		text-align:center;
		font-weight:bold;
		font-size:16px;
		border:2px solid #FFFFFF;
		width:19.1%;
		height:60px;
		margin:5px;
		margin-right:7px;
		outline:1px solid;
		outline-color:red;
	}
	.piccolo{
		width:30%;
		height:100%;
	}
</style>

<body>
	<div class="bevande">
			<form action="incrementa-paninoteca.php" method="POST">
				<button class="conferma_altro" 		disabled="disabled" name="acnt" >ACQUA NAT.</button>
				<button class="conferma_altro" 		disabled="disabled" name="acgs">ACQUA GAS.</button>
				<button class="conferma_altro" 		disabled="disabled" name="fanta">FANTA</button>
				<button class="conferma_altro" 		disabled="disabled" name="coca">COCA COLA</button><br/>
				<div class="contatore">
					<p><?php echo $array_paninoteca[0]; ?>
					<button type="submit" class="btn btn-danger piccolo" name="Acqua_Naturale_-" >-1</button>
					<button type="submit" class="btn btn-primary piccolo" name="Acqua_Naturale_+" >+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[1]; ?>
					<button class="btn btn-danger piccolo" name="Acqua_Frizzante_-">-1</button>
					<button class="btn btn-primary piccolo" name="Acqua_Frizzante_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[2]; ?>
					<button class="btn btn-danger piccolo" name="Fanta_-">-1</button>
					<button class="btn btn-primary piccolo"name="Fanta_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[3]; ?>
					<button class="btn btn-danger piccolo" name="Coca_-">-1</button>
					<button class="btn btn-primary piccolo" name="Coca_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="pros">PROSECCO</button>
				<button class="conferma_altro" 		disabled="disabled" name="pros_bicc">PROS. OMBRA</button>
				<button class="conferma_altro" 		disabled="disabled" name="arancio">FIOR D'ARANCIO</button>
				<button class="conferma_altro" 		disabled="disabled" name="arancio_bicc">FIOR A. OMBRA</button>
				<div class="contatore">
					<p><?php echo $array_paninoteca[4]; ?>
					<button class="btn btn-danger piccolo" name="Prosecco_-">-1</button>
					<button class="btn btn-primary piccolo" name="Prosecco_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[5]; ?>
					<button class="btn btn-danger piccolo" name="Prosecco_Bicchiere_-">-1</button>
					<button class="btn btn-primary piccolo" name="Prosecco_Bicchiere_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[6]; ?>
					<button class="btn btn-danger piccolo" name="Fior_Arancio_-">-1</button>
					<button class="btn btn-primary piccolo" name="Fior_Arancio_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[7]; ?>
					<button class="btn btn-danger piccolo" name="Fior_Arancio_Bicchiere_-">-1</button>
					<button class="btn btn-primary piccolo" name="Fior_Arancio_Bicchiere_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="birpic">BIONDA PICCOLA</button>
				<button class="conferma_altro" 		disabled="disabled" name="birmed">BIONDA MEDIA</button>
				<button class="conferma_altro" 		disabled="disabled" name="rossapic">ROSSA PICCOLA</button>
				<button class="conferma_altro" 		disabled="disabled" name="rossamed">ROSSA MEDIA</button>
				<div class="contatore">
					<p><?php echo $array_paninoteca[8]; ?>
					<button class="btn btn-danger piccolo" name="Bionda_Piccola_-">-1</button>
					<button class="btn btn-primary piccolo" name="Bionda_Piccola_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[9]; ?>
					<button class="btn btn-danger piccolo" name="Bionda_Media_-">-1</button>
					<button class="btn btn-primary piccolo" name="Bionda_Media_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[10]; ?>
					<button class="btn btn-danger piccolo" name="Rossa_Piccola_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rossa_Piccola_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[11]; ?>
					<button class="btn btn-danger piccolo" name="Rossa_Media_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rossa_Media_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="rab05">RABOS 0.5</button>
				<button class="conferma_altro" 		disabled="disabled" name="red05">ROSSO 0.5</button>
				<button class="conferma_altro" 		disabled="disabled" name="white05">BIANCO 0.5</button>
				<button class="conferma_altro" 		disabled="disabled" name="rab1">RABOS 1.0</button>
				<div class="contatore">
					<p><?php echo $array_paninoteca[12]; ?>
					<button class="btn btn-danger piccolo" name="Rabosello_05_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rabosello_05_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[13]; ?>
					<button class="btn btn-danger piccolo" name="Rosso_05_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rosso_05_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[14]; ?>
					<button class="btn btn-danger piccolo" name="Bianco_05_-">-1</button>
					<button class="btn btn-primary piccolo" name="Bianco_05_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[15]; ?>
					<button class="btn btn-danger piccolo" name="Rabosello_1_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rabosello_1_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="red1">ROSSO 1.0</button>
				<button class="conferma_altro" 		disabled="disabled" name="white1">BIANCO 1.0</button>
				<button class="conferma_altro" 		disabled="disabled" name="rabomb">RABOS OMBRA</button>
				<button class="conferma_altro" 		disabled="disabled" name="redomb">ROSSO OMBRA</button>
				<div class="contatore">
					<p><?php echo $array_paninoteca[16]; ?>
					<button class="btn btn-danger piccolo" name="Rosso_1_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rosso_1_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[17]; ?>
					<button class="btn btn-danger piccolo" name="Bianco_1_-">-1</button>
					<button class="btn btn-primary piccolo" name="Bianco_1_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[18]; ?>
					<button class="btn btn-danger piccolo" name="Rabosello_Bicchiere_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rabosello_Bicchiere_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[19]; ?>
					<button class="btn btn-danger piccolo" name="Rosso_Bicchiere_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rosso_Bicchiere_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="whiteomb">BIANCO OMBRA</button>
				<button class="conferma_altro" 		disabled="disabled" name="spritz_campari">SPRITZ CAMPARI</button>
				<button class="conferma_altro" 		disabled="disabled" name="spritz_aperol">SPRITZ APEROL</button>
				<button class="conferma_altro" 		disabled="disabled" name="mojito">MOJITO</button>
				<div class="contatore">
					<p><?php echo $array_paninoteca[20]; ?>
					<button class="btn btn-danger piccolo" name="Bianco_Bicchiere_-">-1</button>
					<button class="btn btn-primary piccolo" name="Bianco_Bicchiere_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[21]; ?>
					<button class="btn btn-danger piccolo" name="Spritz_Campari_-">-1</button>
					<button class="btn btn-primary piccolo" name="Spritz_Campari_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[22]; ?>
					<button class="btn btn-danger piccolo" name="Spritz_Aperol_-">-1</button>
					<button class="btn btn-primary piccolo" name="Spritz_Aperol_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[23]; ?>
					<button class="btn btn-danger piccolo" name="Mojito_-">-1</button>
					<button class="btn btn-primary piccolo" name="Mojito_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="cuba_libre">CUBA LIBRE</button>
				<button class="conferma_altro" 		disabled="disabled" name="rum_pera">RUM E PERA</button>
				<button class="conferma_altro" 		disabled="disabled" name="panino_porc">PANINO PORCH</button>
				<button class="conferma_altro" 		disabled="disabled" name="hot_dog" >HOT DOG</button>
				<div class="contatore">
					<p><?php echo $array_paninoteca[24]; ?>
					<button class="btn btn-danger piccolo" name="Cuba_Libre_-">-1</button>
					<button class="btn btn-primary piccolo" name="Cuba_Libre_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[25]; ?>
					<button class="btn btn-danger piccolo" name="Rum_Pera_-">-1</button>
					<button class="btn btn-primary piccolo" name="Rum_Pera_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[26]; ?>
					<button class="btn btn-danger piccolo" name="Panino_Porchetta_-">-1</button>
					<button class="btn btn-primary piccolo" name="Panino_Porchetta_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[27]; ?>
					<button class="btn btn-danger piccolo" name="Hot_Dog_-">-1</button>
					<button class="btn btn-primary piccolo" name="Hot_Dog_+">+1</button></p>
				</div><br/><br/>
				<button class="conferma_altro" 		disabled="disabled" name="piatto_porc" type="submit" value="PIATTO PORCH." >PIATTO PORCH.</button>
				<button class="conferma_altro" 		disabled="disabled" name="pep_grigliati" >PEP. GRIGLIATI</button>
				<button class="conferma_altro" 		disabled="disabled" name="salse" >SALSE</button>
				<button class="conferma_altro svuota" 	 				name="svuota" type="submit" >SVUOTA TUTTO</button><br/>
				<div class="contatore">
					<p><?php echo $array_paninoteca[28]; ?>
					<button class="btn btn-danger piccolo" name="Piatto_Porchetta_-">-1</button>
					<button class="btn btn-primary piccolo" name="Piatto_Porchetta_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[29]; ?>
					<button class="btn btn-danger piccolo" name="Peperoni_-">-1</button>
					<button class="btn btn-primary piccolo" name="Peperoni_+">+1</button></p>
				</div>
				<div class="contatore">
					<p><?php echo $array_paninoteca[30]; ?>
					<button class="btn btn-danger piccolo" name="Salse_-">-1</button>
					<button class="btn btn-primary piccolo" name="Salse_+">+1</button></p>
				</div>
				
			</form>
			<a class="fast" href="cassa/fast-pay.php">Fast Pay</a><br/>
	</div>
	<div align="right">
		<br/><a class="button verde" href="bevande.php">Indietro</a>
	</div>
</body>
