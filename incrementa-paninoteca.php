<?php
	include_once("includes/config.php");
	
	$array_paninoteca=array();
	$query_paninoteca= "SELECT * FROM `".$prefix."paninoteca`";
	$result=mysqli_query($dbconn, $query_paninoteca);
	$i=0;
	while($result2=mysqli_fetch_array($result)){
		$array_paninoteca[$i]=$result2['quantita'];
		$i++;
	}//while
	
	$tipo="";
	//----------------INCREMENTO UNITÀ PANINOTECA------------------------------------//
	
	if(isset($_POST['Acqua_Naturale_+'])){
		$tipo="Acqua Naturale";
		$codice=109;
		$paninoteca=1 + $array_paninoteca[0];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Acqua Naturale'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Acqua_Frizzante_+'])){
		$tipo="Acqua Frizzante";
		$codice=108;
		$paninoteca=1 + $array_paninoteca[1];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Acqua Frizzante'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Fanta_+'])){
		$tipo="Fanta";
		$codice=111;
		$paninoteca=1 + $array_paninoteca[2];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Fanta'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Coca_+'])){
		$tipo="Coca Cola";
		$codice=110;
		$paninoteca=1 + $array_paninoteca[3];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Coca Cola'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Prosecco_+'])){
		$tipo="Prosecco";
		$codice=106;
		$paninoteca=1 + $array_paninoteca[4];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Prosecco'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Prosecco_Bicchiere_+'])){
		$tipo="Prosecco Bicchiere";
		$codice=48;
		$paninoteca=1 + $array_paninoteca[5];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Prosecco Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Fior_Arancio_+'])){
		$tipo="Fior Arancio";
		$codice=107;
		$paninoteca=1 + $array_paninoteca[6];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Fior Arancio'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Fior_Arancio_Bicchiere_+'])){
		$tipo="Fior Arancio Bicchiere";
		$codice=47;
		$paninoteca=1 + $array_paninoteca[7];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Fior Arancio Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Bionda_Piccola_+'])){
		$tipo="Bionda Piccola";
		$codice=49;
		$paninoteca=1 + $array_paninoteca[8];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bionda Piccola'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Bionda_Media_+'])){
		$tipo="Bionda Media";
		$codice=50;
		$paninoteca=1 + $array_paninoteca[9];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bionda Media'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rossa_Piccola_+'])){
		$tipo="Rossa Piccola";
		$codice=51;
		$paninoteca=1 + $array_paninoteca[10];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rossa Piccola'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rossa_Media_+'])){
		$tipo="Rossa Media";
		$codice=52;
		$paninoteca=1 + $array_paninoteca[11];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rossa Media'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rabosello_05_+'])){
		$tipo="Rabosello 0.5";
		$codice=37;
		$paninoteca=1 + $array_paninoteca[12];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rabosello 0.5'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rosso_05_+'])){
		$tipo="Rosso 0.5";
		$codice=35;
		$paninoteca=1 + $array_paninoteca[13];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rosso 0.5'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Bianco_05_+'])){
		$tipo="Bianco 0.5";
		$codice=34;
		$paninoteca=1 + $array_paninoteca[14];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bianco 0.5'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rabosello_1_+'])){
		$tipo="Rabosello 1.0";
		$codice=36;
		$paninoteca=1 + $array_paninoteca[15];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rabosello 1.0'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rosso_1_+'])){
		$tipo="Rosso 1.0";
		$codice=33;
		$paninoteca=1 + $array_paninoteca[16];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rosso 1.0'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Bianco_1_+'])){
		$tipo="Bianco 1.0";
		$codice=32;
		$paninoteca=1 + $array_paninoteca[17];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bianco 1.0'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rabosello_Bicchiere_+'])){
		$tipo="Rabosello Bicchiere";
		$codice=46;
		$paninoteca=1 + $array_paninoteca[18];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rabosello Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rosso_Bicchiere_+'])){
		$tipo="Rosso Bicchiere";
		$codice=45;
		$paninoteca=1 + $array_paninoteca[19];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rosso Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Bianco_Bicchiere_+'])){
		$tipo="Bianco Bicchiere";
		$codice=44;
		$paninoteca=1 + $array_paninoteca[20];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bianco Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Spritz_Campari_+'])){
		$tipo="Spritz Campari";
		$codice=56;
		$paninoteca=1 + $array_paninoteca[21];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Spritz Campari'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Spritz_Aperol_+'])){
		$tipo="Spritz Aperol";
		$codice=57;
		$paninoteca=1 + $array_paninoteca[22];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Spritz Aperol'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Mojito_+'])){
		$tipo="Mojito";
		$codice=53;
		$paninoteca=1 + $array_paninoteca[23];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Mojito'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Cuba_Libre_+'])){
		$tipo="Cuba Libre";
		$codice=54;
		$paninoteca=1 + $array_paninoteca[24];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Cuba Libre'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Rum_Pera_+'])){
		$tipo="Rum e Pera";
		$codice=55;
		$paninoteca=1 + $array_paninoteca[25];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rum e Pera'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Panino_Porchetta_+'])){
		$tipo="Panino Porchetta";
		$codice=58;
		$paninoteca=1 + $array_paninoteca[26];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Panino Porchetta'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Hot_Dog_+'])){
		$tipo="Hot Dog";
		$codice=59;
		$paninoteca=1 + $array_paninoteca[27];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Hot Dog'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Piatto_Porchetta_+'])){
		$tipo="Piatto Porchetta";
		$codice=60;
		$paninoteca=1 + $array_paninoteca[28];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Piatto Porchetta'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Peperoni_+'])){
		$tipo="Peperoni Grigliati";
		$codice=61;
		$paninoteca=1 + $array_paninoteca[29];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Peperoni Grigliati'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	if(isset($_POST['Salse_+'])){
		$tipo="Salse";
		$codice=62;
		$paninoteca=1 + $array_paninoteca[30];
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Salse'";
		mysqli_query($dbconn, $query_paninoteca);
		include("ordine-paninoteca.php");
	}
	
	//----------------DECREMENTO UNITÀ PANINOTECA------------------------------------//
	
	if(isset($_POST['Acqua_Naturale_-'])){
		$paninoteca=$array_paninoteca[0] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Acqua Naturale'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Acqua_Frizzante_-'])){
		$paninoteca=$array_paninoteca[1] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Acqua Frizzante'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Fanta_-'])){
		$paninoteca=$array_paninoteca[2] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Fanta'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Coca_-'])){
		$paninoteca=$array_paninoteca[3] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Coca Cola'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Prosecco_-'])){
		$paninoteca=$array_paninoteca[4] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Prosecco'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Prosecco_Bicchiere_-'])){
		$paninoteca=$array_paninoteca[5] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Prosecco Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Fior_Arancio_-'])){
		$paninoteca=$array_paninoteca[6] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Fior Arancio'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Fior_Arancio_Bicchiere_-'])){
		$paninoteca=$array_paninoteca[7] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Fior Arancio Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Bionda_Piccola_-'])){
		$paninoteca=$array_paninoteca[8] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bionda Piccola'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Bionda_Media_-'])){
		$paninoteca=$array_paninoteca[9] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bionda Media'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rossa_Piccola_-'])){
		$paninoteca=$array_paninoteca[10] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rossa Piccola'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rossa_Media_-'])){
		$paninoteca=$array_paninoteca[11] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rossa Media'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rabosello_05_-'])){
		$paninoteca=$array_paninoteca[12] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rabosello 0.5'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rosso_05_-'])){
		$paninoteca=$array_paninoteca[13] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rosso 0.5'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Bianco_05_-'])){
		$paninoteca=$array_paninoteca[14] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bianco 0.5'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rabosello_1_-'])){
		$paninoteca=$array_paninoteca[15] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rabosello 1.0'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rosso_1_-'])){
		$paninoteca=$array_paninoteca[16] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rosso 1.0'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Bianco_1_-'])){
		$paninoteca=$array_paninoteca[17] - 1;	
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bianco 1.0'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rabosello_Bicchiere_-'])){
		$paninoteca=$array_paninoteca[18] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rabosello Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rosso_Bicchiere_-'])){
		$paninoteca=$array_paninoteca[19] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rosso Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Bianco_Bicchiere_-'])){
		$paninoteca=$array_paninoteca[20] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Bianco Bicchiere'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Spritz_Campari_-'])){
		$paninoteca=$array_paninoteca[21] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Spritz Campari'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Spritz_Aperol_-'])){
		$paninoteca=$array_paninoteca[22] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Spritz Aperol'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Mojito_-'])){
		$paninoteca=$array_paninoteca[23] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Mojito'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Cuba_Libre_-'])){
		$paninoteca=$array_paninoteca[24] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Cuba Libre'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Rum_Pera_-'])){
		$paninoteca=$array_paninoteca[25] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Rum e Pera'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Panino_Porchetta_-'])){
		$paninoteca=$array_paninoteca[26] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Panino Porchetta'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Hot_Dog_-'])){
		$paninoteca=$array_paninoteca[27] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Hot Dog'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Piatto_Porchetta_-'])){
		$paninoteca=$array_paninoteca[28] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Piatto Porchetta'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Peperoni_-'])){
		$paninoteca=$array_paninoteca[29] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Peperoni Grigliati'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	if(isset($_POST['Salse_-'])){
		$paninoteca=$array_paninoteca[30] - 1;
		$query_paninoteca="UPDATE `".$prefix."paninoteca` SET `quantita`=$paninoteca WHERE `tipo`='Salse'";
		mysqli_query($dbconn, $query_paninoteca);
	}
	
	//-----------------------------------SVUOTA TUTTO---------------------------------------------//
	if(isset($_POST['svuota'])){
		$query_svuota="UPDATE `".$prefix."paninoteca` SET `quantita`=0";
		$result_svuota=mysqli_query($dbconn, $query_svuota);
	}//if
	
	$url = "bevande-altro.php";
	echo '<script type="text/javascript">';
	echo 'window.location.href="'.$url.'";';
	echo '</script>';
	echo '<noscript>';
	echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	echo '</noscript>'; exit;
	
?>
