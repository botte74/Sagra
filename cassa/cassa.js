/**
 *	Modifica il VALUE di un input nascosto nel form della
 *	quantità, in modo da inviare il codice della variante.
*/
function modificaID(variante, codice_piatto, select_varianti, contatore_varianti) {
	var id_sel = "select-" + codice_piatto + "-" + contatore_varianti;
	var select = document.getElementById(id_sel);
	if (variante == "nothing") {
		select.disabled = true;
		return;
	}
	else {
		//Quantita abilitata
		select.disabled = false;
		//Selezione variante attuale disabilitata
		select_varianti.disabled = true;
		//Inserimento codice alimento in form
		var form = document.getElementById("form-" + codice_piatto + "-" + contatore_varianti);
		form["variante"].value = variante;
		//Ottenimento della quantità e scrittura della stessa
		quantita(codice_piatto, variante, contatore_varianti);
		//Nuova riga visualizzata
		contatore_varianti++;
		var next = document.getElementById("piatto-" + codice_piatto + "-" + contatore_varianti);
		next.style.display = "";
		//Eliminazione delle opzioni uguali dalle successive righe
		var righe = document.getElementsByName("variante-" + codice_piatto + "-" + variante);
		for (var i =0; i < righe.length; i++) {
			righe[i].disabled = true;
		}
	}
}

/**
 * Ottiene la quantità dal database del piatto selezionato e la immette
 * nel select corrispondente
 * @param codice_piatto: codice del piatto
 * @param variante: variante del $codice_piatto
 * @param contatore_varianti: indice del contatore della $variante
 * @return quantità già impostata
 */
function quantita(codice_piatto, variante, contatore_varianti) {
	var ajax = new XMLHttpRequest(); //Volutamente incompatibile con Internet Explorer.

	//Variabili per la scrittura
	var form = document.getElementById("form-" + codice_piatto + "-" + contatore_varianti);
	var select = form["quantita"];
	
	ajax.onreadystatechange =
		function() {
			if (ajax.readyState == 4)
				if ((ajax.status == 200 && ajax.status < 300)|| (ajax.status == 304)) {
					//Scrittura della quantita e settaggio dell'azione successiva
					var risposta = ajax.responseText;
					select.value = risposta;
					if (risposta != 0)
						form["azione"].value = "modifica";
					else
						form["azione"].value = "inserisci";
				}
		}
	//Preparazione invio dati
	var post = "";
	post += "piatto=" + codice_piatto + "&variantequantita=" + variante;
	
	//Invio dati
	ajax.open('POST', 'utility-cassa.php');
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(post);
}


function inviaDati(piatto, contatore_variante) {
	
	
	var xhr = new XMLHttpRequest(); //Volutamente incompatibile con Internet Explorer.
	var prezzo = document.getElementById('prezzo');
	
	//Raccolta dei dati
	var form = document.getElementById("form-" + piatto + "-" + contatore_variante);
	var variante = form["variante"].value;
	var quantita = form["quantita"].value;
	
	xhr.onreadystatechange =
		function() {
			if (xhr.readyState == 4)
				if (xhr.status == 200 && xhr.status < 300)
					prezzo.innerHTML = xhr.responseText;
		}
	

	//Creazione della stringa da mandare
	//		specifiche: nome=valore&nome2=valore2&nome3=valore3 eccetera
	var post = "";
	post += "piatto=" + piatto;
	post += "&variante=" + variante;
	post += "&quantita=" + quantita;

	//Invio dei dati
	xhr.open('POST', 'utility-cassa.php');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(post);
}

function validaForm() {
	var form = document.getElementById("form-ordine");
	var nome = form["nome"];
	var coperto = form["coperto"];
	if ((nome.value == "") || (coperto.value == "")) {
		if (nome.value == "")
			nome.style.border = "3px solid red";
		if (coperto.value == "")
			coperto.style.border = "3px solid red";
		location.href = "#header-ordini";
		return false;
	}
	return true;
}

function formSubmit() {
	if (!validaForm())
		return;
	var form = document.getElementById("form-ordine");
	form.submit();
}
