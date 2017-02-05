<?php

	include_once('../includes/config.php');

	if(isset($_POST['giorni'])){
		$giorno='';
		switch($_POST['giorni']){
			case 'giovedi':
				$giorno='2014-09-04';
				break;
			case 'venerdi':
				$giorno='2014-09-05';
				break;
			case 'sabato':
				$giorno='2014-09-06';
				break;
			case 'domenica':
				$giorno='2014-09-07';
				break;
			case 'lunedi':
				$giorno='2014-09-08';
				break;
		}//switch

		$query_coperti_giorno="SELECT SUM(coperto) AS somma FROM `".$prefix."ordini` WHERE `stato`='evaso' AND `data_ordine` LIKE '$giorno %'";
		$result_coperti_giorno=mysqli_query($dbconn,$query_coperti_giorno);
		$coperti=0;

		if($result_coperti_giorno){
			$result=mysqli_fetch_array($result_coperti_giorno);
			$coperti=$result['somma'];
			if($coperti=='')
				$coperti=0;
		}//if

		$query_coperti_tot="SELECT SUM(coperto) AS somma FROM `".$prefix."ordini` WHERE `stato`='evaso'";
		$result_coperti_tot=mysqli_query($dbconn, $query_coperti_tot);

		$coperti_tot=0;

		if($result_coperti_tot){
			$result_tot=mysqli_fetch_array($result_coperti_tot);
			$coperti_tot=$result_tot['somma'];
			if($coperti_tot=='')
				$coperti_tot=0;
		}//if

		echo 	'<tr class="data-table">
					<th class="data-table">GIORNO</td>
					<th class="data-table">NUM. COPERTI</td>
				</tr>
				<tr class="data-table">
					<td class="data-table"><strong>'.$giorno.'</strong></td>
					<td class="data-table">'.$coperti.'</td>
				</tr>
				<tr class="data-table">
					<td class="data-table"><strong>Tot. Sagra</strong></td>
					<td class="data-table">'.$coperti_tot.'</td>
				</tr>';

		/*$data="18:30:00";
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
			$data_tot=date_format($data_tot, 'H:i:s');

			$query_preleva_ore="SELECT `data_ordine`, `coperto` FROM `".$prefix."ordini` WHERE `data_ordine` IS NOT NULL AND `stato`='evaso'";
			$result_preleva=mysqli_query($dbconn, $query_preleva_ore);
			while($result=mysqli_fetch_array($result_preleva)){
					$data_explode=explode(" ",$result['data_ordine']);
					//echo $data_explode[1];
					$array_ore_tot=array();
					$array_ore_tot=date_parse($data_tot);
					$stringa_ora_tot=$array_ore_tot['hour'].":".$array_ore_tot['minute'].":".$array_ore_tot['second'];

					$array_ore_app=array();
					$array_ore_app=date_parse($app);
					$stringa_ora_app=$array_ore_app['hour'].":".$array_ore_app['minute'].":".$array_ore_app['second'];

					$diff1= $data_explode[1]-$stringa_ora_app;
					$diff2= $data_explode[1]-$stringa_ora_tot;

					echo $diff1;
					echo $diff2;
					if(($diff1==0) && ($diff2==-1))
						$coperti+=$result['coperto'];

			}//while

			echo "	<tr class=\"data-table\">
						<td colspan=\"2\" class=\"data-table\">".$app. " - " . $data_tot ."</td>
						<td class=\"data-table\">".$coperti."</td>
					</tr>";
			$i++;

		}//while*/



	}//if

?>
