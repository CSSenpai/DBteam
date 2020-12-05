<html>
<head>
<title>Lebensläufe</title>
<meta charset="utf-8">
</head>
<body>
	<h1>Lebenlauf erstellen</h1>
	<form action="dbsend.php" method="post">
		<p>Vor- und Nachname: <input type="text" name="vorundnachname"></p>
		<p>Geburtsdatum: <input type="text" name="geburtsdatum"></p>
		<p>Nationalität: <input type="text" name="nationalitaet"></p>	
		<p>Funktion: <input type="text" name="funktion"></p>
		<p>Sprache: <input type="text" name="sprache"></p>
		<p>Kenntnis: <input type="text" name="kenntnis"></p>
		<p><input type="submit"></p>
	</form>	

	<!--<form action="ausgabe.php" method="post" enctype="multipart/form-data">
		<label>Foto auswählen
			<input name="foto" type="file">
		</label>	
		<p><input type="submit"></p>
		</form>-->
</body>
</html>