<?php
require('../tfpdf/tfpdf.php');
include('dbdata.php');
// move_uploaded_file($_FILES['foto']['tmp_name'], "image.jpg");

//Daten
// $vorundnachname = $zeile['vorundnachname'];
// $funktion = "Mediamatiker EFZ (in Ausbildung)";
// $geburtsdatum = $zeile['geburtsdatum'];
$taetigseit = "01. August 2015";
$aufgabenbereich = "IT Support, Administration, Web- und Printdesign, Marketing";
// $nationalitaet = $zeile['nation'];
$qualifikation = array('Mediamatiker EFZ in Ausbildung');
// $sprachen = array(array('Deutsch', 'Muttersprache'),array('Englisch', 'Mündlich und schriftlich fliessend'),array('Französisch', 'Mündlich und schriftlich gute Kenntnisse'),array('Spanisch', 'Grundkenntnisse'),array('Schwedisch', 'Grundkenntnisse'));
$informatik = array(array('Textverarbeitung', 'MS Office'),array('Grafik-Design', 'InDesign, Illustrator, Photoshop, Premiere Pro'),array('Softwareentwicklung', 'HTML/CSS'),array('Webdesign', 'Joomla! 3.x, Wordpress'));
$weiterbildungen = array(array('2017', 'First Certificate in Englisch (FCE)', 'Berufsfachschule Oberwallis', 'Visp', 'Schweiz'),array('Zeitraum', 'Bezeichnung der Weiterbildungen', 'Ausbildungsstätte', 'Ort', 'Land'));
$ausbildungen = array(array('2015 - heute', 'Mediamatiker EFZ in Ausbildung', 'pixon engineering AG', 'Visp', 'Schweiz'),array('Zeitraum', 'Bezeichnung der Ausbildung', 'Ausbildungsstätte', 'Ort', 'Land'));
$berufserfahrung = array(array('2015 - heute', 'pixon engineering AG', 'Visp', 'Schweiz', 'Mediamatiker EFZ in Ausbildung', 'Engineering, Design',),array('Zeitraum', 'Firmenname', 'Ort', 'Land', 'Position', 'Tätigkeiten'));
$projekte = array(array('Firmenname', 'Ort', 'Land', 'Position', 'Projektname', 'Zeitraum', array('Tätigkeiten', 'Tätigkeiten 2', 'Tätigkeiten 3')),array('Corden Pharma Switzerland LLC', 'Liestal', 'Schweiz', 'Projektingenieur', 'Planung Purification', '2017', array('Marketing', 'Design')),array('pixon engineering AG', 'Visp', 'Schweiz', 'Lernender Mediamatiker', 'IPA: Neugestaltung Flyer', '2018', array('Konzept', 'Design', 'Coden')));

//Ende Daten

//Abmessungen
$erstespalte = 45; //
$zellenhöheklein = 7; // mm
$zellenhöhegross = 10; // mm
//Ende Abmessungen

class PDF extends tFPDF
{
	

//Kopfzeile
function Header()
{
	$this->Image('Pixon_Logo_Webseite_cmyk.png',165,8,30);
	$this->SetFont('Arial','',11);
	$this->Cell(45,7,$this->mitarbeiter,0);
	$this->Cell(45,7,$this->funktion,0,1);
	$this->Cell(180,0,'','B',1);
	$this->Cell(180,5,'',0,1);
}

function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,7,'Seite '.$this->PageNo(),0,0,'L');
	$this->Cell(0,7,"Aktualisiert am ".date("d.m.Y",time()),0,0,'R');
}
}

//**************************Neue Seite******************************
$pdf = new PDF('P','mm','A4', array($vorundnachname, $funktion));
$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(15);
$pdf->AddFont('Arial','','arial.ttf','true');
$pdf->AddFont('Arial','B','Arial-Bold.ttf','true');
$pdf->AddFont('Arial','I','Arial Italic.ttf','true');
$pdf->AddPage();
$pdf->SetFont('Arial','',20);
$pdf->Cell(180,60,'Lebenslauf',0,1,'C');
// $pdf->Image('image.JPG',150,23,'',60);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,'Persönliche Daten',0,1);
$pdf->Cell(180,0,'','B',1);
$pdf->SetFont('Arial','',11);
$pdf->Cell($erstespalte,$zellenhöhegross,'Vor- und Nachname');
$pdf->Cell(100,$zellenhöhegross,$vorundnachname,0,1);
$pdf->Cell($erstespalte,$zellenhöhegross,'Geburtsdatum');
$pdf->Cell(100,$zellenhöhegross,$geburtsdatum,0,1);
$pdf->Cell($erstespalte,$zellenhöhegross,'Nationalität');
$pdf->Cell(100,$zellenhöhegross,$nationalitaet,0,1);

$pdf->Cell(80,$zellenhöheklein,'',0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,'Funktion bei pixon engineering AG',0,1);
$pdf->Cell(180,0,'','B',1);
$pdf->SetFont('Arial','',11);
$pdf->Cell($erstespalte,$zellenhöhegross,'Position');
$pdf->Cell(140,$zellenhöhegross,$funktion,0,1);
$pdf->Cell($erstespalte,$zellenhöhegross,'Für pixon tätig seit');
$pdf->Cell(140,$zellenhöhegross,$taetigseit,0,1);
$pdf->Cell($erstespalte,$zellenhöhegross,'Aufgabenbereich');
$pdf->MultiCell(140,$zellenhöhegross,$aufgabenbereich,0,1);

$pdf->Cell(80,$zellenhöheklein,'',0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,'Kompetenzen',0,1);
$pdf->Cell(180,0,'','B',1);
$pdf->Cell(180,3,'',0,1);
$pdf->SetFont('Arial','',11);

//Qualifikation
$pdf->Cell($erstespalte,$zellenhöheklein,'Qualifikation/Titel');
for ($i = count ($qualifikation)-1; $i >= 0; $i--)
{
	$pdf->Cell(140,$zellenhöheklein,$qualifikation[$i],0,1);
	if($i == 0)break;
	$pdf->Cell($erstespalte,$zellenhöhegross,'');
}

//Sprachen
$pdf->Cell($erstespalte,5,'',0,1);
$pdf->Cell($erstespalte,$zellenhöheklein,'Sprachen');
for ($i = 0; $i < count($sprachen); $i++)
{	
	$sprache = $sprachen;
	for ($j = 0; $j < count($sprache); $j++)
	{
		$pdf->Cell($erstespalte,$zellenhöheklein,$sprache);
		$pdf->Cell($erstespalte,$zellenhöheklein,$kenntnis);
	}	
	 
		$pdf->Cell($erstespalte,$zellenhöheklein,'',0,1);
		if($i == count($sprachen)-1) break;
		$pdf->Cell($erstespalte,$zellenhöheklein,'');
		
}

//Optionaler Seitenumbruch 
$pdf->SetAutoPageBreak(false);
$page_height = 286.93; // mm (portrait letter)
$bottom_margin = 7; // mm
    $block=1*count ($informatik)*$zellenhöheklein;
    $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
      if ($block > $space_left) {
        $pdf->AddPage(); // page break
      }
  
  
  
//Informatik
$pdf->Cell($erstespalte,5,'',0,1);
$pdf->Cell($erstespalte,$zellenhöheklein,'Informatik');

for ($i = 0; $i < count($informatik); $i++)
{	
	$info = $informatik[$i];
	for ($j = 0; $j < count($info); $j++)
	{
		$pdf->Cell($erstespalte,$zellenhöheklein,$info[$j]);
	} 
		$pdf->Cell($erstespalte,$zellenhöheklein,'',0,1);
		if($i == count($informatik)-1) break;
		$pdf->Cell($erstespalte,$zellenhöheklein,'');
}


//**************************Neue Seite erzwingen******************************


$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,'Weiterbildungen',0,1);
$pdf->Cell(180,0,'','B',1,1);
$pdf->Cell(180,3,'',0,1);
$pdf->SetFont('Arial','',11);

//Weiterbildungen
for ($i = 0; $i < count($weiterbildungen);$i++)
{
	$weiterbildung = $weiterbildungen[$i];
	for ($j = 0; $j < count($weiterbildung); $j++)
	{
		switch($j)
		{
			case 0: $pdf->Cell($erstespalte,$zellenhöheklein,$weiterbildung[$j],0);
				break;
			case 1: $pdf->Cell($erstespalte,$zellenhöheklein,$weiterbildung[$j],0,1);
				break;
			case 2; $pdf->Cell($erstespalte,$zellenhöheklein,'');
					$pdf->Cell(10,$zellenhöheklein,$weiterbildung[$j].", ".$weiterbildung[$j+1].", ".$weiterbildung[$j+2],0,1);
					$pdf->Cell(140,5,'',0,1);
				break;
		}
		if($j == 2)break;
	}
}
$pdf->Cell(140,5,'',0,1);

//Ausbildungen
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,'Ausbildungen',0,1);
$pdf->Cell(180,0,'','B',1,1);
$pdf->Cell(180,3,'',0,1);
$pdf->SetFont('Arial','',11);

for ($i = 0; $i < count($ausbildungen);$i++)
{
	$ausbildung = $ausbildungen[$i];
	for ($j = 0; $j < count($ausbildung); $j++)
	{
		switch($j)
		{
			case 0: $pdf->Cell($erstespalte,$zellenhöheklein,$ausbildung[$j],0);
				break;
			case 1: $pdf->Cell($erstespalte,$zellenhöheklein,$ausbildung[$j],0,1);
				break;
			case 2; $pdf->Cell($erstespalte,$zellenhöheklein,'');
					$pdf->Cell(10,$zellenhöheklein,$ausbildung[$j].", ".$ausbildung[$j+1].", ".$ausbildung[$j+2],0,1);
					$pdf->Cell(140,5,'',0,1);
				break;
		}
		if($j == 2)break;
	}
}
$pdf->AddPage();


//**************************Neue Seite erzwingen******************************


//Berufserfahrung
$pdf->SetFont('Arial','B',11);
$pdf->Cell(80,5,'Berufserfahrung',0,1);
$pdf->Cell(180,0,'','B',1,1);
$pdf->Cell(180,3,'',0,1);
$pdf->SetFont('Arial','',11);

for ($i = 0; $i < count($berufserfahrung);$i++)
{
	$arbeitgeber = $berufserfahrung[$i];
	for ($j = 0; $j < count($arbeitgeber); $j++)
	{
		switch($j)
		{
			case 0: $pdf->Cell($erstespalte,$zellenhöheklein,$arbeitgeber[$j],0);
				break;
			case 1: $pdf->SetFont('Arial','B',11);
					$pdf->Cell($erstespalte,$zellenhöheklein,'Arbeitgeber: '.$arbeitgeber[$j].", ".$arbeitgeber[$j+1].", ".$arbeitgeber[$j+2],0,1);
				break;
			case 2; $pdf->SetFont('Arial','I',11);
					$pdf->Cell(50,$zellenhöheklein,'');
					$pdf->Cell(10,$zellenhöheklein,$arbeitgeber[$j+2],0,1);
				break;
			case 3; $pdf->SetFont('Arial','',11);
					$pdf->Cell($erstespalte,$zellenhöheklein,'');
					$pdf->Cell(10,$zellenhöheklein,'Bereich: '.$arbeitgeber[$j+2],0,1);
					$pdf->Cell(140,5,'',0,1);
				break;
		}
		if($j == 3)break;
	}
}


//Projekte
for ($i = 0; $i < count($projekte);$i++)
{
	$projekt = $projekte[$i];
	for ($j = 0; $j < count($projekt); $j++)
	{
		$pdf->Cell($erstespalte,$zellenhöheklein,'');
		switch($j)
		{
			case 0: $pdf->SetFont('Arial','U',11);
					$pdf->Cell($erstespalte,$zellenhöheklein,'Kunde: '.$projekt[$j].", ".$projekt[$j+1].", ".$projekt[$j+2],0,1);
				break;
			case 1; $pdf->SetFont('Arial','',11);
					$pdf->Cell($erstespalte,$zellenhöheklein,$projekt[$j+2],0,1);
				break;
			case 2; $pdf->SetFont('Arial','I',11);
					$pdf->Cell(5,7,'');
					$pdf->Cell($erstespalte,$zellenhöheklein,'Projekt: '.$projekt[$j+2]." (".$projekt[$j+3].")",0,1);
					
				break;
			case 3;	
				$count = count($projekt[6]);
				if ($projekt[6] > 0 ){
					for ($k = 0; $k < $count; $k++)
						{
							$pdf->Cell(10,$zellenhöheklein,'');
							$pdf->SetFont('Arial','',11);
							$pdf->Cell(55,5,"• ".$projekt[6][$k],0,1);
							$pdf->Cell(45,5,'');
						}  
				}
					$pdf->Cell(140,5,'',0,1);
				break;
		}
		if($j == 3)break;
	}
}



//Ende - Ausgabe
$pdf->Output('CV_'.$vorundnachname.'.pdf', 'I');

?>