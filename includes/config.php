<?php
	$host = "localhost";
	$db_user = "root";
	$db_name = "rqslpelw_sagra";
	$db_password = "mandria";
	$prefix = "c71po_";
	$dbconn = mysqli_connect($host, $db_user, $db_password,$db_name);
	$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
	$mysqli->query("SET NAMES uft8");
	$mysqli->query("SET CHARACTER SET utf8");
	$db_user = NULL;
	$db_name = NULL;
	$db_password = NULL;
	$webroot = "http://192.168.1.37/sito/";
	ini_set('session.gc_maxlifetime', 60*60*10); // 60*60*10 = 10 ore
	session_start();
?>
