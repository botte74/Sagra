<?php
	$pagetitle = "Sagra Parrocchia di Mandria - DISTRIBUZIONE";
	include_once("includes/head.php");
?>
	<div class="bevande">
		<form action="richiesta.php" method="POST">
			<input class="richiesta" type="submit" name="pollo05" value="1/2 POLLO" />
			<input class="richiesta" type="submit" name="pollo025" value="1/4 POLLO" />
			<input class="richiesta" type="submit" name="costine" value="COSTINE" />
			<input class="richiesta" type="submit" name="salsicce" value="SALSICCE" />
			<input class="richiesta" type="submit" name="pancetta" value="PANCETTA" />
			<input class="richiesta" type="submit" name="polenta" value="POLENTA" />
			<input class="richiesta" type="submit" name="patatine" value="PATATINE" />
			<input class="richiesta" type="submit" name="bigoli" value="BIGOLI" /><br/><br/>
		</form>	
		<form action="richiesta.php" method="POST">
			<input class="richiesta" type="submit" disabled="disabled" value="BISTECCA" />
			<select class="invia_bistecca" name="bistecca" >
				<option value="nothing">Num Bistecche...</option>
				<?php for($i=1;$i<6;$i++){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php }//for ?>
			</select>
			<input class="invia_bistecca" type="submit" value="INVIA" /><br/>
		</form>
		<form action="richiesta.php" method="POST">
			<input class="richiesta" type="submit" disabled="disabled" value="COTOLETTA" />
			<select class="invia_bistecca" name="cotoletta">
				<option value="nothing">Num Cotolette...</option>
				<?php for($i=1;$i<6;$i++){ ?>
					<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php }//for ?>
			</select>
			<input class="invia_bistecca" type="submit" value="INVIA" />
		</form>
	</div>

