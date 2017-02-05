<?php
$pagetitle = "Sagra Parrocchia di Mandria - CERCA ORDINI";
include_once("includes/head.php");

$num_ordine=$_POST['numOrdine'];

?>
<style>
	.textOrdine{
			width:15%;
			font-size:50px;
	}
</style>
<body>
	<div align="left">
		<h1>Inserisci il codice dell'Ordine</h1>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<input class="ordine" type="text" name="numOrdine"></input>
			<input class="button" type="submit" value="CERCA"></input>
		</form>
		<?php
			if(isset($num_ordine) && $num_ordine!=NULL){
				$query_vis_ordini="SELECT * FROM `".$prefix."ordini` WHERE id_ordine='$num_ordine'";
				$result=mysqli_query($dbconn,$query_vis_ordini);
				if(mysqli_num_rows($result)!=0){?>
					<table class="data-table">
						<th class="data-table">Num Ordine</th>
						<th class="data-table">Nome Cliente</th>
						<th class="data-table">Tavolo / Asporto</th>
						<th class="data-table">Data Ordine</th>
						<th class="data-table">Fine</th>
						<th class="data-table">Stato</th>
						<?php while($result_vis_ordini=mysqli_fetch_array($result)){?>
							<tr class="data-table">
								<td class="data-table"><?php echo $result_vis_ordini['id_ordine']; ?></td>
								<td class="data-table"><?php echo $result_vis_ordini['nome_cliente']; ?></td>
								<td class="data-table"><?php echo $result_vis_ordini['tavolo']; ?></td>
								<td class="data-table"><?php echo $result_vis_ordini['data_ordine']; ?></td>
								<td class="data-table"><?php echo $result_vis_ordini['fine']; ?></td>
								<td class="data-table"><?php echo $result_vis_ordini['stato']; ?></td>
							</tr>
						<?php }//while ?>
					</table>
			<?php }//if
				else
					echo "<h1>Ordine " .$num_ordine. " non trovato!</h1>";
			}//if?>
	</div>
	<div align="right">
		<br/><a class="button verde" href="distribuzione.php">Indietro</a>
	</div>
</body>
