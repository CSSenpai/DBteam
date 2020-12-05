<?php

	// Verbindung zu DB
	include 'dbconnect.php';
	
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="ISO-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
	<link href="https://fonts.googleapis.com/css?family=Arvo&display=swap" rel="stylesheet">
    <title>Webapplikation | Jonas und Nicolas</title>
  </head>
  <body>
	<div class="logoindex"></div>
	<div class="indexdiv">
		<a href="main.php"><button class="indexbutton" type="button">Ich bin Rad (zur Webseite)</button></a>
	</div>	
	<div class="two">
		<button class="indexbuttonno" type="button" onclick="alert('Du musst Rad sein um auf diese Webseite zugreifen zu können.')">Ich bin noch nicht Rad</button>
	</div>
	<?php include 'footer_two.php'; ?>
  </body>
</html>