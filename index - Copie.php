<!DOCTYPE HTML> 
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

//print_r("avant chargement des inclusions <br>");
include ("calendarium.php");
include("laudes.php");
include("tierce.php");
include("sexte.php");
include("none.php");
include("vepres.php");
include("complies.php");
include("messe.php");
include("fonctions.php");
//print_r("apr&egrave;s chargement des inclusions<br>");


$task=$_GET['task'];
$office=$_GET['office'];
$do=$_GET['do'];
$do=$_GET['date'];


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
//print_r("initialisation des variables GET <br>");

$calendarium=calendarium($do,0);
//print_r("initialisation du calendrier <br>");

print "		<head>
			<title>Liturgia Horarum, ".$datelatin."</title>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
			<link type=\"text/css\" rel=\"stylesheet\" href=\"CSS/stylesheet.css\" />
		</head>
		<body>
		";
/*
 * Ins�rer une feuille de style :
 * <link rel="stylesheet" type="text/css" href="mystyle.css">
 * 
 */
	

//// Tableau du haut
if($task!="martyrologe") {
	print "<header>
		";
	affiche_nav($do,$office,"tete");
	print "<div id=\"entete\">";
	print"<div id=\"ordo\">";
		print"<p>".$calendarium['hebdomada'][$do]."<br/>";
		print"".$datelatin."<br/>";
		print"Semaine du psautier : ".$calendarium['hebdomada_psalterium'][$do]."</p>";
		if($calendarium['intitule'][$do]) print"<h1>".$calendarium['intitule'][$do]."</h1>";
		print "<p>";
		if($calendarium['rang'][$do]) print"Rang : ".$calendarium['rang'][$do].",<br/> ";
		print"Couleur : ".$calendarium['couleur_template'][$do]."</p>";
	print"</div>";//div ordo
	print "
			<div id=\"calendrier\">
			<h1>Calendarium liturgicum $anno</h1>";
	print mod_calendarium($mense,$anno);
	print"	</div>
			</div>
			</header>
			";
	}


//// Heure de l'Office � afficher

print "
		<section>";
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
print "
		</section>";
print "
		<footer>";
affiche_nav($do,$office,"pied");
print "
		</footer>
";

?>
	</body>
</html>