<?php

	include_once('../includes/config.php');

	if(isset($giorno)){
		$coperti_giorno = 4;
	}

	if(isset($_POST['time_coperti'])){
		$data=date('Y-m-d');
		$data.=" 18:30:00";
		$intervallo='';
		$frazioni=0;

		if($_POST['time_coperti']=="15 minuti"){
			$intervallo='15 minutes';
			$frazioni=20;
		}//if 15
		if($_POST['time_coperti']=="30 minuti"){
			$intervallo='30 minutes';
			$frazioni= 10;
		}//if 30
		if($_POST['time_coperti']=="1 ora"){
			$intervallo='1 hour';
			$frazioni=5;
		}//if 1

		$data_tot=$data;
		$i=0;
		echo "<tr class=\"data-table\"><th colspan=\"2\" class\"data-table\">INTERVALLO</th>";
		echo "<th class=\"data-table\">NUM. COPERTI</th></tr>";
		while($i<$frazioni){

			$coperti=0;
			$app=$data_tot;

			$data_tot = date_create($data_tot);
			date_add($data_tot, date_interval_create_from_date_string($intervallo));
			$data_tot=date_format($data_tot, 'Y-m-d H:i:s');

			$query_coperti_time="SELECT coperto FROM `".$prefix."ordini` WHERE `stato`='evaso' AND (`data_ordine` >= '$app' AND `data_ordine` < '$data_tot' )";
			$result=mysqli_query($dbconn, $query_coperti_time);
			while($result_time=mysqli_fetch_array($result)){
				$coperti+=$result_time['coperto'];
			}//if


			echo "	<tr class=\"data-table\">
						<td colspan=\"2\" class=\"data-table\">".$app. " - " . $data_tot ."</td>
						<td class=\"data-table\">".$coperti."</td>
					</tr>";
			$i++;

		}//while



	}//if

?>
