<?php
	include_once("includes/config.php");
	$pagetitle = "S.A.R.A. Smistamento Avanzato Raccolta Appunti";
	//$script = "sara/cucina-fredda.js";

	/*$bist=$_SESSION['bistecca'];
	$tagl_rosm=$_SESSION['tagl_rosm'];
	$tagl_ruc=$_SESSION['tagl_ruc'];
	$tagl_ab=$_SESSION['tagl_ab'];*/
	$evaso="";
	if(isset($_POST['codOrdine'])){
		$cod_ordine=$_POST['codOrdine'];
		$idCodice_query="SELECT * FROM `" . $prefix . "ordini` WHERE id_ordine=$cod_ordine";
		$idCodice=mysqli_query($dbconn, $idCodice_query);
		$result=mysqli_fetch_array($idCodice);
		$data = date("Y-m-d H:i:s");

		$id_ordine=$result['id_ordine'];
		if($id_ordine !=null){
			if($result['stato']=="pagato"){
				if($result['data_ordine']!=NULL){
					$query_data="UPDATE `" .$prefix. "ordini` SET fine='$data', stato='evaso' WHERE id_ordine=$cod_ordine";
					mysqli_query($dbconn, $query_data);
					$evaso="ORDINE " .$cod_ordine. " EVASO<br/> PILA \"FINITI\"";
				}
			}//if
			else{
				if(($result['stato']=="confermato")||($result['stato']=="ibernato")){
					$evaso="ORDINE " .$cod_ordine. " NON PAGATO O NEMMENO CONFERMATO";
				}//if
				else
					$evaso="Ordine numero " .$cod_ordine. " gi&agrave; EVASO";
			}//else
		}//if
		else{
			$evaso="Ordine " .$cod_ordine. " INESISTENTE";
		}//ELSE
	}//if

	//FINIRE DI MODIFICARE IL PROGRAMMA METTENDO QUELLO CHE SARA HA SELEZIONATO CON IL CODICE
	//AD ESEMPIO SE RIEMPIO IL CAMPO BEVANDE VERRÀ FUORI LA SCRITTA "L'ORDINE È PRONTO PER IL CIBO"

	//include("sara/cucina-fredda.php");
	
	$array=array();
	$query="SELECT * FROM `" . $prefix . "griglie`";
	$result_query=mysqli_query($dbconn, $query);
	$i=0;

	if ( (basename($_SERVER["PHP_SELF"]) != "index.php") && (basename($_SERVER["PHP_SELF"]) != "EG256AM-AZ137PW.php") )
		if (!isset($_SESSION['user']))
			header("Location: index.php");
		else
			$username = $_SESSION['user'];
?>
<!DOCTYPE html>
	<head>
		<title><?php echo $pagetitle; ?></title>
		<meta charset="ISO-8859-15">
		<?php if (isset($style)) { ?>
			<link type="text/css" rel="stylesheet" href="echo $style; ?>" />
		<?php } else { ?>
			<link type="text/css" rel="stylesheet" href="includes/style.css" />
		<?php } if (isset($script)) { ?>
			<script type="text/javascript" src="echo $script; ?>"></script>
		<?php } ?>
	</head>
	<body>
		<div id="wrapper">
			<?php if (!isset($_SESSION['user']) && (basename($_SERVER["PHP_SELF"]) == "EG256AM-AZ137PW.php") ) { ?>
				<div id="login">
					<form action="includes/login.php" method="POST">
						<p>Username</p>
						<input type="text" name="user"></input>
						<p>Password</p>
						<input type="password" name="passwd"></input><br />
						<input type="submit" value="ENTRA"></input>
					</form>
				</div>
				<?php } else {
				if (basename($_SERVER["PHP_SELF"]) == $_SESSION['homepage']) { ?>
					<div id="login">
						<p>Ciao <?php echo $_SESSION['user']; ?></p>
						<form action="includes/logout.php" method="POST">
						<input type="hidden" name="logout" value="true" />
						<input type="submit" value="logout" />
					</form>
					</div>
				<?php }
				} ?>
			<h1><?php echo $pagetitle; ?></h1>
			<br />


	<!--	S.A.R.A.	 -->
	<div class="modifica bevande">
		<div align="center">
			<h1>Inserisci il codice dell'Ordine</h1>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input class="textOrdine" type="text" name="codOrdine"></input>
				<input class="button" type="submit" value="INVIA"></input>
			</form><br/>
		</div>
		<a class="button verde" href="cerca.php">Cerca Ordine</a><br/>
		<p><strong class="big"><?php echo $evaso; ?></strong></p>
	</div>
	<!--	DISTRUBUZIONE -->
	<div class="modifica bevande">
		<form action="sara/richiesta.php" method="POST">
			<?php while($result=mysqli_fetch_array($result_query)){ 
					$tipo=$result['tipo'];
					if($tipo != 'Pollo'){?>
			<input class="richiesta" type="submit" name="griglia" value="<?php echo $tipo; ?>" />
			<?php }$i++;
			}
			?>
		</form><br/>
		<div align="center">
			<h1>ORDINE BISTECCA - TAGLIATA</h1>
			<form action="sara/richiesta.php" method="POST">
				<input class="textOrdine" type="text" name="ordine"></input>
					<input class="button" type="submit" value="INVIA"></input>
			</form>
		<!--<form action="sara/richiesta.php" method="POST">
			<input class="richiesta" type="submit" disabled="disabled" value="COTOLETTA" />
			<select class="invia_bistecca" name="cotoletta">
				<option value="nothing">Cotolette</option>
				<?php for($i=1;$i<6;$i++){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php }//for ?>
			</select>
			<input class="invia_bistecca" type="submit" value="INVIA" />
			<input class="invia_bistecca" type="text" value="Inviate: <?php echo $cot; ?>"><br/>
		</form>
	</div>
	<div id="cucina" class="modifica cucina_fredda">
			<div class="box rosso">
				<label style="font-size:24px;">GRANA</label>
				<strong style="font-size:50px;"><?php echo $form_grana; ?> </strong>
			</div>
			<div class="box rosso">
				<label style="font-size:24px;">FAGIOLI + CIPOLLA</label>
				<strong style="font-size:50px;"><?php echo $fagioli_cipolla; ?> </strong>
			</div>
			<div class="box rosso">
				<label style="font-size:24px;">VERDURA MISTA</label>
				<strong style="font-size:50px;"><?php echo $verdura; ?> </strong>
			</div><br/>
			<div class="box verde">
				<label style="font-size:24px;">GRANA</label>
				<strong style="font-size:50px;"><?php echo $array_fredda[1]; ?> </strong>
			</div>
			<div class="box verde">
				<label style="font-size:24px;">FAGIOLI + CIPOLLA</label>
				<strong style="font-size:50px;"><?php echo $array_fredda[4]; ?> </strong>
			</div>
			<div class="box verde">
				<label style="font-size:24px;">VERDURA MISTA</label>
				<strong style="font-size:50px;"><?php echo $array_fredda[5]; ?> </strong>
			</div><br/>
			<form action="sara/incrementa-cucina-fredda.php" method="POST">
				<input class="conferma" name="form_grana_ok" type="submit" value="GRANA OK"></input>
				<input class="conferma" name="fagioli_cipolla_ok" type="submit" value="FAGIOLI + CIP OK"></input>
				<input class="conferma" name="verdura_ok" type="submit" value="VERDURA OK"></input>
			</form><br/>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<input class="conferma_svuota" name="svuota" type="submit" value="SVUOTA TUTTO"></input>
			</form>
	</div>-->

<?php include("includes/footer.php"); ?>
