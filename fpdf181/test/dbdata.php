<?php
//DB Connection
$servername ="localhost";
$username = "root";
$password = '';
$dbname = "lebenslauf";
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Datenabfrage
$abfrage = "SELECT * FROM persoenlichedaten";
$ergebnis = mysqli_query($conn, $abfrage);
if ( ! $ergebnis){
	die('Ungülitge Abfrage');
}

while ($zeile = mysqli_fetch_array($ergebnis))
{
	$vorundnachname = $zeile['vorundnachname'];
	$geburtsdatum = $zeile['geburtsdatum'];
	$nationalitaet = $zeile['nation'];
	$funktion = $zeile['funktion'];
	$maid = $zeile['maid'];

}

//Abfragen Sprachen
$abfragesprachen = "SELECT * FROM sprachen";
$ergebnissprachen = mysqli_query($conn, $abfragesprachen);

while ($zeile = mysqli_fetch_array($ergebnissprachen))
{
	$sprachen = $zeile['sprachen'];
	$kenntnis = $zeile['kenntnis'];
}

// $abfrage2 = "SELECT * FROM persoenlichedaten WHERE maid = $maid";

// $abfrage3 = "SELECT * FROM persoenlichedaten INNER JOIN sprachen ON persoenlichedaten.maid = sprachen.maid";
// $ergebnissprachen = $conn->query($abfrage3);
// $ergebnissprachen = mysqli_query($conn, $abfrage3);
// if ( ! $ergebnissprachen){
	// die('Ungülitge Abfrage');
// }
// while ($zeilesprachen = mysqli_fetch_array($ergebnissprachen))
// {
		// $sprachen =	$zeilesprachen['sprachen'];
		// $kenntnis = $zeilesprachen['kenntnis'];
// }


// if($ergebnissprachen->num_rows >= 0){
	// while($zeilesprachen = $ergebnissprachen->fetch_assoc()) {
		// $sprachen =	$zeilesprachen['sprachen'];
		// $kenntnis = $zeilesprachen['kenntnis'];
	// }
// }

?>