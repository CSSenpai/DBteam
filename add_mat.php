<html lang="de">
  <head>
    <meta charset="ISO-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
	<link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
    <title>Webapplikation | Oggier Jonas</title>
  </head>
  <body>
<?php

	// Verbindung zu DB
	include 'dbconnect.php';

	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	$check		= $_SESSION['usr_auth'];
	
	include 'header.php';
	
	echo "<a href='main.php' ><button class='back' type='button'>Zurück</button></a>";
	
	// Überprüfung ob Adminrechte vorhanden sind
	if ($check == 1){
		echo "<form enctype='multipart/form-data' style='margin-left: 70px; margin-top: 70px; margin-bottom: -65px;' class='editdrink' method='GET' action=''>";
		echo "<h2>MATERIAL HINZUFÜGEN</h2>";
		echo "<hr>";
			echo "Kategorie: ";
			echo "<select id='inputW' name='mat_categorie' onchange='this.form.submit()' required>";
			  echo "<option disabled selected value> -- wähle eine option -- </option>";
			  echo "<option value='deck' ";
				if (isset($_GET["mat_categorie"]) AND $_GET["mat_categorie"] == 'deck') {
					echo "selected";
				};
			  echo ">Decks</option>";
			  echo "<option value='truck' ";
				if (isset($_GET["mat_categorie"]) AND $_GET["mat_categorie"] == 'truck') {
					echo "selected";
				};
			  echo ">Trucks</option>";
			  echo "<option value='wheel' ";
				if (isset($_GET["mat_categorie"]) AND $_GET["mat_categorie"] == 'wheel') {
					echo "selected";
				};
			  echo ">Wheels</option>";
			echo"</select>";
		echo "</form>";
		echo "<form enctype='multipart/form-data' style='margin-left: 70px;' class='editdrink' method='POST' action=''>";
			echo "Name: ";
			echo "<input id='inputW' type='text' name='mat_name' autocomplete='off' required>";
			echo "<br><br>";
			echo "Brand: ";
			echo "<input minLength='3' maxLength='4' id='inputW' type='text' name='mat_brand' autocomplete='off' placeholder='z.B. BAKER' required>";
			echo "<br><br>";
			echo "Size: ";
			echo "<input minLength='2' maxLength='4' id='inputW' type='text' name='mat_size' autocomplete='off' placeholder='z.B. 8.25' required>";
			echo "<br><br>";
			if (isset($_GET["mat_categorie"]) AND $_GET["mat_categorie"] == "deck") {
				echo "Concave: ";
				echo "<input minLength='4' maxLength='4' id='inputW' type='text' name='mat_concave' autocomplete='off' placeholder='z.B. Mellow'>";
				echo "<br><br>";
			};
			if (isset($_GET["mat_categorie"]) AND $_GET["mat_categorie"] == "truck") {
				echo "Height: ";
				echo "<input minLength='8' maxLength='10' id='inputW' type='text' name='mat_height' autocomplete='off' placeholder='z.B. Mid'>";
				echo "<br><br>";
			};
			if (isset($_GET["mat_categorie"]) AND $_GET["mat_categorie"] == "wheel") {
				echo "Hardness: ";
				echo "<input minLength='2' maxLength='5' id='inputW' type='text' name='mat_hardness' autocomplete='off' placeholder='z.B. 99'>";
				echo "<br><br>";
			};
			echo "Auf Lager: ";
			echo "<input id='inputW' type='number' name='mat_stock' autocomplete='off' placeholder='z.B. 50' required>";
			echo "<br><br>";
			echo "Preis: ";
			echo "<input minLength='1' maxLength='6' id='inputW' type='text' name='mat_price' autocomplete='off' placeholder='z.B. 18.50' required>";
			echo "<br><br>";
			echo "Bewertung: ";
			echo "<input id='inputW' type='number' name='mat_rating' autocomplete='off' placeholder='z.B. 4' required>";
			echo "<br><br>";
			echo "Bild: ";
			echo "<input class='btn' type='file' name='fileToUpload' id='fileToUpload' required>";
			if (isset($_GET["error"])){
				echo "<a class='jpg'>Das Bild muss eine JPG-Datei sein.</a>";
			};
			echo "<br><br>";
			echo "<input class='safeD' type='submit' name='submit' value='Abspeichern'>";
		echo "</form>"; 
		if (isset($_POST["submit"])) {
			$name		= $_POST["mat_name"];
			$brand		= $_POST["mat_brand"];
			$size		= $_POST["mat_size"];
			$stock		= $_POST["mat_stock"];
			$preis		= $_POST["mat_price"];
			$bewertung	= $_POST["mat_rating"];
			$kategorie	= $_GET["mat_categorie"];
			
			if (isset($_POST["mat_concave"])) {
                $concave = $_POST["mat_concave"];
			}else {
				$concave = 0;
			};
			
			if (isset($_POST["mat_height"])) {
                $height = $_POST["mat_height"];
			}else {
				$height = 0;
			};
			
			if (isset($_POST["mat_hardness"])) {
                $hardness = $_POST["mat_hardness"];
			}else {
				$hardness = 0;
			};
			
			$sql = "SELECT MAX(mat_img_id) AS max FROM material";
			$st=$pdo->prepare($sql);
			$st->execute();
			foreach ($pdo->query($sql) as $bow) {
				$bild = $bow["max"] + 1;
			}
			$png = ".PNG";
			
			// Upload vom Bild
			$target_dir = "bilder/material/";
			$target_file = $target_dir . $bild . $png;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
			// Überprüfung ob die Datei ein echtes Bild ist
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				};
			};
			
			// Überprüfung ob das Bild schon existiert
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			};
			
			// Überprüfung ob das Bild ein PNG ist
			if($imageFileType !== "PNG") {
				header('Location: add_mat.php?error=true');
				exit;
			};
			
			// Überprüft ob $uploadOk wegen einem Error auf 0 gesetzt ist
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// wenn alles ok ist, dann wird die Datei hochgeladen
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				};
			};
			
			$sql = "INSERT INTO material (mat_name, mat_brand, mat_size, mat_concave, mat_height, mat_hardness, mat_stock, mat_price, mat_rating, mat_categorie, mat_img_id) VALUES ('$name', '$brand', '$size', '$concave', '$height', '$hardness', $stock, '$preis', $bewertung, '$kategorie', $bild)";
			$st=$pdo->prepare($sql);
			$st->execute();
			header('Location: main.php');
			exit;		
		};		
	};	
	
	//Footer
	include 'footer_two.php';
	
?>
  </body>
</html>