<?php
	$pagetitle = "Sagra Parrocchia di Mandria - BEVANDE - ORDINI";
	include_once("includes/head.php");

	//QUANTITA ALL'INTERNO DELL'ORDINE COMPOSIZIONE

	$rab05=0;$red05=0;$white05=0;$rab1=0;$red1=0;$white1=0;

	$data = date("Y-m-d");

	$bevande_query="SELECT oc.* FROM `" .$prefix. "ordini_composizione` AS oc,`" .$prefix. "ordini` AS o WHERE oc.id_ordine=o.id_ordine AND o.data_ordine LIKE '$data %' AND (o.stato='pagato' OR o.stato='evaso') AND o.tavolo!='altro'";
	$result=mysqli_query($dbconn,$bevande_query);
	while($bevande=mysqli_fetch_array($result)){
		switch($bevande['id_piatto']){
			case 32:
				$white1+=$bevande['quantita'];
				break;
			case 33:
				$red1+=$bevande['quantita'];
				break;
			case 34:
				$white05+=$bevande['quantita'];
				break;
			case 35:
				$red05+=$bevande['quantita'];
				break;
			case 36:
				$rab1+=$bevande['quantita'];
				break;
			case 37:
				$rab05+=$bevande['quantita'];
				break;
		}//switch
	}//while

	$array_bere=array();
	$query_bere="SELECT quantita FROM `".$prefix."bevande`";
	$result_bere= mysqli_query($dbconn,$query_bere);
	$i=0;

	while($result=mysqli_fetch_array($result_bere)){
		$array_bere[$i]=$result['quantita'];
		$i++;
	}//while

	if(isset($_POST['svuota'])){
		$query_svuota="UPDATE `".$prefix."bevande` SET `quantita`=0";
		$result_bere= mysqli_query($dbconn, $query_svuota);

		$array_bere=array();
		$query_bere="SELECT * FROM `".$prefix."bevande`";
		$result_bere= mysqli_query($dbconn,$query_bere);
		$i=0;

		while($result=mysqli_fetch_array($result_bere)){
			$array_bere[$i]=$result['quantita'];
			$i++;
		}//while
	}//if

?>
<META HTTP-EQUIV="Refresh" CONTENT="10"; url="bevande-ordini.php">
<style>
	.box{
		float:left;
		position:relative;
		width:25.5%;
		border-color: red;
		border: solid 2px #FF0000;
		border-radius:5px;
		min-height:40px;
		margin:0.3%;
		padding:1%;
		text-align:center;
		overdflow:hidden;
	}
	.verde{
		background-color:#FFFFA2;
	}
	.rosso{
		background-color:#FFB99D;
		text-color:#000000;
	}

	input.conferma_svuota{
		float:left;
		position:relative;
		display:block;
		color:#FFFFFF;
		text-align:center;
		font-weight:bold;
		font-size:26px;
		padding:1%;
		border:2px solid #FFFFFF;
		width:27.5%;
		height:70px;
		margin:5px;
		outline:1px solid;
		background-color:green;
		outline-color:green;
	}
</style>

<body>
	<div class="bevande">
		<div class="box rosso">
			<label style="font-size:24px;">RABOS 0.5</label>
			<strong style="font-size:50px;"><?php echo $rab05; ?> </strong>
		</div>
		<div class="box rosso">
			<label style="font-size:24px;">ROSSO 0.5</label>
			<strong style="font-size:50px;"><?php echo $red05; ?> </strong>
		</div>
		<div class="box rosso">
			<label style="font-size:24px;">BIANCO 0.5</label>
			<strong style="font-size:50px;"><?php echo $white05; ?> </strong>
		</div>
		<div class="box verde">
			<label style="font-size:24px;">RABOS 0.5 OK</label>
			<strong style="font-size:50px;"><?php echo $array_bere[2]; ?> </strong>
		</div>
		<div class="box verde">
			<label style="font-size:24px;">ROSSO 0.5 OK</label>
			<strong style="font-size:50px;"><?php echo $array_bere[4]; ?> </strong>
		</div>
		<div class="box verde">
			<label style="font-size:24px;">BIANCO 0.5 OK</label>
			<strong style="font-size:50px;"><?php echo $array_bere[0]; ?> </strong>
		</div>
		<div class="box rosso">
			<label style="font-size:24px;">RABOS 1.0</label>
			<strong style="font-size:50px;"><?php echo $rab1; ?> </strong>
		</div>
		<div class="box rosso">
			<label style="font-size:24px;">ROSSO 1.0</label>
			<strong style="font-size:50px;"><?php echo $red1; ?> </strong>
		</div>
		<div class="box rosso">
			<label style="font-size:24px;">BIANCO 1.0</label>
			<strong style="font-size:50px;"><?php echo $white1; ?> </strong>
		</div>
		<div class="box verde">
			<label style="font-size:24px;">RABOS 1.0 OK</label>
			<strong style="font-size:50px;"><?php echo $array_bere[3]; ?> </strong>
		</div>
		<div class="box verde">
			<label style="font-size:24px;">ROSSO 1.0 OK</label>
			<strong style="font-size:50px;"><?php echo $array_bere[5]; ?> </strong>
		</div>
		<div class="box verde">
			<label style="font-size:24px;">BIANCO 1.0 OK</label>
			<strong style="font-size:50px;"><?php echo $array_bere[1]; ?> </strong>
		</div>
		<form action="incrementa-bevande.php" method="POST">
			<input class="conferma" name="rab05ok" type="submit" value="RAB 0.5L OK" ></input>
			<input class="conferma" name="red05ok" type="submit" value="ROSSO 0.5L OK"></input>
			<input class="conferma" name="white05ok" type="submit" value="BIANCO 0.5L OK"></input>
			<input class="conferma" name="rab1ok" type="submit" value="RAB 1.0L OK"></input>
			<input class="conferma" name="red1ok" type="submit" value="ROSSO 1.0L OK"></input>
			<input class="conferma" name="white1ok" type="submit" value="BIANCO 1.0L OK"></input>
		</form><br/>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<input class="conferma_svuota" name="svuota" type="submit" value="SVUOTA TUTTO"></input>
		</form>
	</div>
	<div align="right">
		<br/><a class="button verde" href="bevande.php">Indietro</a>
	</div>

</body>
