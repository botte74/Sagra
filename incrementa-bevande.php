<?php
	include_once("includes/config.php");

	$array_bevande=array();
	$query_bevande= "SELECT * FROM `".$prefix."bevande`";
	$result=mysqli_query($dbconn, $query_bevande);
	$i=0;
	while($result2=mysqli_fetch_array($result)){
		$array_bevande[$i]=$result2['quantita'];
		$i++;
	}//while

	if(isset($_POST['red1ok'])){
		$red1=1 + $array_bevande[5];
		$query_red1="UPDATE `".$prefix."bevande` SET `quantita`=$red1 WHERE `tipo`='Rosso-1'";
		mysqli_query($dbconn,$query_red1);
	}
	if(isset($_POST['red05ok'])){
		$red05=1 + $array_bevande[4];
		$query_red05="UPDATE `".$prefix."bevande` SET `quantita`=$red05 WHERE `tipo`='Rosso-0.5'";
		mysqli_query($dbconn,$query_red05);
	}
	if(isset($_POST['white1ok'])){
		$white1=1 + $array_bevande[1];
		$query_white1="UPDATE `".$prefix."bevande` SET `quantita`=$white1 WHERE `tipo`='Bianco-1'";
		mysqli_query($dbconn,$query_white1);
	}
	if(isset($_POST['white05ok'])){
		$white05=1 + $array_bevande[0];
		$query_white05="UPDATE `".$prefix."bevande` SET `quantita`=$white05 WHERE `tipo`='Bianco-0.5'";
		mysqli_query($dbconn,$query_white05);
	}
	if(isset($_POST['rab1ok'])){
		$rab1=1 + $array_bevande[3];
		$query_rab1="UPDATE `".$prefix."bevande` SET `quantita`=$rab1 WHERE `tipo`='Rabos-1'";
		mysqli_query($dbconn,$query_rab1);
	}
	if(isset($_POST['rab05ok'])){
		$rab05=1 + $array_bevande[2];
		$query_rab05="UPDATE `".$prefix."bevande` SET `quantita`=$rab05 WHERE `tipo`='Rabos-0.5'";
		mysqli_query($dbconn,$query_rab05);
	}

	$url = "bevande-ordini.php";
	echo '<script type="text/javascript">';
	echo 'window.location.href="'.$url.'";';
	echo '</script>';
	echo '<noscript>';
	echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	echo '</noscript>'; exit;

?>
