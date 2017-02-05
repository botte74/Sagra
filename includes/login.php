<?php
	session_start();
	include_once("config.php");
	$username=$_POST["user"];
	$password=md5($_POST["passwd"]);
	$query="SELECT `username`, `password`, `homepage` from `" . $prefix . "users` WHERE `username`='$username' AND `password`='$password'";
	$result=mysqli_query($dbconn,$query);
	$user = mysqli_fetch_array($result);

	if (mysqli_num_rows($result)==0){
		header('Location: ../EG256AM-AZ137PW.php?login=false');
	}
	else{
		//Informazioni sull'utente
		$homepage = $user['homepage'];

		//Scrittura variabili di sessione
		$_SESSION['user'] = $username;
		$_SESSION['privileges'] = $privileges;
		$_SESSION['homepage'] = $homepage;

		//Salvataggio giorno settimana
		$giorni = array('domenica','lunedi','martedi','mercoledi','giovedi','venerdi','sabato');
		$_SESSION['giorno'] = $giorni[date('w',strtotime("now"))];

		//Redirizione
		header('Location: ../' . $homepage);
	}
?>
