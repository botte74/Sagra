<?php
	if (isset($_SESSION['ordine_speciale'])) {
		$prezzo = $_SESSION['ordine_prezzo'];
	}
	else {
		//Calcolo del prezzo "vero"
		$query_prezzo="SELECT `id_piatto`, `quantita`, `prezzo`
					FROM	`" . $prefix . "piatti` AS piatti,
							`" . $prefix . "ordini` AS ordini,
							`" . $prefix . "ordini_composizione` AS oc
					WHERE
						oc.id_ordine = '$ordine' AND
						oc.id_ordine = ordini.id_ordine AND
						oc.id_piatto = piatti.codice;";
		$piatti_ordine = mysqli_query($dbconn,$query_prezzo);
		$array_piatti_ordine = array();
		$prezzo = 0.00;
		while ($piatto_ordine = mysqli_fetch_array($piatti_ordine) ) {
			$prezzo += $piatto_ordine['prezzo'] * $piatto_ordine['quantita'];
			$array_piatti_ordine[$piatto_ordine['id_piatto']] = $piatto_ordine['quantita'];
		}
		//echo mysqli_error($dbconn);
		$prezzo = number_format($prezzo,2,"."," ");
	}
?>
