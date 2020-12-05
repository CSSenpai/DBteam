<?php 
	
	// Verbindung zu DB
	include 'dbconnect.php';
	
	// Überprüfung ob der Benutzer eingeloggt ist
	if (!isset($_SESSION['usr_name'])) {
		header('Location: login.php');
		exit;
	}
	
	if (isset($_GET["mat_id"])){
		$mat_id = $_GET["mat_id"];
		$user = $_SESSION['usr_name'];
	}	
	
	if (isset($_GET["returnn"])){
		
		$sql = "SELECT * FROM user_has_mat WHERE user_usr_name = '$_SESSION[usr_name]' AND mats_mat_id = $mat_id AND date IS NULL";
		$st=$pdo->prepare($sql);
		$st->execute();	
		$checkk = $st->rowCount();
		 
		if ($checkk < 1) {
			$sql = "INSERT INTO user_has_mat (user_usr_name, mats_mat_id, amount) VALUES ('$user', $mat_id, 1)";
			$st=$pdo->prepare($sql);
			$st->execute();
		}elseif ($checkk == 1) {
			 foreach ($pdo->query($sql) as $sow) {
				$amount = $sow["amount"];
				$add = $amount + 1;
				
				$sql = "UPDATE user_has_mat SET amount = $add WHERE user_usr_name = '$user' AND mats_mat_id = $mat_id;";
				$st=$pdo->prepare($sql);
				$st->execute(); 
			 }
		 }else {
			echo "Error";
		 };	
		 
		 header('Location: main.php?add=true');
		 exit;
	}elseif (isset($_GET["mat_id"])) {
		$sql = "SELECT * FROM user_has_mat WHERE user_usr_name = '$_SESSION[usr_name]' AND mats_mat_id = $mat_id";
		$st=$pdo->prepare($sql);
		$st->execute();	
		$checkk = $st->rowCount();
		
		if ($checkk < 1) {
			$sql = "INSERT INTO user_has_mat (user_usr_name, mats_mat_id, amount) VALUES ('$user', $mat_id, 1)";
			$st=$pdo->prepare($sql);
			$st->execute();
		}elseif ($checkk == 1) {
			foreach ($pdo->query($sql) as $sow) {
				$amount = $sow["amount"];
				$add = $amount + 1;
				
				$sql = "UPDATE user_has_mat SET amount = $add WHERE user_usr_name = '$user' AND mats_mat_id = $mat_id;";
				$st=$pdo->prepare($sql);
				$st->execute(); 
			 }
		}else {
			echo "Error";
		};	
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
	<!-- Header -->
	<?php include 'header.php';?>
	<!-- Warenkorb -->
	<?php echo "<h1>WARENKORB</h1>"; ?>
	<table>
	  <tr><th>PRODUKT</th><th>ANZAHL</th><th>PREIS</th><th>GESAMT</th><th style="width: 100px;"></th></tr>
	  <tr>
<?php

	  $sql = "SELECT * FROM material INNER JOIN user_has_mat ON user_has_mat.mats_mat_id = material.mat_id WHERE user_usr_name = '$_SESSION[usr_name]' AND date IS NULL";
	  $st=$pdo->prepare($sql);
	  $st->execute();	
	  $check=$st->rowCount();
	  $exkl = 0;
	  foreach ($pdo->query($sql) as $row) {
		  $gesamt = $row["mat_price"] * $row["amount"];
		  $gesamt = number_format($gesamt, 2, '.', ' ');
		  echo "<tr><td>$row[mat_name]</td>";
		  echo "<td><nobr><a href='update_amount.php?id=$row[mat_id]&theamount=low' ><button class='wbutton' type='button'>–</button></a><form action='update_amount.php'><input class='abutton' type='text' name='theamount' value='$row[amount]'><input type='hidden' id='id' name='id' value='$row[mat_id]'></form><a href='update_amount.php?id=$row[mat_id]&theamount=add' ><button href='update_amount.php?id=$row[mat_id]&theamount=add' class='wbutton' type='button'>+</button></a></nobr></td>";
		  echo "<td>CHF $row[mat_price].–</td><td>CHF $gesamt.–</td><td><a href='delete.php?mat_id=$row[mat_id]'><img style='margin-bottom: 5px;' class='reset' title='Delete' src='bilder/test.png' alt='delete'></a></td></tr>";
		  $exkl = $exkl + $gesamt;
		  $exkl = number_format($exkl, 2, '.', ' ');
	  }
	  echo "</tr>";
	  
	  $mwst = $exkl / 100 * 7.7;
	  $mwst = round(($mwst + 0.000001) * 20) / 20;
	  $mwst = number_format($mwst, 2, '.', ' ');
	  
	  $inkl = $mwst + $exkl;
	  $inkl = round(($inkl + 0.000001) * 20) / 20;
	  $inkl = number_format($inkl, 2, '.', ' ');
	  
	  if (isset($_SESSION["bon"])) {
		$rabatt = $inkl * $_SESSION["bon"];
		$rabatt = round(($rabatt + 0.000001) * 20) / 20;
		$rabatt = number_format($rabatt, 2, '.', ' ');

		$inktot = $inkl - $rabatt;
		$inktot = round(($inktot + 0.000001) * 20) / 20;
		$inktot = number_format($inktot, 2, '.', ' ');
	  }else {
		$inktot = $inkl;
	  }
	  
	  echo "<tr style='padding-top: 60px;' class='special'><td colspan='3'>Zwischensumme (exkl. MwSt.)</td><td>CHF $exkl.–</td><td></td></tr>";
	  echo "<tr class='special'><td colspan='3'>Zwischensumme (inkl. MwSt.)</td><td>CHF $inkl.–</td><td></td></tr>";
	  echo "<tr class='special'><td colspan='3'>MwSt. (7.7%)</td><td>CHF $mwst.–</td><td></td></tr>";
	  if (isset($_SESSION["bon"])) {
		echo "<tr class='special'><td colspan='3'>Rabatt</td><td>CHF $rabatt.–</td><td></td></tr>";
	  }
	  echo "<tr class='specialtwo'><td colspan='3'><b>Gesamtsumme</b></td><td><b>CHF $inktot.–</b></td><td></td></tr>";
	  if($check > 0 ){
		  
?>
		<tr><td style="height: 100px;" colspan='4'>
			<form action="" method="post">
				<label for="inputW">Gutscheincode:</label><br>
				<input id='inputW' type="text"  autocomplete="off" name="bon" value="<?php if(isset($_SESSION["bonname"])) { echo "$_SESSION[bonname]"; }; ?>" required><br>
				<input style="display: none;" type="submit" name="bonsub" value="Submit">
			</form>
<?php
		if(isset($_POST["bonsub"]) AND $_POST["bonsub"] != '') {
			$bon = $_POST["bon"];
			$sqlx = "SELECT * FROM coupon WHERE `cou_name` LIKE '%".$bon."%'";
			$stx=$pdo->prepare($sqlx);
			$stx->execute();	
			$check=$stx->rowCount();
			foreach ($pdo->query($sqlx) as $xow) {
				$_SESSION["bon"] = $xow["cou_percent"];
				$_SESSION["bonname"] = $xow["cou_name"];
				
			}
			echo "<meta http-equiv='refresh' content='0; URL=warenkorb.php'>";
		}
?>
		</td><td><a href="buy.php" ><button class="buynow" type="button">Jetzt Kaufen</button></a></td></tr>
<?php
	 }
?>
	</table>
	<!-- Footer -->
	<?php include 'footer_two.php'; ?>
  </body>
</html>