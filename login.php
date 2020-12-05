<?php include 'dbconnect.php'; ?>
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
	<!-- Header -->
	<?php include 'header.php';?>
	<!-- Formular -->
	<form class="formular" method="POST" action="">
	  Login:<br>
	  <input id="inputL" type="text" name="benutzer" autocomplete="off" required>
	  <br><br>
	  Passwort:<br>
	  <input id="inputL" type="password" name="password" autocomplete="off" required>
	  <br><br>
	  <input class="login" type="submit" name="submit" value="Login"> <a href="registrieren.php" class="regist">Registieren</a>
	</form> 
<?php

	if (isset($_POST["submit"])) {
		$benutzer		= $_POST["benutzer"];
		$password		= $_POST["password"];
		
		$sql = "SELECT * FROM user WHERE usr_name = '$benutzer' AND usr_password = '".md5($password)."'";
		$st=$pdo->prepare($sql);
		$st->execute();
		$check=$st->rowCount();
		// Überprüfung ob die Login-Daten korrekt sind
		if($check < 1 ){
			echo "<br><a class='reg-err'><i>Passwort oder Benutzername sind falsch.</i></a>";
		}elseif ($check = 1) {
			foreach ($pdo->query($sql) as $row) {
				//User Berechtigung wird als Session Variabel gespeichert
				$_SESSION['usr_auth'] = "$row[aut_id]";
			};
			$_SESSION['usr_name'] = "$benutzer";
			if (isset($_GET["location"])) {
				header('Location: warenkorb.php');
			}elseif (isset($_GET["mat_id"])){
				$mat_id = $_GET["mat_id"];
				header('Location: overview.php?mat_id=' . $mat_id . '');
			}else {
				header('Location: main.php');
			};
		};
	};
	include 'footer_two.php';
	
?>
  </body>
</html>