<?php
	include_once("../includes/config.php");


	//Controllo sul codice dell'ordine
	if (!isset($_SESSION['ordine']))
		die("Codice Ordine non specificato");
	else
		$ordine = $_SESSION['ordine'];

	/**
	 * Recupero quantità per piatti con varianti
	 * riceve: codice_alimento della variante selezionata
	 * riceve: codice_piatto del piatto in questione
	 * manda: quantità salvata fin'ora in database
	 */
	if ( isset($_POST['variantequantita'])) {
		$variante = $_POST['variantequantita'];
		$piatto = $_POST['piatto'];
		//OTTENIMENTO DELLA QUANTITÀ INSERITA
		$query_piatto = "SELECT * FROM `" . $prefix . "ordini_composizione`
							WHERE `id_ordine`='$ordine'
							AND `id_piatto`='$piatto'
							AND `var` = '$variante'";
		//echo $query_piatto;
		$quantita = mysqli_fetch_array(mysqli_query($dbconn, $query_piatto));
		$ritorno = $quantita['quantita'];
		echo $ritorno;
	}



	//AGGIUNTA O MODIFICA QUANTITA AI PIATTI DELL'ORDINE
	if (isset($_POST['quantita'])) {
		$quantita = $_POST['quantita'];
		$piatto = $_POST['piatto'];
		$variante = $_POST["variante"];

		$query_pivot = "	SELECT COUNT(*) FROM `" . $prefix . "ordini_composizione`
					WHERE
					id_ordine = '$ordine' AND
					`var` = '$variante' AND
					id_piatto = '$piatto';";
		$pivot = mysqli_fetch_array(mysqli_query($dbconn,$query_pivot));

		if ($pivot["COUNT(*)"] != 0 ) {
			//Modifica quantita
			if ($quantita != 0) {
				$query_quantita = "	UPDATE `" . $prefix . "ordini_composizione`
									SET `quantita`='$quantita'
									WHERE
										id_ordine = '$ordine' AND
										`var` = '$variante' AND
										id_piatto = '$piatto';";
			}
			else { //Eliminazione riga
				$query_quantita = "	DELETE FROM `" . $prefix . "ordini_composizione`
									WHERE
										id_ordine = '$ordine' AND
										`var` = '$variante' AND
										id_piatto = '$piatto';";
			}
		}
		else { //Inserimento quantita
			$query_quantita = "INSERT INTO `" . $prefix . "ordini_composizione` (`id_ordine`, `id_piatto`, `quantita`, `var`) VALUES ('$ordine', '$piatto', '$quantita', '$variante');";
		}
		//Esecuzione query
		mysqli_query($dbconn,$query_quantita);
		//echo mysqli_error($dbconn);
		//echo $query_quantita;

		//Calcolo del prezzo
		include("prezzo.php");
		//Prezzo in variabile $prezzo
		echo $prezzo;
	}
?>
