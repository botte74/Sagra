<?php
$pagetitle = "Sagra Parrocchia di Mandria - PERSONALE";
include_once("includes/head.php");

if (isset($_POST['giorno'])) {
	if ($_POST['giorno'] != "lascia")
		$_SESSION['giorno'] = $_POST['giorno'];
}

$_SESSION['ordine'] = null;
unset($_SESSION['ordine']);

if (isset($_GET['login']))
    if ($_GET['login'] == "false") {
        ?>
        <div class="operazione non-eseguita">
            <p>Credenziali di login sbagliate. Riprovare.</p>
        </div>
    <?php } ?>

<?php if (isset($_SESSION['user'])) { ?>
<br/><br/>
	<div id="giorno">
		<p>Oggi &egrave;: <?php echo $_SESSION['giorno']; ?></p>
		<p>Se vuoi cambiare (per debug):</p>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <select onchange="this.form.submit()" name="giorno">
            <option value="lascia">Seleziona Giorno</option>
	    <option value="mercoledi">Mercoled&igrave;</option>
            <option value="giovedi">Gioved&igrave;</option>
            <option value="venerdi" >Venerd&igrave;</option>
            <option value="sabato" >Sabato</option>
            <option value="domenica" >Domenica</option>
            <option value="lunedi" >Luned&igrave;</option>
            <option value="martedi" >Marted&igrave;</option>
        </select>
		</form>
	</div>
	<?php if ( ($_SESSION['user'] == "admin") || ($_SESSION['user'] == "attilio") ) { ?>
        <a class="button verde" href="bar.php">Paninoteca</a><br/>
        <a class="button verde" href="index-cassa.php">Cassa</a><br/>
        <!--<a class="button verde" href="cucina-fredda.php">Cucina Fredda</a><br/> -->
        <!--<a class="button verde" href="distribuzione.php">Distibuzione</a><br/> -->
        <a class="button verde" href="griglie.php">Griglie</a><br/>
        <!--<a class="button verde" href="paninoteca.php">Paninoteca</a><br/> -->
        <a class="button verde" href="sara.php">S.A.R.A.</a><br/>
        <a class="button rosso" href="statistiche.php">Rendiconto Generale</a><br/>
        <a class="button rosso" href="statistiche.php">Statistiche</a><br/>
        <a class="button rosso" href="cassa/vis-ordini.php">Visualizza Ordini</a><br/>
        <a class="button rosso" href="menu.php">Visualizza Menu</a><br/>
    <?php }
} else { ?>
    <div id="cagate-costa">
        <p>Spazio riservato al personale della sagra</p>
        <p>Contatta Francesco Costa o Matteo Giacomazzo se non sai cosa fare</p>
        <p>Non fare cose che non sei autorizzato a fare. Pena: <strong>una verruca sullo sfintere anale</strong>!!!!</p>
        <h1><img style="width:20%; margin:10px; text-align: center; vertical-align: middle" src="includes/jesus_yeah.jpg" />Ricordati: Jesus Approve This Site!</h1>
    </div>

<?php } ?>
<?php include_once("includes/footer.php"); ?>
