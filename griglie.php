<?php
	$pagetitle = "Griglie";
	include_once("includes/head.php");?>
	<body class="notitle">
		<style>
			@keyframes loading {
				from {
					width: 0%;
				}
				to {
					width: 100%;
				}
			}
			#loading {
				overflow: hidden;
				width: 100%;
				height: 20px;
				background-color: red;
				color: white;
				animation-name: loading;
				animation-duration: 15s;
				animation-timing-function: linear;
			}

		</style>

		<div style="height:20px; background-color: #fff;">
			<div id="loading">Barra di caricamento</div>
		</div>
		<script type="text/javascript" src="includes/jQuery.js"></script>
		<script type="text/javascript">
				setTimeout(function(){window.location.replace('griglie.php');},15000);
		</script>
		<div class="ordini_griglia clearfix">

	<?php
	$giorno=$_SESSION['giorno'];
	$quantita=0;

	//----------CREAZIONE TABELLA BISTECCA TAGLIATA -----------//
	$id_ordine=array();
	$id_piatto=array();
	$nome=array();
	$quant2=array();
	$query_bist = "SELECT * FROM `".$prefix."bist_tagl`";
	$result_bist=mysqli_query($dbconn,$query_bist);
	$i=0;
	while($result=mysqli_fetch_array($result_bist)){
		$id_ordine[$i]=$result['id_ordine'];
		$id_piatto[$i]=$result['id_piatto'];
		if($result['nome']=="Tagliata con Rucola")
			$nome[$i]="Tagl. Ruc.";
		else
			if($result['nome']=="Tagliata Aceto Balsamico")
				$nome[$i]="Tagl. AB.";
		else
			if($result['nome']=="Bistecca di cavallo")
				$nome[$i]="Bistecca	";
		else
			if($result['nome']=="Tagliata al rosmarino")
				$nome[$i]="Tagl. Rosm.";
		$quant2[$i]=$result['quantita'];
		$i++;
	}//while

	//-----     SELEZIONO VARIABILI RELATIVE ALLA GRIGLIA  ---------------------//
	$array_colore=array();
	$cod_griglia = array();
	$array_alias = array();
	$array_carne=array();
	$i=0;
	$query_carne_griglie="SELECT * FROM `".$prefix."griglie`";
	$result_griglie= mysqli_query($dbconn, $query_carne_griglie);
	while($result=mysqli_fetch_array($result_griglie)){
		$array_carne[$result['tipo']]=$result['quantita'];
		$cod_griglia[$result['tipo']]=$result['id'];
		$array_alias[$result['tipo']]=$result['alias'];
		if($result['richiesta']==1)
			$array_colore[$result['tipo']]="background:red";
		else
			$array_colore[$result['tipo']]="";
		$i++;
	}//while

	//------------------------------------------------------------//
	//					VENDUTAAAAAAAAAAA																  //
	//------------------------------------------------------------//
	$array_carne_venduta=array();

	$data = date("Y-m-d");
	$data_tot=$data." 23:59:00";

	foreach ($cod_griglia as $tipo=>$id) {
	//for($i=0;$i<9;$i++){
		//$cod=$cod_griglia[$i];
		$query_carne_venduta= "
			SELECT
				oc.id_piatto, oc.quantita, pc.cod_alimentari, pc.quantita_alimento
			FROM
				`".$prefix."ordini_composizione` AS oc,
				`".$prefix."piatti_composizione` AS pc,
				`".$prefix."ordini` AS o
			WHERE
				(o.stato='pagato' OR o.stato='evaso')
			AND
				oc.id_ordine=o.id_ordine
			AND
				oc.id_piatto=pc.cod_piatto
			AND
				pc.cod_alimentari=$id
			AND
				o.data_ordine < '$data_tot'
			AND
				o.data_ordine LIKE '$data %' ";
		$result_carne_venduta=mysqli_query($dbconn, $query_carne_venduta);
		//echo $query_carne_venduta;
		$quantita=0;
		while($result_venduta=mysqli_fetch_array($result_carne_venduta)){

				$quantita +=$result_venduta['quantita']*$result_venduta['quantita_alimento'];

		}
		$array_carne_venduta[$tipo]=$quantita;
		$quantita=0;
	}

	//------------------------------------------------------------//
	//					EVASAAAAAAAAAAA						      //
	//------------------------------------------------------------//
	$array_carne_evasa=array();

	foreach ($cod_griglia as $tipo=>$id) {
	//for($i=0;$i<9;$i++){
		//$cod=$cod_griglia[$i];
		$query_carne_evasa= "SELECT oc.id_piatto, oc.quantita, pc.cod_alimentari, pc.quantita_alimento
								FROM `".$prefix."ordini_composizione` AS oc, `".$prefix."piatti_composizione` AS pc,`".$prefix."ordini` AS o
								WHERE o.stato='evaso' AND oc.id_ordine=o.id_ordine AND oc.id_piatto=pc.cod_piatto
									AND pc.cod_alimentari=$id AND o.data_ordine < '$data_tot'	AND o.data_ordine LIKE '$data %' ";
		$result_carne_evasa=mysqli_query($dbconn, $query_carne_evasa);
		while($result_evasa=mysqli_fetch_array($result_carne_evasa)){
			$quantita+=$result_evasa['quantita']*$result_evasa['quantita_alimento'];
		}
		$array_carne_evasa[$tipo]=$quantita;
		$quantita=0;
	}
	//------------------------------------------------------------//
	//						ALLA FINEEEE						  //
	//------------------------------------------------------------//
	$array_carne_fine=array();
	$data = date("Y-m-d");
	$data_tot=$data." 22:30:00";

	foreach ($cod_griglia as $tipo=>$id) {
	/* for($i=0;$i<9;$i++) {
		//$cod=$cod_griglia[$i]; */
		$query_carne_fine= "SELECT oc.id_piatto, oc.quantita, pc.cod_alimentari,
							pc.quantita_alimento FROM ".$prefix."ordini_composizione AS oc,
							".$prefix."piatti_composizione AS pc,".$prefix."ordini AS o
							WHERE o.stato='pagato' AND o.speciale<>'NULL' AND oc.id_ordine=o.id_ordine
							AND oc.id_piatto=pc.cod_piatto AND pc.cod_alimentari=$id AND o.data_ordine LIKE '$data %'
							AND o.fine LIKE '$data %' AND o.fine >= '$data_tot'";
		$result_carne_fine=mysqli_query($dbconn, $query_carne_fine);
		while($result_fine=mysqli_fetch_array($result_carne_fine)){
			$quantita+=$result_fine['quantita']*$result_fine['quantita_alimento'];
		}
		$array_carne_fine[$tipo]=$quantita;
		$quantita=0;
	}//for

?>
		<div class="tab_sx">
			<table class="data-table-griglie">
				<tr class="data-table-griglie">
					<th class="data-table-griglie">TIPO</th>
					<th class="data-table-griglie">METTISU</th>
					<th class="data-table-griglie">GRIGLIA</th>
					<th class="data-table-griglie">VEND</th>
					<th class="data-table-griglie">DA_EV</th>
					<th class="data-table-griglie">EVASI</th>
					<th class="data-table-griglie">LAST</th>
					<th class="data-table-griglie">X</th>
				</tr>
				<?php
					foreach ($array_carne as $tipo=>$quantita) {
						if ($tipo != 'Pollo')
						{ ?>
							<tr class="data-table-griglie" style="<?php echo $array_colore[$tipo]; ?>">
								<form action="incrementa-griglia.php" method="POST" name="<?php echo $tipo; ?>">
									<input type="hidden" name="type" value="<?php echo $tipo; ?>" />
									<input type="hidden" name="codice" value="<?php echo $cod_griglia[$tipo]; ?>" />
									<td class="data-table-griglie" ><?php echo $tipo; ?><input class="eseguito" name="operation" type="submit" value="check"/></td>
									<td class="data-table-griglie">
										<input class="box_aggiunta" type="text" name="quantita" />
										<input class="conferma_aggiunta" type="submit" name="operation"  value="add" />
									</td>
									<td class="data-table-griglie" ><?php echo $quantita; ?></td>

									<td class="data-table-griglie" ><?php echo $array_carne_venduta[$tipo]; ?></td>
									<td class="data-table-griglie" ><?php if(($array_carne_venduta[$tipo] - $array_carne_evasa[$tipo])<0)
																			echo 0;
																		else
																			echo $array_carne_venduta[$tipo] - $array_carne_evasa[$tipo];?></td>
									<td class="data-table-griglie" ><?php echo $array_carne_evasa[$tipo]; ?></td>
									<td class="data-table-griglie" ><?php echo $array_carne_fine[$tipo]; ?></td>
									<td class="data-table-griglie" ><input class="svuota" type="submit" value="empty" name="operation" /></td>
								</form>
							</tr>
						<?php } else { ?>
							<tr class="data-table-griglie">
									<form action="incrementa-griglia.php" method="POST" name="<?php echo $tipo; ?>">
										<input type="hidden" name="type" value="<?php echo $tipo; ?>" />
										<input type="hidden" name="codice" value="<?php echo $cod_griglia[$tipo]; ?>" />
										<td class="data-table-griglie" ><?php echo $tipo; ?><input class="eseguito" name="operation" type="submit" value="check"/></td>
										<td class="data-table-griglie">
											<input class="box_aggiunta" type="text" name="quantita" />
											<input class="conferma_aggiunta" type="submit" name="operation"  value="add" />
										</td>
										<td class="data-table-griglie" ><?php echo $quantita; ?></td>

										<td class="data-table-griglie" >X</td>
										<td class="data-table-griglie" >X</td>
										<td class="data-table-griglie" >X</td>
										<td class="data-table-griglie" >X</td>
										<td class="data-table-griglie" ><input class="svuota" type="submit" value="empty" name="operation" /></td>
								</form>
							</tr>
						<?php } ?>


				<?php }//for ?>
				<script type="text/javascript">

					$(document).ready(function(){

						$('.add').on('click', function(){
							$('.operation').value = "add";

						});

						$('.empty').on('click',function(){
							$('.operation').value = "empty";

						});

							$(window).keydown(function(event){
							if(event.keyCode==13){
								event.preventDefault();
								return false;
							}
						});
					});



				</script>
				<?php
				/*
					for($i=6;$i<9;$i++){ ?>
						<tr class="data-table-griglie" style="echo $array_colore[$i]; ?>">
							<form action="incrementa-griglia.php" method="POST">
								<td class="data-table-griglie" ><input class="eseguito" name="<?php echo $array_richiesta[$i]; ?>" type="submit" value="<?php echo $array_nomi[$i]; ?>"/></td>
								<td class="data-table-griglie" >
									<input class="box_aggiunta" type="text" name="<?php echo $array_aggiunta[$i]; ?>"></input>
									<input class="conferma_aggiunta" type="submit" name="submit" value="+">
								</td>
								<td class="data-table-griglie" ><?php echo $array_carne[$i]; ?></td>
								<td class="data-table-griglie" ><?php echo $array_carne_venduta[$i-1]; ?></td>
								<td class="data-table-griglie" ><?php  if(($array_carne_venduta[$i-1] - $array_carne_evasa[$i-1])<0)
																		echo 0;
																	else
																		echo $array_carne_venduta[$i-1] - $array_carne_evasa[$i-1];?></td>
								<td class="data-table-griglie" ><?php echo $array_carne_evasa[$i-1]; ?></td>
								<td class="data-table-griglie" ><?php echo $array_carne_fine[$i-1]; ?></td>
								<td class="data-table-griglie" ><input class="svuota" name="<?php echo $array_svuota[$i]; ?>" type="submit" value="X"/></td>
							</form>
						</tr>
			<?php }//for  */ ?>
			</table>
		</div>
		<div class="tab_dx">
			<table class="data-table-griglie">
				<tr class="data-table-griglie">
					<th class="data-table-griglie">ORD</th>
					<th class="data-table-griglie">TIPO</th>
					<th class="data-table-griglie">Q.TA</th>
					<th class="data-table-griglie">X</th>
				</tr>
				<?php
					for($i=0;$i<count($id_ordine);$i++){ ?>
					<tr class="data-table-griglie">
						<td class="data-table-griglie" ><?php echo $id_ordine[$i]; ?></td>
						<td class="data-table-griglie" ><?php echo $nome[$i]; ?></td>
						<td class="data-table-griglie" ><?php echo $quant2[$i]; ?></td>
						<form action="incrementa-griglia.php" method="POST">
							<td class="data-table-griglie" ><input class="svuota" type="submit" name="del" value="<?php echo $id_ordine[$i]."-".$id_piatto[$i]; ?>"></input></td>
						</form>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</body>
