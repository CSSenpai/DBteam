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
    <title>Webapplikation | Oggier Jonas</title>
  </head>
  <body>
	<!-- Header -->
	<?php include 'header.php';?>
	<!-- Formular -->
	<form class="formular" action="" method="POST">
	  Benutzername:<br>
	  <input id="inputL" type="text" name="benutzer" autocomplete="off" required>
	  <br><br>
	  E-Mail:<br>
	  <input id="inputL" type="email" name="email" autocomplete="off" required>
	  <br><br>
	  Passwort:<br>
	  <input id="inputL" type="password" name="password" autocomplete="off" required>
	  <br><br>
	  Passwort bestätigen:<br>
	  <input id="inputL" type="password" name="passwordtwo" autocomplete="off" required>
	  <br><br>
	  <input class="login" type="submit" name="submit" value="Anlegen"> <a href="login.php" class="regist">Login</a>
	</form> 
<?php

	if (isset($_POST["submit"])) {
		$benutzer		= $_POST["benutzer"];
		$email			= $_POST["email"];
		$password		= $_POST["password"];
		$passwordtwo	= $_POST["passwordtwo"];
		
		// Überprüfung ob das Password zweimal gleich geschrieben wurde
		if ($password === $passwordtwo) {
			$sql = "INSERT INTO user (usr_name, usr_mail, usr_password, aut_id) VALUES ('$benutzer', '$email', '".md5($password)."', 0)";
			//echo "$sql";
			$st=$pdo->prepare($sql);
			$st->execute();
			$id = $pdo->lastInsertId();
			if ($st) {
				$sql2 = "INSERT INTO info (inf_usr_id) VALUES ($id)";
				$st2=$pdo->prepare($sql2);
				$st2->execute();
			
				header('Location: login.php');
				exit;
			} else {
				echo "<br><a class='reg-err'>Benutzername oder E-Mail ist bereits vergeben.</a>";
			};
		} else {
			echo "<br><a class='reg-err'>Das eingegebene Passwort stimmt nicht überrein.</a>";
		};
	};
	
	include 'footer_two.php';
	
?>
  </body>
</html>