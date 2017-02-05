<?php
	include_once("includes/config.php");
	$data=date('Y-m-d H:i:s');

	$query_ordine="INSERT INTO `" . $prefix . "ordini` (`nome_cliente`,`data_ordine`, `fine`, `stato`, `prezzo_totale`, `cassa`)
												VALUES ('$tipo', '$data', '$data', 'pagato', '0', '-1');";
	$result=mysqli_query($dbconn, $query_ordine);

	$query_ordine_find="SELECT `id_ordine` FROM `".$prefix."ordini` WHERE `nome_cliente`='$tipo' AND `data_ordine`='$data'";
	$result=mysqli_query($dbconn, $query_ordine_find);
	$result2=mysqli_fetch_array($result);
	$ordine=$result2['id_ordine'];

	$query_ordine_composizione="INSERT INTO `" . $prefix . "ordini_composizione` (`id_ordine`,`id_piatto`, `var`, `quantita`)
												VALUES ('$ordine', '$codice', 0, 1);";
	$result=mysqli_query($dbconn, $query_ordine_composizione);

	include("cassa/prezzo.php");

	$prezzo = number_format($prezzo,2,"."," ");

	echo $prezzo;

	$ordine_update="UPDATE `".$prefix."ordini` SET `prezzo_totale`=$prezzo WHERE `id_ordine`='$ordine'";
	$result_ordine=mysqli_query($dbconn, $ordine_update);
?>
