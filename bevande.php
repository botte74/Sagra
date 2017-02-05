<?php
$pagetitle = "Sagra Parrocchia di Mandria - BEVANDE";
include_once("includes/head.php");
?>

<style>

</style>

<body>
    <div align="center">
        <a class="buttonBevande" href="bevande-ordini.php">Ordini</a><br/>
        <a class="buttonBevande" href="bar.php">Paninoteca</a><br/>
    </div>
	<?php
	if($_SESSION['user']=="admin")
		include("includes/footer.php"); ?>
</body>
