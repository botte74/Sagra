<?php
	$pagetitle = "Sagra Parrocchia di Mandria - RENDICONTO";
	include_once("includes/head.php");
?>
<body>
	<div align="center">
		<a class="button rosso grande" href="statistiche-giorno.php">Rendiconto Giornaliero</a>
		<a class="button rosso grande" href="statistiche-sagra.php">Rendiconto Sagra</a>
	</div>
</body>
<?php
	if($_SESSION['user']=="admin")
		include("includes/footer.php"); ?>
