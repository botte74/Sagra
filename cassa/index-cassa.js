function validaCassiere() {
	var form = document.getElementById("form-cassa");
	if (form['cassa'] == "")
		return false;
	if (form['cassiere'] == "")
		return false;
	if (form['saldo'] == "")
		return false;
	return true;
}
