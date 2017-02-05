function coperti() {
	var ajax = new XMLHttpRequest(); //Volutamente incompatibile con Internet Explorer.

	//Variabili per la scrittura
	var id_coperti = 'giorni';

	var div_coperti = document.getElementById(id_coperti);
	var div_risultato = document.getElementById("chelcazzochetevoi");
	
	var coperti = div_coperti.value;
	
	ajax.onreadystatechange =
		function() {
			if (ajax.readyState == 4)
				if ((ajax.status == 200 && ajax.status < 300)|| (ajax.status == 304)) {
					div_risultato.innerHTML = ajax.responseText;
				}
		}
	//Preparazione invio dati
	var post = "";
	post += "giorni=" + coperti;
	
	//Invio dati
	ajax.open('POST', 'riepilogo/coperti-sagra.php');
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(post);
}
