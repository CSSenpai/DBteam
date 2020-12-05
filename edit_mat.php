<html lang="de">
  <head>
    <meta charset="ISO-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
	<link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
    <title>Webapplikation | Jonas und Nicolas</title>
  </head>
  <body>
<?php

	// Verbindung zu DB
	include 'dbconnect.php';

	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	$check		= $_SESSION['usr_auth'];
	
	$mat_id		= $_GET["mat_id"];
	
	include 'header.php';
	echo "<a href='overview.php?mat_id=$mat_id' ><button class='back' type='button'>Zurück</button></a>";
	
	// Überprüfung ob Adminrechte vorhanden sind
	if ($check == 1){
		$sql = "SELECT * FROM material WHERE mat_id = $mat_id";
		$st=$pdo->prepare($sql);
		$st->execute();

		while($res = $st->fetchObject()){//loop through the returned rows
			echo "<form style='width: 400px; margin-left: 70px;' class='editdrink' method='POST' action=''>";
			echo "<h2>MATERIAL BEARBEITEN</h2>";
			echo "<hr>";
				echo "Name: ";
				echo "<input id='inputW' type='text' name='mat_name' autocomplete='off' value='$res->mat_name' required>";
				echo "<br><br>";
				echo "Brand: ";
				echo "<input minLength='3' maxLength='4' id='inputW' type='text' name='mat_brand' autocomplete='off' value='$res->mat_brand' required>";
				echo "<br><br>";
				echo "Size: ";
				echo "<input minLength='2' maxLength='4' id='inputW' type='text' name='mat_size' autocomplete='off' value='$res->mat_size' required>";
				echo "<br><br>";
				if ($res->mat_categorie == 'deck') {
					echo "Concave: ";
					echo "<input minLength='2' maxLength='4' id='inputW' type='text' name='mat_concave' autocomplete='off' value='$res->mat_concave' required>";
					echo "<br><br>";
				};
				if ($res->mat_categorie == 'truck') {
					echo "Height: ";
					echo "<input minLength='2' maxLength='10' id='inputW' type='text' name='mat_height' autocomplete='off' value='$res->mat_height' required>";
					echo "<br><br>";
				};
				if ($res->mat_categorie == 'wheel') {
					echo "Hardness: ";
					echo "<input minLength='2' maxLength='5' id='inputW' type='text' name='mat_hardness' autocomplete='off' value='$res->mat_hardness' required>";
					echo "<br><br>";
				};
				echo "Preis: ";
				echo "<input minLength='1' maxLength='6' id='inputW' type='text' name='mat_price' autocomplete='off' value='$res->mat_price' required>";
				echo "<br><br>";
				echo "<input style='margin-bottom: 20px;' class='safeD' type='submit' name='submit' value='Abspeichern'><input class='resetD' type='reset' value='Reset'>";
			echo "</form>";
			echo "<hr>";
			echo "<form enctype='multipart/form-data' style='margin-top: 50px; margin-left: 70px;' class='editdrink' method='POST' action='upload.php'>";
				echo "Bild: ";
				echo "<input class='btn' type='file' name='fileToUpload' id='fileToUpload'>";
				if (isset($_GET["error"])){
					echo "<a class='jpg'>Das Bild muss eine PNG-Datei sein.</a>";
				};
				echo "<br><br>";
				echo "<input style='margin-bottom: 20px;' class='safeD' type='submit' name='submit' value='Abspeichern'>";
				echo "<input type='hidden' id='img_id' name='img_id' value='$res->mat_img_id'>";
				echo "<input type='hidden' id='mat_id' name='mat_id' value='$mat_id'>";
			echo "</form>";
			
			if (isset($_POST["submit"])) {
				$name		= $_POST["mat_name"];
				$brand		= $_POST["mat_brand"];
				$size		= $_POST["mat_size"];
				$preis		= $_POST["mat_price"];
				
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

				$sql = "UPDATE material SET mat_name = '$name', mat_brand = '$brand', mat_size = '$size', mat_concave = '$concave', mat_height = '$height', mat_hardness = '$hardness', mat_price = '$preis' WHERE mat_id = $mat_id;";
				$st=$pdo->prepare($sql);
				$st->execute();
				
				header('Location: edit_mat.php?mat_id='.$mat_id.'');
				exit;		
			};
		
		};	 	
		
	};	

	//Footer
	include 'footer_two.php';
	
?>
  </body>
</html>