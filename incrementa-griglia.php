<?php
	include_once("includes/config.php");
	$_SESSION['pollo']=0;

	if(isset($_POST['operation'])){
		$operation=$_POST['operation'];
		$quantita=$_POST['quantita'];
		$bool=$_POST['distrib'];
		
		$id_pollo=51;
		$array_colore=array();
		$cod_griglia = array();
		$array_alias = array();
		$array_carne=array();
		$i=0;
		$query_carne_griglie="SELECT * FROM `".$prefix."griglie`";
		$result_griglie= mysqli_query($dbconn, $query_carne_griglie);
		while($result=mysqli_fetch_array($result_griglie)){
			$array_carne[$result['id']]=$result['quantita'];
			$cod_griglia[$result['id']]=$result['id'];
			$array_alias[$result['id']]=$result['alias'];
			if($result['richiesta']==1)
				$array_colore[$result['tipo']]="background:red";
			else
				$array_colore[$result['tipo']]="";
			$i++;
		}//while


		if($operation=='add'){
			$id=$_POST['codice'];
			if($id==4){
				$query="UPDATE `".$prefix."griglie` SET `quantita`=$array_carne[$id_pollo]-$quantita/2 WHERE `id`=$id_pollo";
				$query2="UPDATE `".$prefix."griglie` SET `quantita`=$array_carne[$id]+$quantita WHERE `id`=$id";
				$result=mysqli_query($dbconn, $query);
				$result2=mysqli_query($dbconn, $query2);
			}
			if($id==18){
				$query="UPDATE `".$prefix."griglie` SET `quantita`=$array_carne[$id_pollo]-$quantita/4 WHERE `id`=$id_pollo";
				$query3="UPDATE `".$prefix."griglie` SET `quantita`=$array_carne[$id]+$quantita WHERE `id`=$id";
				$result=mysqli_query($dbconn, $query);
				$result3=mysqli_query($dbconn, $query3);
			}
			else{
				$query="UPDATE `".$prefix."griglie` SET `quantita`=$array_carne[$id]+$quantita WHERE `id`=$id";
				$result=mysqli_query($dbconn, $query);
			}
			
		}

		if($operation=='empty'){
			$id=$_POST['codice'];
			$query="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `id`=$id";
			$result=mysqli_query($dbconn, $query);
		}

		if($operation=='check'){
			$id=$_POST['codice'];
			$query="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `id`='$id'";
			$result=mysqli_query($dbconn, $query);
		}
	}
	
	

	//-------------INCREMENTO CARNE IN GRIGLIA --------------------//
	/*echo $_POST['pollo'];

	if(isset($_POST['pollo'])){
		$pollo=$_POST['pollo'] + $array_carni[5];
		$query_pollo="UPDATE `".$prefix."griglie` SET `quantita`=$pollo WHERE `tipo`='Pollo'";
		mysqli_query($dbconn, $query_pollo);
	}

	if(isset($_POST['pollo05'])){
		$pollo05=$_POST['pollo05'] + $array_carni[6];
		$query_pollo05="UPDATE `".$prefix."griglie` SET `quantita`=$pollo05 WHERE `tipo`='Pollo 1/2'";
		mysqli_query($dbconn, $query_pollo05);
		$query_pollo="SELECT `quantita` FROM `".$prefix."griglie` WHERE `tipo`='Pollo'";
		$result_pollo=mysqli_query($dbconn, $query_pollo);
		$result=mysqli_fetch_array($result_pollo);
		if($result)
			$dec_pollo=$result['quantita']-($_POST['pollo05'])/2;
		$query_quantita_pollo="UPDATE `".$prefix."griglie` SET `quantita`=$dec_pollo WHERE `tipo`='Pollo'";
		mysqli_query($dbconn, $query_quantita_pollo);

	}
	if(isset($_POST['pollo025'])){
		$pollo025=$_POST['pollo025'] + $array_carni[7];
		$query_pollo025="UPDATE `".$prefix."griglie` SET `quantita`=$pollo025 WHERE `tipo`='Pollo 1/4'";
		mysqli_query($dbconn, $query_pollo025);
		$query_pollo="SELECT `quantita` FROM `".$prefix."griglie` WHERE `tipo`='Pollo'";
		$result_pollo=mysqli_query($dbconn, $query_pollo);
		$result=mysqli_fetch_array($result_pollo);
		if($result)
			$dec_pollo=$result['quantita']-($_POST['pollo025'])/4;
		$query_quantita_pollo="UPDATE `".$prefix."griglie` SET `quantita`=$dec_pollo WHERE `tipo`='Pollo'";
		mysqli_query($dbconn, $query_quantita_pollo);
	}
	if(isset($_POST['costine'])){
		$costine=$_POST['costine'] + $array_carni[1];
		$query_costine="UPDATE `".$prefix."griglie` SET `quantita`=$costine WHERE `tipo`='Costine'";
		mysqli_query($dbconn, $query_costine);
	}
	if(isset($_POST['salsicce'])){
		$salsicce=$_POST['salsicce'] + $array_carni[8];
		$query_salsicce="UPDATE `".$prefix."griglie` SET `quantita`=$salsicce WHERE `tipo`='Salsicce'";
		mysqli_query($dbconn, $query_salsicce);
	}
	if(isset($_POST['pancetta'])){
		$pancetta=$_POST['pancetta'] + $array_carni[2];
		$query_pancetta="UPDATE `".$prefix."griglie` SET `quantita`=$pancetta WHERE `tipo`='Pancetta'";
		mysqli_query($dbconn, $query_pancetta);
	}
	if(isset($_POST['polenta'])){
		$polenta=$_POST['polenta'] + $array_carni[4];
		$query_polenta="UPDATE `".$prefix."griglie` SET `quantita`=$polenta WHERE `tipo`='Polenta'";
		mysqli_query($dbconn, $query_polenta);
	}
	if(isset($_POST['patatine'])){
		$patatine=$_POST['patatine'] + $array_carni[3];
		$query_patatine="UPDATE `".$prefix."griglie` SET `quantita`=$patatine WHERE `tipo`='Patatine'";
		mysqli_query($dbconn, $query_patatine);
	}
	if(isset($_POST['bigoli'])){
		$bigoli=$_POST['bigoli'] + $array_carni[0];
		$query_bigoli="UPDATE `".$prefix."griglie` SET `quantita`=$bigoli WHERE `tipo`='Bigoli'";
		mysqli_query($dbconn, $query_bigoli);
	}*/

	//-------------MODIFICA DEL VALORE BOOLEANO DELLA RICHIESTA DALLA DISTRIBUZIONE-----------//

	/*if(isset($_POST['pollo05_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Pollo 1/2'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['pollo025_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Pollo 1/4'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['costine_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Costine'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['salsicce_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Salsicce'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['pancetta_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Pancetta'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['polenta_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Polenta'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['patatine_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Patatine'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['bigoli_richiesta'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `richiesta`=0 WHERE `tipo`='Bigoli'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if


	//------------------SVUOTA QUANTITA GRIGLIA--------------------------------------------//
	if(isset($_POST['pollo_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Pollo'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if

	if(isset($_POST['pollo05_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Pollo 1/2'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['pollo025_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Pollo 1/4'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['costine_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Costine'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['salsicce_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Salsicce'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['pancetta_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Pancetta'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['polenta_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Polenta'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['patatine_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Patatine'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if
	if(isset($_POST['bigoli_svuota'])){
		$query_richiesta="UPDATE `".$prefix."griglie` SET `quantita`=0 WHERE `tipo`='Bigoli'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if*/


	//-----------------------ELIMINAZIONE ORDINE ----------------------------------//
	$del =$_POST['del'];
	$pezzo=explode("-",$del);
	$ordine=$pezzo[0];
	$piatto=$pezzo[1];

	$query_del="DELETE FROM `".$prefix."bist_tagl` WHERE id_ordine=$ordine AND id_piatto = $piatto";
	$result_del=mysqli_query($dbconn, $query_del);


	$url = "griglie.php";
	echo '<script type="text/javascript">';
	echo 'window.location.href="'.$url.'";';
	echo '</script>';
	echo '<noscript>';
	echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	echo '</noscript>'; exit;
?>
