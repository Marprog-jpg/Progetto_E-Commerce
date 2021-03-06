<?php
include("../../src/connessione_database.php");

session_start();
$link_cartella_immagini = "../assets/img/quadri/";
?>
<!DOCTYPE html>
<html>

<head>
	<link rel="icon" type="image/x-icon" href="../assets/ico/login.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Login</title>
	<link rel="stylesheet" href="../assets/css/login.css" type="text/css">
	<link rel="stylesheet" href="../assets/css/style_generale.css" type="text/css">

	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css'>


</head>

<body class="bodyLogin">

	<div id="div_login">
		<h1>Pagina di Login</h1>


		<div class="wrapper_login">
			<a href="#" class="icon facebook">
				<span><i class="fab fa-facebook-f"></i></span>
			</a>
			<a href="#" class="icon twitter">
				<span><i class="fab fa-twitter"></i></span>
			</a>
			<a href="#" class="icon instagram">
				<span><i class="fab fa-instagram"></i></span>
			</a>
			<a href="#" class="icon github">
				<span><i class="fab fa-github"></i></span>
			</a>
			<a href="#" class="icon youtube">
				<span><i class="fab fa-youtube"></i></span>
			</a>
		</div>

		<br>
		<!-- social per l'accesso -->
		<form method="post">
			Username <input class="input_login" type="text" name="username">
			<br>Password <input class="input_login" type="password" name="password">
			<input class="button_login" type="submit" value="Login"><br>
			<a class="link_login" href="index.php">Home</a><br>
			Non hai un account?<a class="link_login_registrazione" href="registrazione.php">Registrazione</a><br>
		</form>
	</div>

	<?php

	if (
		isset($_POST['username'])
		&& isset($_POST['password'])
	) {

		/*$_SESSION['username'] = $_POST['username'];
				$_SESSION['password'] = $_POST['password'];*/


		$query = "SELECT utente_ID, ruolo_ID, password FROM dati_utente WHERE username = '" . $_POST['username'] . "';";


		$result = $conn->query($query);

		$n_rows = $result->num_rows;

		$conn->close();

		if ($n_rows == 0) {
			echo "Login fallito, username e/o password sbagliata.";
		} else {


			foreach ($result as $row) { //togli il for each se possibile
				$ruolo_ID = $row['ruolo_ID'];
				$utente_ID = $row['utente_ID'];
				$hashed_password = $row['password'];
			}
			if (password_verify($_POST['password'], $hashed_password)) {
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['ruolo_ID'] = $ruolo_ID;
				$_SESSION['utente_ID'] = $utente_ID;
				echo "Login effettuato. Ti riporto alla pagina iniziale...";
				header("Refresh:1; url = index.php", true, 303);
			} else {
				echo "Login fallito, username e/o password sbagliata.";
			}
		}
	}

	?>
	<script>
		//serve per cancellare il form dopo che e' stato inserito nel DB
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>


</body>

</html>