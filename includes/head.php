<?php
	include_once("config.php");
	if ( (basename($_SERVER["PHP_SELF"]) != "index.php") && (basename($_SERVER["PHP_SELF"]) != "EG256AM-AZ137PW.php") )
		if (!isset($_SESSION['user']))
			header("Location: index.php");
		else
			$username = $_SESSION['user'];
?>
<!DOCTYPE html>
	<head>
		<title><?php echo $pagetitle; ?></title>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<?php if (isset($style)) { ?>
			<link type="text/css" rel="stylesheet" href="<?php echo $style; ?>" />
		<?php } else { ?>
			<link type="text/css" rel="stylesheet" href="includes/style.css" />
		<?php } if (isset($script)) { ?>
			<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
	</head>
	<body>
		<div id="wrapper">
			<?php if (!isset($_SESSION['user']) && (basename($_SERVER["PHP_SELF"]) == "EG256AM-AZ137PW.php") ) { ?>
				<div id="login">
					<form action="includes/login.php" method="POST">
						<p>Username</p>
						<input type="text" name="user"></input>
						<p>Password</p>
						<input type="password" name="passwd"></input><br />
						<input type="submit" value="ENTRA"></input>
					</form>
				</div>
				<?php } else {
				if (basename($_SERVER["PHP_SELF"]) == $_SESSION['homepage']) { ?>
					<div id="login">
						<p>Ciao <?php echo $_SESSION['user']; ?></p>
						<form action="includes/logout.php" method="POST">
						<input type="hidden" name="logout" value="true" />
						<input type="submit" value="logout" />
					</form>
					</div>
				<?php }
				} ?>
			<h1><?php echo $pagetitle; ?></h1>
			<br />
