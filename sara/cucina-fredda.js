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
