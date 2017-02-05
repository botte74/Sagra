<?php
	include_once("../includes/config.php");

	if(isset($_POST['griglia'])){
		$tipo=$_POST['griglia'];
		$query_richiesta="UPDATE `". $prefix ."griglie` SET `richiesta`=1 WHERE `tipo`='$tipo'";
		$result_richiesta=mysqli_query($dbconn, $query_richiesta);
	}//if

	//----------CREAZIONE TABELLA PER BISTECCA E TAGLIATA--------------------------------------//
	$sara = $_POST['ordine'];

	$id_ordine=array();
	$id_piatto=array();
	$nome_piatto=array();
	$quant2=array();

	$query_sara="SELECT oc.id_ordine, oc.id_piatto, oc.quantita, p.nome FROM `".$prefix."piatti` AS p, `".$prefix."ordini_composizione` AS oc,`".$prefix."ordini` AS o WHERE oc.id_ordine=$sara AND o.stato='pagato' AND oc.id_ordine=o.id_ordine
				 AND (oc.id_piatto=11 OR oc.id_piatto=112 OR oc.id_piatto=114 OR oc.id_piatto=113) AND p.codice=oc.id_piatto";
	$result_sara=mysqli_query($dbconn, $query_sara);
	$i=0;

	while($result=mysqli_fetch_array($result_sara)){
		$id_ordine[$i]=$result['id_ordine'];
		$id_piatto[$i]=$result['id_piatto'];
		$quant2[$i]=$result['quantita'];
		$nome_piatto[$i]=$result['nome'];
		$query = "INSERT INTO `".$prefix."bist_tagl` (`id_ordine`, `id_piatto`,`nome` ,`quantita`) VALUES ($id_ordine[$i] , $id_piatto[$i], '$nome_piatto[$i]', $quant2[$i])";

		echo $query;
		$result_insert=mysqli_query($dbconn, $query);
		$i++;
	}//while


	header("Location: ../sara.php");
?>
