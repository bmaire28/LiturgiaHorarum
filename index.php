<!DOCTYPE html>
	<html>
		
<?php
//liturgia_horarum Component//
/**
* Content code
* @package liturgia_horarum
* @Copyright (C) 2006 FXP
* @ All rights reserved
* @ liturgia_horarum is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version 0.1
**/

//Registered

//defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
//include('calendrier/smtp.php');
global $my;

//print_r($my);

include ("calendarium.php");
include("laudes.php");
include("tierce.php");
include("sexte.php");
include("none.php");
include("vepres.php");
include("complies.php");
include("messe.php");
include("fonctions.php");


$task=$_GET['task'];
$office=$_GET['office'];
$do=$_GET['do'];
$do=$_GET['date'];


if ($task=="martyrologe") {
	include "martyrologe.php";	
}

if(!$do) {
	$tfc=time();
	$do=date("Ymd",$tfc);
}

$anno=$_GET['an'];
if ($anno=="") $anno=substr($do,0,4);

$mense=$_GET['mois_courant'];
if ($mense=="") $mense=substr($do,4,2);
$die=substr($do,6,2);
$dts=mktime(12,0,0,$mense,$die,$anno);
$datelatin=date_latin($dts);
$dtsmoinsun=$dts-60*60*24;
$dtsplusun=$dts+60*60*24;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);
//print"$do : $anno/$mense/$die";

$calendarium=calendarium($do,0);
 

print "
		<head>
		<title>Liturgia Horarum, ".$datelatin."</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
		</head>
		<body>
		";

	

//// Tableau du haut
if($task!="martyrologe") {
	affiche_nav($do,$office);
	print"<center><table bgcolor=#FEFEFE width=100%><tr><td><center>";
	print"".$calendarium['hebdomada'][$do]."<br>";
	print"".$datelatin."<br>";
	print"Semaine du psautier : ".$calendarium['hebdomada_psalterium'][$do]."<br>";
	if($calendarium['intitule'][$do]) print"<b>".$calendarium['intitule'][$do]."</b><br>";
	if($calendarium['rang'][$do]) print"Rang : ".$calendarium['rang'][$do].", ";
	print"Couleur : ".$calendarium['couleur_template'][$do]."<br>";
	print"</center></td><td><center>";
	print mod_calendarium($mense,$anno);
	print"</center></td></tr></table></center>";
	}


//// Heure de l'Office à afficher
switch($office){
	case "laudes" :
		print epuration(laudes($do,$calendarium,$my));
	break;
	
	case "mdj" :
		print epuration(mediahora($do,$calendarium,$my));
	break;
	
	case "tierce" :
		print epuration(tierce($do,$calendarium,$my));
	break;
	
	case "sexte" :
		print epuration(sexte($do,$calendarium,$my));
	break;
	
	case "none" :
		print epuration(none($do,$calendarium,$my));
	break;
	
	case "vepres" :
		print epuration(vepres($do,$calendarium,$my));
	break;
	
	case "complies" :
		print epuration(complies($do,$calendarium,$my));
	break;
	
	case "messe" :
		print epuration(messe($do,$calendarium,$my));
	break;
}

affiche_nav($do,$office);
/*
print "
	</body>
</html>
";
*/
?>
</body>
</html>