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
?>
<head>
	<?php print "<title>Liturgia Horarum, ".$datelatin."</title>"; ?>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="CSS/stylesheet.css" />
</head>

<body>
	<header>
	<!-- Tableau du haut -->
		<?php affiche_nav($do,$office,"tete"); ?>
		<div id="entete">
			<div id="ordo">
				<?php
				print"<p>".$calendarium['hebdomada'][$do]."</p>";
				print"<p>".$datelatin."</p>";
				print"<p>Semaine du psautier : ".$calendarium['hebdomada_psalterium'][$do]."</p>";
				if($calendarium['intitule'][$do]) print"<h1>".$calendarium['intitule'][$do]."</h1>";
				if($calendarium['rang'][$do]) print"<p>Rang : ".$calendarium['rang'][$do].",<p/> ";
				print"<p>Couleur : ".$calendarium['couleur_template'][$do]."</p>";
				?>
			</div>
			<div id="calendrier">
				<?php 
					print "<h1>Calendarium liturgicum $anno</h1>";
					print mod_calendarium($mense,$anno,$do);
				?>
			</div>
		</div>
	</header>
	
	<section>

<?php 
//// Heure de l'Office � afficher

switch($office){
	case "laudes" :
		print epuration(laudes($do,$calendarium));
	break;
	
	case "mdj" :
		print epuration(mediahora($do,$calendarium));
	break;
	
	case "tierce" :
		print epuration(tierce($do,$calendarium));
	break;
	
	case "sexte" :
		print epuration(sexte($do,$calendarium));
	break;
	
	case "none" :
		print epuration(none($do,$calendarium));
	break;
	
	case "vepres" :
		print epuration(vepres($do,$calendarium));
	break;
	
	case "complies" :
		print epuration(complies($do,$calendarium));
	break;
	
	case "messe" :
		print epuration(messe($do,$calendarium));
	break;
}

?>
	</section>
	<footer>
	<?php 
		affiche_nav($do,$office,"pied");
	?>
		</footer>
	</body>
</html>