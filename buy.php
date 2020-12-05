<?php

	// Verbindung zu DB
	include 'dbconnect.php';
	
	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	
	$sql = "SELECT usr_id FROM user WHERE usr_name = '$user';";
	$st=$pdo->prepare($sql);
	$st->execute();
	
	foreach ($pdo->query($sql) as $row){
		$usr_id = $row['usr_id'];
	};
	
	if (isset($_GET["bye"])) {
		$sql1 = "UPDATE user_has_mat SET date = NOW() WHERE user_usr_name = '$user' AND date IS NULL;";
		$st1=$pdo->prepare($sql1);
		$st1->execute();
		
		unset($_SESSION['bon']);
		unset($_SESSION['bonname']);
	
		header('Location: main.php');
		exit;
	};
	
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="ISO-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
	<link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
    <title>Webapplikation | Oggier Jonas</title>
  </head>
  <body>
	<div class="logoindex"></div>
	<div class="thx">
		<h3>Vielen Dank für Ihre Bestellung!</h3>
		<a href="ausgabe.php?usr_id=<?php echo "$usr_id"; ?>" >Bestellbestätigung (.pdf)</a>
	</div>	
	<div class="two">
		<a href="buy.php?bye=true"><button class="indexbuttonno" type="button">Zurück zur Startseite</button><a>
	</div>
	<?php include 'footer_two.php'; ?>
  </body>
</html>