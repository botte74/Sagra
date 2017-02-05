var pagato = null;

function ispagato() {
	var pagaestampa = document.getElementById('pagaestampa');
	var modifica = document.getElementById('modificaordine');
	var nuovoordine = document.getElementById('nuovoordine');
	var nuovospeciale = document.getElementById('nuovospeciale');
	var stato = "";

	var xhr = new XMLHttpRequest(); //Volutamente incompatibile con Internet Explorer.
	//Ricezione dei dati
	xhr.onreadystatechange =
		function() {
			if (xhr.readyState == 4)
				if (xhr.status == 200 && xhr.status < 300)
					stato = xhr.responseText;
					if (stato == "pagato") {
						pagaestampa.innerHTML = "Stampa";
						modifica.style.visibility = "hidden";
						nuovoordine.style.visibility = "visible";
						nuovospeciale.style.visibility = "";
						clearTimeout(pagato);
					}
					
		}
	//Invio dei dati
	xhr.open('POST', 'conferma-utility.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("stato=chiedi");
}

function paga() {
	pagato = setTimeout('ispagato()', 1000);
}

function resto() {
		var resto   = document.getElementById("resto");
		var acconto = document.getElementById("acconto");
		var prezzo	= document.getElementById("prezzo");
		
		var resto_var = parseFloat( parseFloat(acconto.value) - parseFloat(prezzo.innerHTML) );
		
		if (resto_var < 0 )
			resto.innerHTML = "Altri Soldi";
		else
			resto.innerHTML = resto_var;
	}
