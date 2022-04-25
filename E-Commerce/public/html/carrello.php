<?php
$link_cartella_immagini = "../assets/img/quadri/";
include("../../src/connessione_database.php");

session_start();
if (isset($_SESSION['utente_ID'])) {
?>
	Benvenuto <?= $_SESSION['utente_ID'] ?>
<?php
}

$_SESSION['prezzo_prodotti_totale'] = 0;
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="icon" type="image/x-icon" href="../assets/ico/carrello.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>carrello</title>
	<link rel="stylesheet" href="../assets/css/style_generale.css" type="text/css">

</head>
<a href="index.php">Home</a><br>
<a href="indirizzo.php">Indirizzo</a><br>

<body>
	<h1>
		Carrello
	</h1>
	<?php
	$query = "SELECT ordine_ID
				FROM ordine
				WHERE data_conferma IS NULL
				AND utente_ID = '" . $_SESSION['utente_ID'] . "';";

	echo $query;
	$result = $conn->query($query);

	$n_rows = $result->num_rows;


	if ($n_rows != 0) {
		foreach ($result as $row) { //togli il for each se possibile
			$ordine_ID = $row['ordine_ID'];
		}

		$_SESSION['ordine_ID'] = $ordine_ID;

		$query = "SELECT quadro_ID
					FROM acquisto
					WHERE ordine_ID = $ordine_ID;";


		$result = $conn->query($query);

		$n_rows = $result->num_rows;

		$flag = 0;

		echo "<table border = \"1\">";

	?>



	<?php



		$result->fetch_all(MYSQLI_ASSOC);
		foreach ($result as $row) {

			$quadro_ID = $row['quadro_ID'];
			if ($flag == 0) {
				$query = "SELECT nome_quadro AS 'Nome Quadro', nome_autore AS Autore, genere AS Genere, descrizione_breve AS Descrizione, prezzo as Prezzo, quantita AS Quantità
							 FROM quadro AS q JOIN acquisto AS a
							 ON q.quadro_ID = a.quadro_ID
							 WHERE q.quadro_ID = '$quadro_ID'
							  AND a.ordine_ID = '$ordine_ID'
							  AND q.quantita_in_magazzino >= a.quantita;";


				$flag = 1;
				//echo "<br><br>start".$query;

			} else {
				$query = "SELECT nome_quadro AS 'Nome Quadro', nome_autore AS Autore, genere AS Genere, descrizione_breve AS Descrizione, prezzo as Prezzo, quantita AS Quantità
						  FROM quadro AS q JOIN acquisto AS a
						  ON q.quadro_ID = a.quadro_ID
						  WHERE q.quadro_ID = '$quadro_ID'
							AND a.ordine_ID = '$ordine_ID'
							AND q.quantita_in_magazzino >= a.quantita
						  UNION
						  $query";

				//echo "<br><br>big".$query;

				//non so perchè funziona sta roba

			}
		}


		$prezzo_totale = 0;
		$result = $conn->query($query);

		foreach ($result as $row) {
			echo "<tr>";
			foreach ($row as $key => $value) {
				echo "<th>$key</th>";
			}
			echo "<th>Prezzo Totale</th>";
			echo "</tr>";
			break;
		}

		foreach ($result as $row) {
			echo "<tr>";
			$nome_quadro = $row['Nome Quadro'];
			$nome_autore = $row['Autore'];
			$genere = $row['Genere'];
			$descrizione_breve = $row['Descrizione'];
			$prezzo = $row['Prezzo'];
			$quantita = $row['Quantità'];

			echo "<td>$nome_quadro</td>";
			echo "<td>$nome_autore</td>";
			echo "<td>$genere</td>";
			echo "<td>$descrizione_breve</td>";
			echo "<td>$prezzo</td>";
			echo "<td>$quantita</td>";
			echo "<td>" . $prezzo * $quantita . "</td>";

			echo "</tr>";

			$prezzo_totale += $prezzo * $quantita;
		}
		echo "</table>";


		echo "prezzo totale = " . $prezzo_totale;
	} else {
		echo "Carrello vuoto.";
	}


	?>
</body>

</html>