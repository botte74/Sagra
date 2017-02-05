/**
 * div contenente la quantita di quel piatto (con quella variante: 0 se non ha varianti)
 * id="qta-codicePiatto-codiceVariante"
 *
 * div contenente tutto il riquadro del piatto:
 * id="piatto-codicePiatto-codiceVariante"
 *
 * div contenente il selettore del piatto:
 * id = "piatto-codicePiatto-0"
 *
 * funzione che chiama mostra le varianti: mostraVariante(codicePiatto, selettore)
 * dove selettore è il riferimento al select in cui eliminare l'opzione appena "liberata"
 *
 *
 *
 */

/**
 * Ottiene la quantità dal database del piatto selezionato e la immette
 * nel select corrispondente
 * @param codice_piatto: codice del piatto
 * @param variante: variante del $codice_piatto
 * @param contatore_varianti: indice del contatore della $variante
 * @return quantità già impostata
 */
function quantita(codice_piatto, codice_variante) {
	var ajax = new XMLHttpRequest(); //Volutamente incompatibile con Internet Explorer.

	//Variabili per la scrittura
	id_qta = "qta-" + codice_piatto + "-" + codice_variante;
	id_val = "val-" + codice_piatto + "-" + codice_variante;

	var div_qta = document.getElementById(id_qta);
	var div_val = document.getElementById(id_val);
	
	ajax.onreadystatechange =
		function() {
			if (ajax.readyState == 4)
				if ((ajax.status == 200 && ajax.status < 300)|| (ajax.status == 304)) {
					//Scrittura della quantita e settaggio dell'azione successiva
					var risposta = ajax.responseText;
					
					if (risposta != "") {
						div_qta.style.visibility = "";
						div_val.innerHTML = risposta;
					}
					else {
						div_qta.style.visibility = "hidden";
						div_val.innerHTML = "0";
					}
				}
		}
	//Preparazione invio dati
	var post = "";
	post += "piatto=" + codice_piatto + "&variantequantita=" + codice_variante;
	
	//Invio dati
	ajax.open('POST', 'cassa/utility-cassa.php');
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(post);
}


function inviaDati(piatto, codice_variante, azione) {

	var differenza = 0;
	if (azione == "1")
		differenza = +1;
	if (azione == "-1")
		differenza = -1;

	var prezzo = document.getElementById('prezzo');
	id_val = "val-" + piatto + "-" + codice_variante;
	var div_val = document.getElementById(id_val);
	var quantita_attuale = parseInt(div_val.innerHTML);
	var quantita_dopo = parseInt( parseInt(quantita_attuale) + parseInt(differenza) );
	
	if (parseInt(quantita_dopo) < 0)
		return;
	
	var xhr = new XMLHttpRequest(); //Volutamente incompatibile con Internet Explorer.
	
	xhr.onreadystatechange =
		function() {
			if (xhr.readyState == 4)
				if (xhr.status == 200 && xhr.status < 300) {
					prezzo.innerHTML = xhr.responseText;
					quantita(piatto, codice_variante);
				}
		}
	
	//Creazione della stringa da mandare
	//		specifiche: nome=valore&nome2=valore2&nome3=valore3 eccetera
	var post = "";
	post += "piatto=" + piatto;
	post += "&variante=" + codice_variante;
	post += "&quantita=" + quantita_dopo;
	
	//Invio dei dati
	xhr.open('POST', 'cassa/utility-cassa.php');
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
