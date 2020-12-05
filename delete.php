<?php 

	// Verbindung zu DB
	include 'dbconnect.php';

	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	$mat_id		= $_GET["mat_id"];
	
	$sql = "DELETE FROM user_has_mat WHERE mats_mat_id = $mat_id AND user_usr_name = '$user' AND date IS NULL;";
	$st=$pdo->prepare($sql);
	$st->execute();
			
	header('Location: warenkorb.php');
	exit;	
	
?>