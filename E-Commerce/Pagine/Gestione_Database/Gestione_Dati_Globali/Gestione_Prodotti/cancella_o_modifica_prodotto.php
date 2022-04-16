<?php
	session_start();
	if(isset($_SESSION['utente_ID'])){
		echo "Benvenuto ".$_SESSION['utente_ID'];
	}
?>

<?php
	include("../../../../Connessione_Database/connessione_database.php");
?>

<!DOCTYPE html>
<html>
  <head>
  	<link rel="icon" type="image/x-icon" href="../../Immagini/Icone/carrello.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>carrello</title>
    <link href="style.css" rel="stylesheet" type="text/css" />

  </head>
  <a href = "../Index/index.php">Home</a><br>
  <a href = "../Ordina/Indirizzo/indirizzo.php">Indirizzo</a><br>
  <body>
    <h1>
      Carrello
    </h1>
    <?php
		$query = "SELECT quadro_ID AS 'Quadro ID', 
                         nome_quadro AS 'Nome Quadro', 
                         nome_autore AS 'Nome Autore', 
                         nazione_di_origine AS 'Nazione di Origine', 
                         genere AS 'Genere', 
                         descrizione_breve AS 'Descrizione Breve', 
                         descrizione_dettagliata AS 'Descrizione Dettagliata', 
                         prezzo AS 'Prezzo', 
                         quantita_in_magazzino AS 'Quantità', 
                         link_quadro AS 'Link Quadro' 
				FROM quadro
                WHERE quadro_ID = '".$_GET['quadro_ID']."'";

            echo $query;

			$result = $conn -> query($query);
			
            echo "<table border = 1>";

			foreach($result as $row){
						echo "<tr>";
						foreach($row as $key => $value){
							echo "<th>$key</th>";
						}
						//echo "<th>Cancella/Modifica</th>";
						echo "</tr>";
						break;	
					}
			
			foreach($result as $row){
				echo "<tr>";
                $quadro_ID = $row['Quadro ID'];
				$nome_quadro = $row['Nome Quadro'];
				$nome_autore = $row['Nome Autore'];		
                $nazione_di_origine = $row['Nazione di Origine'];
				$genere = $row['Genere'];
				$descrizione_breve = $row['Descrizione Breve'];
                $descrizione_dettagliata = $row['Descrizione Dettagliata'];
				$prezzo = $row['Prezzo'];
				$quantita = $row['Quantità'];
                $link_quadro = $row['Link Quadro'];
				
                //cambia tutta sta roba
				echo "<td>$quadro_ID</td>";
                echo "<td><input type = \"text\" name = \"nome_quadro\" value = \"$nome_quadro\"></td>";
                echo "<td><input type = \"text\" name = \"nome_autore\" value = \"$nome_autore\"></td>";
                echo "<td><input type = \"text\" name = \"nazione_di_origine\" value = \"$nazione_di_origine\"></td>";
                echo "<td><input type = \"text\" name = \"genere\" value = \"$genere\"></td>";
                echo "<td><input type = \"text\" name = \"descrizione_breve\" value = \"$descrizione_breve\"></td>";
                echo "<td><input type = \"text\" name = \"descrizione_dettagliata\" value = \"$descrizione_dettagliata\"></td>";
                echo "<td><input type = \"text\" name = \"prezzo\" value = \"$prezzo\"></td>";
                echo "<td><input type = \"text\" name = \"quantita\" value = \"$quantita\"></td>";
                echo "<td><input type = \"text\" name = \"link_quadro\" value = \"$link_quadro\"></td>";

                //echo "<td><a href = \"cancella_o_modifica_prodotto.php?quadro_ID=$quadro_ID\">Cancella/Modifica</td>";
				
				echo "</tr>";
				
	
					
				}
			echo "</table>";
			
	

			



		
		
		
		?>
  </body>
  
</html>