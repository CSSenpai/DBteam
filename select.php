<?php
	//Kategorie ermitteln (Decks, Trucks, Wheels)
	if (isset($_GET["type"])) {
		$type = $_GET["type"];
	}else {
		$type = 'none';
	}
	
	//Check ob etwas gesucht wird
	if (isset($_GET['suche'])){
		$suche = $_GET['suche'];
	};
	
	//Ceck SQL Statements
	if ($type == 'decks') {
		$sql = "SELECT * FROM material WHERE mat_categorie = 'deck'";
	} elseif ($type == 'trucks') {
		$sql = "SELECT * FROM material WHERE mat_categorie = 'truck'";
	} elseif ($type == 'wheels') {
		$sql = "SELECT * FROM material WHERE mat_categorie = 'wheel'";
	}elseif (isset($_GET['suche'])) {
		$sql = "SELECT * FROM material WHERE (`mat_name` LIKE '%".$suche."%' OR `mat_brand` LIKE '%".$suche."%');";
	}elseif ($type == 'none') {
		$sql = "SELECT * FROM material";
	};
?>