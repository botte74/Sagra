<?php
	//QUANTITA ALL'INTERNO DELL'ORDINE COMPOSIZIONE
	$form_asiago=0;$form_grana=0;$form_grana_porc=0;$fagioli=0;$fagioli_cipolla=0;$verdura=0;
	$giorno=$_SESSION['giorno'];

	$data=date('Y-m-d');

	$cucina_fredda_query="SELECT oc.* FROM `" .$prefix. "ordini_composizione` AS oc,`" .$prefix. "ordini` AS o WHERE oc.id_ordine=o.id_ordine AND o.data_ordine LIKE '$data %' AND (o.stato='pagato' OR o.stato='evaso') AND o.tavolo<>'altro'";
	$result=mysqli_query($dbconn, $cucina_fredda_query);
	while($cucina_fredda=mysqli_fetch_array($result)){
		switch($cucina_fredda['id_piatto']){
			case 24:
				$form_asiago+=$cucina_fredda['quantita'];
				break;
			case 25:
				$form_grana+=$cucina_fredda['quantita'];
				break;
			case 26:
				$form_grana_porc+=$cucina_fredda['quantita'];
				break;
			case 27:
				$fagioli+=$cucina_fredda['quantita'];
				break;
			case 28:
				$fagioli_cipolla+=$cucina_fredda['quantita'];
				break;
			case 29:
				$verdura+=$cucina_fredda['quantita'];
				break;
		}//switch
	}//while

	$array_fredda=array();
	$query_fredda="SELECT * FROM `".$prefix."cucina_fredda`";
	$result_fredda= mysqli_query($dbconn, $query_fredda);
	$i=0;

	while($result=mysqli_fetch_array($result_fredda)){
		$array_fredda[$i]=$result['quantita'];
		$i++;
	}//while
	if(isset($_POST['svuota'])){
		$query_svuota="UPDATE `".$prefix."cucina_fredda` SET `quantita`=0";
		$result_fredda= mysqli_query($dbconn, $query_svuota);

		$array_fredda=array();
		$query_fredda="SELECT * FROM `".$prefix."cucina_fredda`";
		$result_fredda= mysqli_query($dbconn, $query_fredda);
		$i=0;

		while($result=mysqli_fetch_array($result_fredda)){
			$array_fredda[$i]=$result['quantita'];
			$i++;
		}//while
	}//if

?>
