<?php 

	// Verbindung zu DB
	include 'dbconnect.php';

	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	$check		= $_SESSION['usr_auth'];
	$mat_id		= $_GET["mat_id"];

	// Überprüfung ob Adminrechte vorhanden sind
	if ($check == 1){
		$sql = "DELETE FROM user_has_mat WHERE mats_mat_id = $mat_id AND user_usr_name = '$user'";
		$st=$pdo->prepare($sql);
		$st->execute();
		$pdo->exec("DELETE FROM notes WHERE note_mat_id = $mat_id");
		
		$sql="SELECT * FROM material WHERE mat_id = $mat_id";
		$st=$pdo->prepare($sql);
		$st->execute();

		while($res = $st->fetchObject()){//loop through the returned rows	
			$img_id = $res->mat_img_id;
			$target = "bilder/material/";
			
			// Bild wird aus dem Ordner gelöscht
			$myFile = "$target" . "" . "$img_id" . ".PNG";
			echo "<br>$myFile";
			unlink($myFile) or die("Couldn't delete file");
		};
		
		// Bild wird aus der Datenbank gelöscht
		$pdo->exec("DELETE FROM material WHERE mat_id = $mat_id");

	};
			
	header('Location: main.php');
	exit;	
	
?>