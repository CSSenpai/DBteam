<?php
include 'dbconnect.php';
include 'select.php';
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
	<!-- Header -->
	<?php include 'header.php';?>
	<!-- Kategorie -->
	<div class="kategorie">
		<a style="text-decoration: none;" href="main.php?type=decks"><div class="kate1">
			<div class="bilder">
				<img class="kbild1" src="bilder/deck.jpg" alt="Decks">
			</div>
			<div class="ktitle">
				DECKS
			</div>
		</div></a>
		<a style="text-decoration: none;" href="main.php?type=trucks"><div class="kates">
			<div class="bilder">
				<img class="kbild2" src="bilder/trucks.jpg" alt="Trucks">
			</div>
			<div class="ktitle">
				TRUCKS
			</div></a>
		</div>
		<a style="text-decoration: none;" href="main.php?type=wheels"><div class="kates">
			<div class="bilder">
				<img class="kbild3" src="bilder/wheels.jpg" alt="Wheels">
			</div>
			<div class="ktitle">
				WHEELS
			</div></a>
		</div>
	</div>
	<!-- Titel -->
<?php
	if ($type == "decks") {
		echo "<h1>DECKS</h1>";
		// Bearbeitung nur als Admin möglich
		if (isset ($_SESSION['usr_auth']) AND $_SESSION['usr_auth'] == 1) {
			echo "<a href='add_mat.php' class='addD'>Neues Material</a>";
		};
	} elseif ($type == "trucks") {
		echo "<h1>TRUCKS</h1>";
		// Bearbeitung nur als Admin möglich
		if (isset ($_SESSION['usr_auth']) AND $_SESSION['usr_auth'] == 1) {
			echo "<a href='add_mat.php' class='addD'>Neuer Material</a>";
		};
	} elseif ($type == "wheels") {
		echo "<h1>WHEELS</h1>";
		// Bearbeitung nur als Admin möglich
		if (isset ($_SESSION['usr_auth']) AND $_SESSION['usr_auth'] == 1) {
			echo "<a href='add_mat.php' class='addD'>Neuer Material</a>";
		};
	} elseif ($type == "none") {
		echo "<h1>MATERIAL</h1>";
		// Bearbeitung nur als Admin möglich
		if (isset ($_SESSION['usr_auth']) AND $_SESSION['usr_auth'] == 1) {
			echo "<a href='add_mat.php' class='addD'>Neuer Material</a>";
		};
	};
?>
	<div class="filter"></div>
	<div class="products">
<?php
		$count = 0;
		foreach ($pdo->query($sql) as $row) {
			$count = $count + 1;	
?>
			<div class="showme">
				<div class="bilderget">
					<?php echo "<img class='pictures' src='bilder/material/$row[mat_img_id].PNG' alt='Material'>"; ?>
				</div>
				<div class="gettitle">
<?php
					echo "<a href='overview.php?mat_id=$row[mat_id]' class='alcname'>$row[mat_name]</a><hr style='margin-bottom: 3px;'/><a class='alcstock'>Noch $row[mat_stock] Stück verfügbar</a>";
					echo"<br><a class='alcprice'>CHF $row[mat_price] .–</a>";
					echo "<a ";
					if (isset($_SESSION['usr_name'])) {
						echo "href='warenkorb.php?mat_id=$row[mat_id]&returnn=true'";
					}else {
						echo "href='login.php'";
					};
					echo "><button class='safe' type='button'>
						<img class='add' src='bilder/add.png' alt='Add'>
					</button></a>";
?>
				</div>
			</div>
<?php
		};
		$sqq = "SELECT mat_id FROM material ORDER BY RAND() LIMIT 1";
		foreach ($pdo->query($sqq) as $qow) {
			$rand = $qow["mat_id"];
		};
		if($count > 0){
			echo "<div style='float: left; width: 300px;'>";	
				echo "<a href='overview.php?mat_id=$rand'><button class='zufi'>Zufallsprodukt</button></a>";
				echo "<div class='feedback'>";
					if (isset($_GET["feedback"])) {
						echo "<img style='margin-left: 56px; margin-top: 10px;' src='bilder/check.png' alt='check' width='170' height='auto'><br>";
						echo "<a class='thx'>Danke für dein Feedback!</a>";
					}else {
						echo "<form action='feedback.php' method='POST'>";
							echo "<textarea class='feedb' id='feedb' name='feedb' placeholder='Gib uns dein Feedback!' required></textarea><br>";
							echo "<input class='feedbutton' type='submit' value='Senden'>";
						echo "</form>"; 
					}
				echo "</div>";
			echo "</div>";	
		}
		if($count < 1){
			echo "<a class='error'><i>Kein Ergebnis gefunden</i></a>";
		}
?>
	</div>
	<!-- Footer -->
	<?php include 'footer.php';?>
  </body>

<?php if (isset($_GET["add"])) {?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
	 $(".popup").hide(0).delay(500).fadeIn(1000).fadeOut(3000)

	function KeyCode(ev){
		if(ev){TastenWert = ev.which}else{TastenWert = window.event.keyCode}

	if (TastenWert == 13)
	{
	document.form.submit();
	}

	}
	document.onkeypress = KeyCode; 
</script>
<?php } ?>
</html>