<!doctype html>
<?php

  include_once('includes/config.php');

  $prodotti_q = "SELECT * FROM c71po_piatti WHERE vista=1";
  $result = mysqli_query($dbconn, $prodotti_q);
  $prodotti = array();
  while ($row = mysqli_fetch_array($result))
  {
    $prodotto = (object) array();
    foreach ($row as $key=>$value)
    {
      $prodotto->$key = $value;
    }
    $prodotti[] = $prodotto;
  }

  //CREAZIONE DELL'ORDINE (Solo Stato)
	if (!isset($_SESSION['ordine']) ) {
		$id_cassa = $_SESSION['id_cassa'];
		$ordine_query = "INSERT INTO `" . $prefix . "ordini` (`stato`, `prezzo_totale`, `cassa`,`tipo`) VALUES ('ibernato', '0',666,2);";
		mysqli_query($dbconn, $ordine_query);
		echo mysqli_error($dbconn);
		$ordine = mysqli_insert_id($dbconn);
		$_SESSION['ordine'] = $ordine;
		$prezzo = "0.00";
		$nome="";
		$tavolo="";
		$coperto="";
	}

?>
<head>
  <title>BAR</title>
  <link rel="stylesheet" href="includes/bootstrap.min.css" type="text/css" />
  <script type="text/javascript" src="includes/jQuery.js"></script>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <script type="text/javascript">
    var ordinati = new Array();

    function subtotal(codice, nome)
    {
      var riga = document.getElementById('riga-'+codice);
      riga.style.display = "";
      ordinati.pop(codice);
      var quantita = document.getElementById('quantita-'+codice);
      quantita.innerHTML = parseInt(quantita.innerHTML) + 1;
    }

    function getProducts() {
      $('#subtotal > #riga-'.$)
    }
  </script>
</head>
<body>
  <div class="container-fluid">

    <div class="col-xs-9 col-lg-9">
      <?php foreach($prodotti as $prodotto) { ?>
        <a href="javascript:subtotal(<?php echo $prodotto->codice . ',\'' .$prodotto->nome.'\''; ?>)" class="btn btn-warning btn-lg"><?php echo $prodotto->nome; ?></a>
      <?php } ?>
    </div>

    <div class="col-xs-3 col-lg-3">
      <h3>Spine</h3>
      <table id="subtotal" class="table">
        <?php foreach($prodotti as $prodotto) { ?>
          <tr class="products" style="display: none;" id="riga-<?php echo $prodotto->codice; ?>"><td><?php echo $prodotto->nome; ?></td><td id="quantita-<?php echo $prodotto->codice; ?>">0</td></tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>
</body>
