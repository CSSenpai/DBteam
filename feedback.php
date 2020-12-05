<?php

	$feedback = $_POST["feedb"];
	
	$to = "info@skate.ch";
	$subject = "Neues Feedback";
	$txt = "$feedback";
	$headers = "From: skate@shop.com" . "\r\n";

	mail($to,$subject,$txt,$headers);
	
	header('Location: main.php?feedback=true');
	exit;

?>