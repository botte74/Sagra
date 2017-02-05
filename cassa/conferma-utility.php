<?php
	include_once('../includes/config.php');

	if (isset($_POST['stato'])) {
		$ordine = $_SESSION['ordine'];
		//Controllo ordine gia pagato
		$query_controllo_pagato = "SELECT `stato` FROM `" . $prefix . "ordini` WHERE id_ordine = '$ordine'";
		$stato_ordine = mysqli_fetch_array(mysqli_query($dbconn, $query_controllo_pagato));
		echo $stato_ordine["stato"];
	}
?>
