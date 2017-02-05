function inviaForm() {
	if (!convalidaForm())
		return;
	var form = document.getElementById("form-speciale");
	var prezzo = form['prezzo'].value;
	var prezzo_giusto = convalidaNumero(prezzo);
	form['prezzo'] = prezzo_giusto;
	form.submit();
}

/**
 * Dato un numero in formato testo, restituisce un numero in formato
 * americano con due cifre dopo il punto.
 */
function convalidaNumero(numero) {
	nuovo = numero.replace(",",".");
	nuovo.trim();
	return nuovo;
}

function convalidaForm() {
	var form = document.getElementById("form-speciale");
	if (form['nome'].value == "")
		return false;
	if (form['coperto'].value == "")
		return false;
	return true;
}
