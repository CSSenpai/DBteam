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
	
	// Session Variabeln
	$user = $_SESSION['usr_name'];
	
	//Header
	include 'header.php';
	
	echo "<a href='main.php' ><button class='back' type='button'>Zurück</button></a>";
	
	//Titel
	echo "<div style='margin-top: 60px;'>";
		echo "<h2 style='float: left; margin-left: 75px;' >USER INFOS HINZUFÜGEN</h2>";
		echo "<h2 style='margin-left: 60%;'>BESTELLHISTORIE</h2>";
		echo "<hr>";
	echo "</div>";
	
	//Formular Persönliche Infos
	echo "<div style='float: left; width: 60%;'>";
		echo "<form enctype='multipart/form-data' style='margin-top: 50px; width: 100%; margin-left: 75px;' class='editdrink' method='POST' action=''>";
		$sql = "SELECT * FROM info INNER JOIN user AS usr ON info.inf_usr_id = usr.usr_id WHERE usr.usr_name = '$user'";
		foreach ($pdo->query($sql) as $row) {
			echo "Vorname: <span style= 'margin-right: 32px;'></span>";
			echo "<input style='width: 50%;' id='inputW' type='text' name='inf_name' autocomplete='off' value='$row[inf_name]' required>";
			echo "<br><br>";
			echo "Nachname: <span style= 'margin-right: 10px;'></span>";
			echo "<input style='width: 50%;' id='inputW' type='text' name='inf_surname' autocomplete='off' value='$row[inf_surname]' required>";
			echo "<br><br>";
			echo "Strasse: <span style= 'margin-right: 58px;'></span>";
			echo "<input style='width: 50%;' id='inputW' type='text' name='inf_street' autocomplete='off' value='$row[inf_street]' required>";
			echo "<br><br>";
			echo "PLZ/Ort: <span style= 'margin-right: 49px;'></span>";
			echo "<input style='width: 120px;' id='inputW' type='text' name='inf_plz' autocomplete='off' value='$row[inf_plz]' required>";
			echo "<input style='margin-left: 20px; width: 26%;' id='inputW' type='text' name='inf_location' autocomplete='off' value='$row[inf_location]' required>";
			echo "<br><br>";
			echo "Land:  <span style= 'margin-right: 87px;'></span>";
			echo "<input style='width: 50%;' id='inputW' type='text' name='inf_country' autocomplete='off' value='$row[inf_country]' required>";
			echo "<br><br>";
			echo "Konto Nr.: <span style= 'margin-right: 29px;'></span>";
			echo "<input style='width: 50%;' id='inputW' type='text' name='inf_konto' autocomplete='off' value='$row[inf_konto]' required>";
			echo "<br><br>";
		};
			echo "<input class='safeD' type='submit' name='submit' value='Abspeichern'>";
		echo "</form>"; 
	echo "</div>";
	
	//Bestellhistorie
	echo "<div class='bestell'>";
		$sql2 = "SELECT * FROM user_has_mat AS uhm INNER JOIN material AS mat ON uhm.mats_mat_id = mat.mat_id WHERE uhm.user_usr_name = '$user' AND uhm.date IS NOT NULL ORDER BY uhm.date DESC";
		$st2=$pdo->prepare($sql2);
		$st2->execute();
		$count = $st2->rowCount();
		$st2=NULL;
		$testtwo = 1;
		if ($count == 0) {
			echo "<a style='color: gray; margin-left: 10px; top: 35%; position: absolute;'>Du hast noch nichts gekauft.</a>";
		}
		foreach ($pdo->query($sql2) as $xow) {
			$date = new DateTime($xow["date"]);						
			if (isset ($test) AND $xow["date"] != $test) {
				echo "&nbsp;<hr>";
				echo "<span class='beste'> Bestellt am ". $date->format('d.m.Y H:i') ."</span><br>";
				echo "<a href='profil.php?again=$xow[date]'><button class='bestebutton'>Erneut bestellen</button></a>";
			}
			if ($testtwo == 1) {
				echo "<span class='beste'> Bestellt am ". $date->format('d.m.Y H:i') ."</span><br>";
				echo "<a href='profil.php?again=$xow[date]'><button class='bestebutton'>Erneut bestellen</button></a>";
			}
			$testtwo = 0;
			echo "$xow[amount]x $xow[mat_name] <br>";
			$test = $xow["date"];
		};
	echo "</div>";
	
	if (isset($_POST["submit"])) {
		$inf_name		= $_POST["inf_name"];
		$inf_surname	= $_POST["inf_surname"];
		$inf_street		= $_POST["inf_street"];
		$inf_plz		= $_POST["inf_plz"];
		$inf_location	= $_POST["inf_location"];
		$inf_country	= $_POST["inf_country"];
		$inf_konto		= $_POST["inf_konto"];
		
		$sql = "UPDATE info SET inf_name = '$inf_name', inf_surname = '$inf_surname', inf_street = '$inf_street', inf_plz = $inf_plz, inf_location = '$inf_location', inf_country = '$inf_country', inf_konto = '$inf_konto'";
		$st=$pdo->prepare($sql);
		$st->execute();
		header('Location: profil.php');
		exit;		
	};	

	if (isset($_GET["again"])) {
		$date = $_GET["again"];
		
		$sql3 = "SELECT * FROM user_has_mat AS uhm INNER JOIN material AS mat ON uhm.mats_mat_id = mat.mat_id WHERE uhm.user_usr_name = '$user' AND uhm.date = '$date'";
		foreach ($pdo->query($sql3) as $iow) {
			$sqlw = "INSERT INTO user_has_mat (user_usr_name, mats_mat_id, amount) VALUES ('$_SESSION[usr_name]', $iow[mat_id], $iow[amount])";
			$stw=$pdo->prepare($sqlw);
			$stw->execute();
		}
		header('Location: warenkorb.php');
		exit;	
	}

	//Footer
	include 'footer_two.php';
	
?>
  </body>
</html>