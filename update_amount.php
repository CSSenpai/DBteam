<?php 
	// Verbindung zu DB
	include 'dbconnect.php'; 

	// Session-Variabeln
	$benutzer = $_SESSION['usr_name'];
	
	// Menge wurde in warenkorb.php angepasst
	if (isset($_GET["theamount"])) {
		$neu		= $_GET["theamount"];
		$id 		= $_GET["id"];
	// Menge wurde in main.php angepasst
	}else {
		$neu		= $_GET["theamount"];
		$id 		= $_GET["id"];
	};
	
	$sql = "SELECT * FROM user_has_mat WHERE user_usr_name = '$benutzer' AND mats_mat_id = $id AND date IS NULL;";
	foreach ($pdo->query($sql) as $row) {
		// Wenn die Menge unter 1 kommt, dann wird der Eintrag gelöscht
		if ($row["amount"] == 1 AND $_GET["theamount"] == "low") {
			$sql = "DELETE FROM user_has_mat WHERE mats_mat_id = $id AND user_usr_name = '$benutzer' AND date IS NULL;";
			//echo "$sql";
			$st=$pdo->prepare($sql);
			$st->execute();
		// Menge wird +1
		}elseif ($_GET["theamount"] == "add") {
			$neu = $row["amount"] + 1;
		// Menge wird -1
		}elseif ($_GET["theamount"] == "low") {
			$neu = $row["amount"] - 1;
		};
	};
	
	// Update des DB Eintrages	
	$sql = "UPDATE user_has_mat SET amount = $neu WHERE user_usr_name = '$benutzer' AND mats_mat_id = $id AND date IS NULL;";
	$st=$pdo->prepare($sql);
	$st->execute();
	
	header('Location: warenkorb.php');
	exit;

?>