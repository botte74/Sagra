<?php
include_once("config.php");
if (isset($_POST["logout"])) {
		if($_POST["logout"]==true) {
			//Chiudo la cassa
			if (isset($_SESSION['id_cassa'])) {
				//Creazione variabili
				$data_fine = date("Y-m-d H:i:s");
				$id_cassa = $_SESSION['id_cassa'];
				$saldo_iniziale = $_SESSION['saldo_iniziale'];

				//Calcolo dei soldi in cassa
				$query_soldi_cassa = "SELECT SUM(`prezzo_totale`) AS `totale` FROM `" . $prefix . "ordini` WHERE `cassa` = '$id_cassa';";
				$risultato = mysqli_fetch_array(mysqli_query($dbconn,$query_soldi_cassa));
				$soldi_attuali = $risultato['totale'] + $saldo_iniziale;

				$query_chiudi_cassa = "	UPDATE `" . $prefix . "casse`
										SET
											`ora_fine` = '$data_fine',
											`saldo_finale` = '$saldo_finale'
										WHERE
											`id_cassa` = '$id_cassa';";
				mysqli_query($dbconn,$query_chiudi_cassa);
			}
			$_SESSION['user'] = NULL;
			session_unset();
			session_destroy();
			header("Location: ../EG256AM-AZ137PW.php");
		}
	}
?>
