<?php
	include_once("../includes/head.php");

	$array_fredda=array();
	$query_fredda= "SELECT * FROM `".$prefix."cucina_fredda`";
	$result=mysqli_query($dbconn, $query_fredda);
	$i=0;
	while($result2=mysqli_fetch_array($result)){
		$array_fredda[$i]=$result2['quantita'];
		$i++;
	}//while

	if(isset($_POST['form_grana_ok'])){
		$grana=1 + $array_fredda[1];
		$query_grana="UPDATE `".$prefix."cucina_fredda` SET `quantita`=$grana WHERE `tipo`='grana'";
		mysqli_query($dbconn, $query_grana);
	}

	if(isset($_POST['fagioli_cipolla_ok'])){
		$fagioli_cipolla=1 + $array_fredda[4];
		$query_fagioli_cipolla="UPDATE `".$prefix."cucina_fredda` SET `quantita`=$fagioli_cipolla WHERE `tipo`='fagioli_cipolla'";
		mysqli_query($dbconn, $query_fagioli_cipolla);
	}
	if(isset($_POST['verdura_ok'])){
		$verdura=1 + $array_fredda[5];
		$query_verdura="UPDATE `".$prefix."cucina_fredda` SET `quantita`=$verdura WHERE `tipo`='verdura_mista'";
		mysqli_query($dbconn, $query_verdura);
	}

	header("Location: ../sara.php#cucina");

?>
