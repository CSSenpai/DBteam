<?php

	// Verbindung zu DB
	require 'dbconnect.php';
	
	// Verknüpfung zum FPDF Ordner
	require('fpdf181/tfpdf/tfpdf.php');
	
	// Session-Variabeln
	$user 		= $_SESSION['usr_name'];	
	
	// Random Nummer zur Veranschaulichung
	$random = rand(1000,5000); 
	
	// nötig wegen FPDF
	$eins = 1;
	
	// Für die fortlaufenden Positionen
	$pos = 1;
	
	// Für das zusammenrechen der Preise
	$exkl = 0;

	if (!isset($_GET['usr_id'])) {
		header('Location: main.php');
	}
	
	//Datenbank Abfragen
	$usr_id = $_GET['usr_id'];
	$sql = "SELECT * FROM user AS u INNER JOIN user_has_mat AS h ON h.user_usr_name = u.usr_name INNER JOIN material as d ON d.mat_id = h.mats_mat_id WHERE usr_id = '$usr_id'"; 
	$st=$pdo->prepare($sql);
	$st->execute();	
	$count = $st->rowCount();
	
	if ($count > 0) { 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		//Abmessungen
		$erstespalte = 45; //
		$zellenhöheklein = 4; // mm
		$zellenhöhegross = 10; // mm
		
		class PDF extends tFPDF
		{
			//Kopfzeile
			function Header()
			{
				$this->Image('logo.png',165,8,30);
				$this->SetFont('Arial','',11);
				$this->Cell(65,7,date("d.m.Y",time()),0);
				$this->Cell(25,7,'SKATE.CH - Online Shop',0,1);
				$this->Cell(180,0,'','B',1);
				$this->Cell(180,5,'',0,1);
			}
			
			//Fusszeile
			function Footer()
			{
				$this->SetY(-15);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,7,"* Alle Preise inkl. gesetzl. Mehrwertsteuer zzgl. Versandkosten | Webagentur: Ontius GmbH",0,0,'L');
			}
		}
		
		//**************************Neue Seite******************************
		$pdf = new PDF('P','mm','A4', array($eins.' '.$eins,  $eins));
		$pdf->SetLeftMargin(15);
		$pdf->SetRightMargin(15);
		$pdf->AddFont('arial','','myarial.ttf','true');
		$pdf->AddFont('Arial','B','myArial-Bold.ttf','true');
		$pdf->AddFont('Arial','I','myArial-Italic.ttf','true');
		$pdf->AddFont('Arial Narrow','I','myArialNarrow-Italic.ttf','true');
		$pdf->AddFont('Arvo','B','Arvo-Bold.ttf','true');
		$pdf->AddPage();
		$pdf->SetFont('Arvo','B',20);
		$pdf->Cell(180,60,'Bestellbestätigung Nr. ' . $random . '',0,1,'C');
		$pdf->SetFont('Arvo','B',11);
		$pdf->Cell(20,5,'POS.',0,0);
		$pdf->Cell(60,5,'PRODUKT',0,0);
		$pdf->Cell(30,5,'ANZAHL',0,0);
		$pdf->Cell(35,5,'EINZEL (CHF)',0,0);
		$pdf->Cell(80,5,'GESAMMT (CHF)',0,1);
		$pdf->Cell(180,0,'','B',1);
		foreach ($pdo->query($sql) as $row){
			$mat_name = $row['mat_name'];
			$user = $row['usr_name'];
			$amount = $row['amount'];
			$mat_price = $row['mat_price'];
			$gesamt = $row["mat_price"] * $row["amount"];
			$gesamt = number_format($gesamt, 2, '.', ' ');
			
			$pdf->Cell(180,3,'',0,1);
			$pdf->SetFont('Arial','',11);
			$pdf->Cell(20,5,$pos,0,0);
			$pdf->Cell(67,5,$mat_name,0,0);
			$pdf->Cell(23,5,$amount,0,0);
			$pdf->Cell(35,5,$mat_price.' CHF',0,0);
			$pdf->Cell(80,5,$gesamt.' CHF',0,0);
			$pdf->Cell(180,3,'',0,1);
			$pdf->Cell(180,3,'',0,1);
			
			$exkl = $exkl + $gesamt;
			$exkl = number_format($exkl, 2, '.', ' ');
			$pos = $pos + 1;
		}
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,0,'','B',1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(83,5,'',0,0);
		$pdf->Cell(62,5,'Zwischensumme (exkl. MwSt.)',0,0);
		$pdf->Cell(80,5,$exkl.' CHF',0,0);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(83,5,'',0,0);
		$pdf->Cell(62,5,'MwSt. (7.7%)',0,0);
		
		$mwst = $exkl / 100 * 7.7;
		$mwst = round(($mwst + 0.000001) * 20) / 20;
		$mwst = number_format($mwst, 2, '.', ' ');
		 
		$inkl = $mwst + $exkl;
		$inkl = round(($inkl + 0.000001) * 20) / 20;
		$inkl = number_format($inkl, 2, '.', ' ');
		  
		$pdf->Cell(80,5,$mwst.' CHF',0,0);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(83,5,'',0,0);
		$pdf->Cell(62,5,'Rabatt',0,0);
		
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
		  
		$pdf->Cell(80,5,$rabatt.' CHF',0,0);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(83,5,'',0,0);
		$pdf->Cell(97,0,'','B',1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(83,5,'',0,0);
		$pdf->SetFont('Arvo','B',11);
		$pdf->Cell(62,5,'Gesamtsumme (inkl. MwSt.)',0,0);
		$pdf->Cell(80,5,$inktot.' CHF',0,0);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,0,'','B',1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell($erstespalte,$zellenhöheklein,'Sie haben noch Fragen? Sie erreichen uns täglich von 08:00 bis 17:00 unter (+49) 1234/98 76 54');
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell($erstespalte,$zellenhöheklein,'oder per E-Mail info@skate.ch.');
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell($erstespalte,$zellenhöheklein,'Vielen Dank für Ihre Bestellung!');
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->SetFont('Arvo','B',11);
		$pdf->Cell($erstespalte,$zellenhöheklein,'Mit Freundlichen Grüssen');
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell($erstespalte,$zellenhöheklein,'Ihr SKATE.ch Team');
		$pdf->Cell(180,3,'',0,1);
		$pdf->Cell(180,3,'',0,1);
		
		$sql1 = "UPDATE user_has_mat SET date = NOW() WHERE user_usr_name = '$user' AND date IS NULL;";
		$st=$pdo->prepare($sql1);
		$st->execute();
		
		unset($_SESSION['bon']);
		unset($_SESSION['bonname']);
			
		//Ende - Ausgabe
		ob_end_clean();
		$pdf->Output('Quittung - '.date("d.m.Y",time()).'.pdf', 'D');
	}else {
		echo "Sie haben die Bestellbestätigung bereits heruntergeladen. (<a href='buy.php'>Zurück</a>)";
	}

?>