<?php 

	// Verbindung zu DB
	include 'dbconnect.php';
	include 'select.php';
	
	$mat_id = $_GET["mat_id"];

	//Erfassung Produktbewertung
	if (isset($_POST["note"])) {
		if (isset($_SESSION["usr_name"])) {
			$benutzer 	= $_SESSION['usr_name'];
			$message 	= $_POST["note"];
			$rating 	= $_POST["emotion"];
			$sql = "INSERT INTO notes (note_usr_name, note_mat_id, note_message, note_create_date, note_rating) VALUES ('$benutzer', '$mat_id', '$message', NOW(), '$rating')";
			$st=$pdo->prepare($sql);
			$st->execute();
		}else {
			header('Location: login.php?mat_id=' . $mat_id . '');
			exit;
		};
	};
	
	$sql = "SELECT * FROM material WHERE mat_id = $mat_id";
	foreach ($pdo->query($sql) as $row) {
	
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
	<!-- Warenkorb -->
	<a href="main.php" ><button class="back" type="button">Zurück</button></a>
	<?php
	//Kauf-Vorschläge
	echo "<div style='float: right; margin-right: 174px; margin-top: 78px;'>";
		echo "<h3>Oft zusammen bestellt:</h3>";
		$srl = "SELECT * FROM material WHERE mat_categorie != 'deck' ORDER BY RAND() LIMIT 2";
		foreach ($pdo->query($srl) as $rrw) {
			echo "<div class='showme'>";
				echo "<div class='bilderget'>";
					echo "<img class='pictures' src='bilder/material/$rrw[mat_img_id].PNG' alt='Material'>";
				echo "</div>";
				echo "<div class='gettitle'>";
					echo "<a href='overview.php?mat_id=$rrw[mat_id]' class='alcname'>$rrw[mat_name]</a><hr style='margin-bottom: 3px;'/><a class='alcstock'>Noch $rrw[mat_stock] Stück verfügbar</a>";
					echo"<br><a class='alcprice'>CHF $rrw[mat_price] .–</a>";
					echo "<a ";
					if (isset($_SESSION['usr_name'])) {
						echo "href='warenkorb.php?mat_id=$rrw[mat_id]&returnn=true'";
					}else {
						echo "href='login.php'";
					};
					echo "><button class='safe' type='button'><img class='add' src='bilder/add.png' alt='Add'></button></a>";
				echo "</div>";
			echo "</div>";
		}
	echo "</div>"; 
?>	
	<div style="margin-top: 30px;">
<?php
		// 	Bearbeitung ist nur als Admin möglich
		if (isset ($_SESSION['usr_auth']) AND $_SESSION['usr_auth'] == 1) {
			echo "<a onclick=edit($_GET[mat_id]) class='edit'>Bearbeiten</a>";
			echo "<a onclick=removes($_GET[mat_id]) class='delete'>Löschen</a>";
		};
?>
<script>
		function removes(mat_id){	
			var ans = confirm("Willst du diesen Eintrag wirklich löschen?");
			if(ans){//if true delete row
				window.location.assign("delete_mat.php?mat_id="+mat_id);
			}
			else{//if false 
				// do nothing
			}
		};
		function edit(mat_id){	
			window.location.assign("edit_mat.php?mat_id="+mat_id);
		};
</script>
		<div class="showoff">
			<?php echo "<img class='pictures' src='bilder/material/$row[mat_img_id].PNG' alt='Bild'>"; ?>
		</div>
		<div class="showofftext">
<?php
			echo "<h2>$row[mat_name]<span class='span'><nobr></nobr></span></h2>"; 
			echo "<span class='span2'>$row[mat_rating] von 5 Sternen</span>";
			if ($row["mat_stock"] < 30) {
				echo "<span style='color: red;' class='span3'>Noch $row[mat_stock] auf Lager</span>";
			} else {
				echo "<span style='color: green;' class='span3'>Verfügbar</span>";
			};
			echo "<br><br><a class='span4'>Zusatzinformation</a>";
			echo "<br><br><a style='margin-right: 101px;' class='span2'>Brand</a><a style='color:black' class='span2'>$row[mat_brand]</a>";
			echo "<br><a style='margin-right: 113px;' class='span2'>Size</a><a style='color:black' class='span2'>$row[mat_size]</a>";
			if ($row["mat_categorie"] == 'deck') {
				echo "<br><a style='margin-right: 81px;' class='span2'>Concave</a><a style='color:black' class='span2'>$row[mat_concave]</a>";
			}
			if ($row["mat_categorie"] == 'truck') {
				echo "<br><a style='margin-right: 98px;' class='span2'>Height</a><a style='color:black' class='span2'>$row[mat_height]</a>";
			}
			if ($row["mat_categorie"] == 'wheel') {
				echo "<br><a style='margin-right: 76px;' class='span2'>Hardness</a><a style='color:black' class='span2'>$row[mat_hardness]</a>";
			}
			echo "<div class='bottomdiv'>";
				echo "<a class='price'>CHF $row[mat_price] .–</a>";
				echo "<br><br><i><a class='mwst'>inkl. MwSt. zzgl. Versandkosten</a></i>";
				echo "<a ";
					if (isset($_SESSION['usr_name'])) {
						echo "href='warenkorb.php?mat_id=$mat_id'";
					} else {
						echo "href='login.php?location=ware'";
					};
				echo "><button class='wareoff' type='button'>
				<img style='margin-top: -2px;' height='25px;' src='bilder/ware.png' alt='Ware'>
				</button></a>";
			echo "</div>";
?>
		</div>
		<div class="commentdiv">
			<div class="commentbox">
			<form method="POST" action="">
				<input class="commentinput" type="text" name="note" placeholder="Teile uns deine Erfahrungen mit diesem Produkt mit..." autocomplete="off" required><br>

				<input style="visibility: collapse;" type="radio" name="emotion" id="sad" value='top' required />
				<label for="sad"><img class="checked" src="bilder/top.png"/></label>

				<input style="visibility: collapse;" type="radio" name="emotion" id="happy" value='down' required />
				<label for="happy"><img class="checked" src="bilder/down.png"/></label>

				<input class="bewerte" type="submit" value="Bewerten">
			</form>

			<br><br><br><br><h3>Kundenerfahrungen:</h3>
<?php
			$sql2 = "SELECT * FROM notes INNER JOIN material ON notes.note_mat_id = material.mat_id WHERE note_mat_id = $mat_id";
			$count = 0;
			foreach ($pdo->query($sql2) as $bow) {
				$count = $count + 1;
				echo "<div class='commentboxtwo'>";
					echo "<a class='name'>$bow[note_usr_name]</a>";
					echo "<img style='height: 25px; margin-left: 10px;' src='bilder/$bow[note_rating].png'/>";
					$date = new DateTime($bow["note_create_date"]);
					echo "<a class='date'>".$date->format('d.m.Y') ."</a>";
					echo "<br><br><a class='message'>$bow[note_message]</a>";
				echo "</div>";
			};
			if ($count == 0) {
				echo "<i><h4>Sei der Erste, der dieses Produkt bewertet!</h4></i>";
			};
?>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php include 'footer_two.php'; ?>
  </body>
</html>
<?php 
	};
?>