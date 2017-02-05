<?php
$pagetitle = "Sagra Parrocchia di Mandria - VISUALIZZA ORDINI";
$style = "../includes/style.css";

include_once("../includes/head.php");

$query_vis_ordini="SELECT * FROM `".$prefix."ordini` ORDER BY id_ordine DESC";
$result=mysqli_query($dbconn,$query_vis_ordini);
?>

<body>
	<div align="center">
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
					<form action="conferma-ordine.php" method="POST" id="form-cerca">
						<input type="hidden" name="ordine" value="<?php echo $result_vis_ordini['id_ordine']; ?>" />
						<input type="hidden" name="nome" value="<?php echo $result_vis_ordini['nome_cliente']; ?>" />
						<input type="hidden" name="tavolo" value="<?php echo $result_vis_ordini['tavolo']; ?>" />
						<input type="hidden" name="coperto" value="<?php echo $result_vis_ordini['coperto']; ?>" />
						<input type="hidden" name="stato" value="<?php echo $result_vis_ordini['stato']; ?>" />
						<td class="data-table"><input type="submit" value="<?php echo $result_vis_ordini['nome_cliente']; ?>" /></td>
					</form>
					<td class="data-table"><?php echo $result_vis_ordini['tavolo']; ?></td>
					<td class="data-table"><?php echo $result_vis_ordini['data_ordine']; ?></td>
					<td class="data-table"><?php echo $result_vis_ordini['fine']; ?></td>
					<td class="data-table"><?php echo $result_vis_ordini['stato']; ?></td>
				</tr>
			<?php }//while ?>
		</table><br/>
	</div>
</body>
<?php include_once("../includes/footer.php"); ?>
