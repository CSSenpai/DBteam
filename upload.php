<?php
	// Verbindung zu DB
	include 'dbconnect.php';
	
	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	$check		= $_SESSION['usr_auth'];
	
	// Überprüfung ob Adminrechte vorhanden sind
	if ($check == 1){
		$png 	= ".PNG";
		$bild 	= "$_POST[img_id]";
		$mat_id = "$_POST[mat_id]";		
		
		// Löscht das alte Bild
		$target_dir = "bilder/material/";
		$target_file = $target_dir . $bild . $png;
		unlink($target_file) or die("Couldn't delete file");
		
		// Upload von neuem Bild
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		// Überprüfung ob die Datei ein echtes Bild ist
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		
		// Überprüfung ob das Bild schon exestiert
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		
		// Überprüfung ob das Bild ein PNG ist
		if($imageFileType !== "PNG") {
			header('Location: edit_mat.php?mat_id='. $mat_id . '&error=true');
			exit;
		}
		
		// Überprüft ob $uploadOk wegen einem Error auf 0 gesetzt ist
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// wenn alles ok ist, dann wird die Datei hochgeladen
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		};
	
		header('Location: overview.php?mat_id='. $mat_id .'');
		exit;				
	};	
?>