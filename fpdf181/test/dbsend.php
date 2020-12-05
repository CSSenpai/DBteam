<?php
//DB Connection
$servername ="localhost";
$username = "root";
$password = '';
$dbname = "lebenslauf";
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Daten aus Formular
$vorundnachname1 = $_POST["vorundnachname"];
$geburtsdatum1 = $_POST["geburtsdatum"];
$nationalitaet1 = $_POST["nationalitaet"];
$funktion1 = $_POST["funktion"];
$sprachen = $_POST["sprache"];
$kenntnis = $_POST["kenntnis"];

//Daten eintragen
$eintrag = "INSERT INTO persoenlichedaten (vorundnachname, geburtsdatum, nation, funktion) 
			VALUES('$vorundnachname1', '$geburtsdatum1', '$nationalitaet1', '$funktion1')";
$eintragen = mysqli_query($conn, $eintrag);
if ($eintragen == true);
{
	echo "Erfolgreich</br>";
}

//Sprachen und Kenntnisse eintragen
$eintragsprache = "INSERT INTO sprachen (sprachen, kenntnis)
					VALUES ('$sprachen', '$kenntnis')";
$eintragensprache = mysqli_query($conn, $eintragsprache);
					


$abfrage = "SELECT maid FROM persoenlichedaten";
$ergebnis = mysqli_query($conn, $abfrage);
if ( ! $ergebnis){
	die('Ungülitge Abfrage');
}

while ($zeile = mysqli_fetch_array($ergebnis))
{
	$maid = $zeile['maid'];
}

echo 'Deine ID ist die '.$maid;

?>
<html>
<body>
<a href="ausgabe.php">Weiter</a>
</body>
</html>