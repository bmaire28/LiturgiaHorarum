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
include ("romain/office_r.php");
include("fonctions.php");
include("tenebres.php");
//print_r("apr&egrave;s chargement des inclusions<br>");

/*
 * récupération des paramètres via GET
 */
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

/*
 * initialisation des variables de date
 */

$die=substr($do,6,2);
$dts=mktime(12,0,0,$mense,$die,$anno);
$datelatin=date_latin($dts);
$dtsmoinsun=$dts-60*60*24;
$dtsplusun=$dts+60*60*24;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);
//print_r("initialisation des variables GET <br>");

$calendarium=calendarium($do);

//print_r("initialisation du calendrier <br>");
?>
<head>
	<?php print "<title>Liturgia Horarum, ".$datelatin."</title>"; ?>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="CSS/stylesheet.css" />
	<meta name="viewport" content="target-densitydpi=device-dpi" />
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
					print mod_calendarium($mense,$anno,$do,"romain");
				?>
			</div>
		</div>
	</header>
	
	<section>

<?php 
//// Heure de l'Office &agrave; afficher

if($calendarium['hebdomada'][$do]=="Infra octavam paschae") {
	$temporal['ps1']['latin']="ps62";
	$temporal['ps2']['latin']="AT41";
	$temporal['ps3']['latin']="ps149";
	$temporal['ps7']['latin']="ps109";
	$temporal['ps8']['latin']="ps113A";
	$temporal['ps9']['latin']="NT12";
}



/*
 * Initialisation des variables
 * $anno = année de l'office
 * $mense = mois de l'office
 * $die = jour de l'office
 * $day = timestamp du jour de l'office
 * $do_l = liste de noms des jours en latin
 * $do_fr = liste de noms des jours en français
 * $jrdelasemaine = numéro du jour dans la semaine (0 &agrave; 6)
 * $date_l = nom du jour de l'office en latin
 * $date_fr = nom du jour de l'office en français
 *
 */
$anno=substr($do,0,4);
$mense=substr($do,4,2);
$die=substr($do,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);

switch ($_GET['office']) {
	case "laudes" :
		$jour_l = array("Dominica, Ad Laudes matutinas", "Feria secunda, Ad Laudes matutinas","Feria tertia, Ad Laudes matutinas","Feria quarta, Ad Laudes matutinas","Feria quinta, Ad Laudes matutinas","Feria sexta, Ad Laudes matutinas", "Sabbato, Ad Laudes matutinas");
		$jour_fr=array("Le Dimanche aux Laudes","Le Lundi aux Laudes","Le Mardi aux Laudes","Le Mercredi aux Laudes","Le Jeudi aux Laudes","Le Vendredi aux Laudes","Le Samedi aux Laudes");
		break;
	case "tierce" :
		$jour_l = array("Dominica, ad Tertiam", "Feria secunda, ad Tertiam","Feria tertia, ad Tertiam","Feria quarta, ad Tertiam","Feria quinta, ad Tertiam","Feria sexta, ad Tertiam", "Sabbato, ad Tertiam");
		$jour_fr=array("Le Dimanche &agrave; Tierce","Le Lundi &agrave; Tierce","Le Mardi &agrave; Tierce","Le Mercredi &agrave; Tierce","Le Jeudi &agrave; Tierce","Le Vendredi &agrave; Tierce","Le Samedi &agrave; Tierce");
		break;
	case "sexte" :
		$jour_l = array("Dominica, ad Sextam", "Feria secunda, ad Sextam","Feria tertia, ad Sextam","Feria quarta, ad Sextam","Feria quinta, ad Sextam","Feria sexta, ad Sextam", "Sabbato, ad Sextam");
		$jour_fr=array("Le Dimanche &agrave; Sexte","Le Lundi &agrave; Sexte","Le Mardi &agrave; Sexte","Le Mercredi &agrave; Sexte","Le Jeudi &agrave; Sexte","Le Vendredi &agrave; Sexte","Le Samedi &agrave; Sexte");
		break;
	case "none" :
		$jour_l = array("Dominica, ad Nonam", "Feria secunda, ad Nonam","Feria tertia, ad Nonam","Feria quarta, ad Nonam","Feria quinta, ad Nonam","Feria sexta, ad Nonam", "Sabbato, ad Nonam");
		$jour_fr=array("Le Dimanche &agrave; None","Le Lundi &agrave; None","Le Mardi &agrave; None","Le Mercredi &agrave; None","Le Jeudi &agrave; None","Le Vendredi &agrave; None","Le Samedi &agrave; None");
		break;
	case "vepres" :
		$jour_l = array("Dominica, ad II Vesperas", "Feria secunda, ad Vesperas","Feria tertia, ad Vesperas","Feria quarta, ad Vesperas","Feria quinta, ad Vesperas","Feria sexta, ad Vesperas", "Dominica, ad I Vesperas");
		$jour_fr=array("Le Dimanche aux IIes V&ecirc;pres","Le Lundi aux V&ecirc;pres","Le Mardi aux V&ecirc;pres","Le Mercredi aux V&ecirc;pres","Le Jeudi aux V&ecirc;pres","Le Vendredi aux V&ecirc;pres","Le Dimanche aux I&egrave;res V&ecirc;pres");
		break;
	case "complies" :
		$jours_l = array("Dominica, post II Vesperas, ad ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, post I Vesperas, ad ");
		$jours_fr=array("Le Dimanche apr&egrave;s les IIes V&ecirc;pres, aux  ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche, apr&egrave;s les I&egrave;res V&ecirc;pres, aux ");
		break;
}

$jrdelasemaine=date("w",$day);
$date_fr=$jour_fr[$jrdelasemaine];
$date_l=$jour_l[$jrdelasemaine];

/*
 * Calcul de la lettre de l'année
 * récupérer l'année du 27 novembre précédent
 * diviser l'année par 3 et regarder le reste
 * 0 = A, 1 = B, 2 = C
*/
$num_mois_cour=intval($mense);
$num_annee_cour=intval($anno);
$num_jour_cour=intval($die);
//print_r("année : ".$num_annee_cour."<br>mois : ".$num_mois_cour."<br>jour : ".$num_jour_cour);
//print_r("<br>reste :".fmod($num_annee_cour, 3)."<br>");

// si nous sommes avant novembre ou en novembre avant le 27, nous sommes dans l'année liturgique précédente
if ($num_mois_cour < 11) $num_annee_cour=$num_annee_cour-1;
if (($num_mois_cour == 11)&&($num_jour_cour < 27)) $num_annee_cour=$num_annee_cour-1;

switch (fmod($num_annee_cour, 3)) {
	case 0 :
		$lettre="A";
		break;
	case 1:
		$lettre="B";
		break;
	case 2:
		$lettre="C";
		break;
}
$bene="benedictus_".$lettre;
$magni="magnificat_".$lettre;
$pmagni="pmagnificat_".$lettre;

//print_r($lettre."<br>");

$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$do];

/*
 * Chargement du propre au psautier du jour
 */
$fichier="romain/commune_r/psautier_".$spsautier.$jrdelasemaine.".csv";
if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
else {
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$ref=$data[1];
		$ferial[$id]['latin']=$ref;
		$row++;
	}
	fclose($fp);
}


/*
 * Déterminer le temps liturgique :
 * $psautier prend la caleur du temps liturgique abrégé
 *
 * Ouvrir et charger le propre du jour dans $ferial:
 * $q prend la valeur du nom du fichier en fonction du temps liturgique, du numéro de semaine et du jour :
 * - temps liturgique via $psautier
 * - numéro de la semaine soit dans $psautier pour Pascal et Car&ecirc;me, soit 1 &agrave; 4
 * - jour de la semaine de 1 pour Dimanche &agrave; 7 pour Samedi
 *
*/
$tem=$calendarium['tempus'][$do];
switch ($tem) {
	case "Tempus Adventus" :
		$psautier="adven";
		$q=$psautier."_".$spsautier;
		break;

	case "Tempus Nativitatis" :
		$psautier="noel";
		$q=$psautier."_".$spsautier;
		break;

	case "Tempus per annum" :
		$psautier="perannum";
		$q=$psautier."_".$spsautier;
		break;

	case "Tempus Quadragesimae" :
		$psautier="quadragesimae";
		if ($calendarium['intitule'][$do]=="Feria IV Cinerum") { $q="quadragesima_0";}
		switch ($calendarium['hebdomada'][$do]) {
			case "Dies post Cineres" :
				$q="quadragesima_0";
				break;
			case "Hebdomada I Quadragesimae" :
				$q="quadragesima_1";
				break;
			case "Hebdomada II Quadragesimae" :
				$q="quadragesima_2";
				break;
			case "Hebdomada III Quadragesimae" :
				$q="quadragesima_3";
				break;
			case "Hebdomada IV Quadragesimae" :
				$q="quadragesima_4";
				break;
			case "Hebdomada V Quadragesimae" :
				$q="quadragesima_5";
				break;
		}
		break;

	case "Tempus passionis" :
		$psautier="hebdomada_sancta";
		$q="hebdomada_sancta";
		break;

	case "Tempus Paschale" :
		$psautier="pascha";
		switch ($calendarium['hebdomada'][$do]) {
			case "Infra octavam paschae" :
				$q="pascha_1";
				break;
			case "Hebdomada II Paschae" :
				$q="pascha_2";
				break;
			case "Hebdomada III Paschae" :
				$q="pascha_3";
				break;
			case "Hebdomada IV Paschae" :
				$q="pascha_4";
				break;
			case "Hebdomada V Paschae" :
				$q="pascha_5";
				break;
			case "Hebdomada VI Paschae" :
				$q="pascha_6";
				break;
			case "Hebdomada VII Paschae" :
				$q="pascha_7";
				break;
			case " " :
				$q="pascha_8";
				break;
		}
		break;

	default :
		print"<br><i>Cet office n'est pas encore compl&egrave;tement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider &agrve; compl&eacute;ter ce travail.</a></i>";
		return;
		break;
}
$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." introuvable !</p>");
else {
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$ferial[$id]['latin']=$latin;
		$ferial[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
}

/*
 * Vérifier qu'il n'y a pas de saint &agrave; célébrer
 * Chargement du propre du sanctoral dans $sanctoral
 *
*/
if (($calendarium['rang'][$do])or($calendarium['priorite'][$do]==12)) {
	$prop=$mense.$die;
	$fichier="propres_r/sanctoral/".$prop.".csv";
	if (!file_exists($fichier)) print_r("<p>Sanctoral : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$sanctoral[$id]['latin']=$data[1];
			$sanctoral[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
	}
}
if ($sanctoral[$magni]['latin']) {
	$sanctoral['magnificat']['latin']=$sanctoral[$magni]['latin'];
	$sanctoral['magnificat']['francais']=$sanctoral[$magni]['francais'];
}
if ($sanctoral[$bene]['latin']) {
	$sanctoral['benedictus']['latin']=$sanctoral[$bene]['latin'];
	$sanctoral['benedictus']['francais']=$sanctoral[$bene]['francais'];
}


/*
 * octave glissante précédent noel
 */
if(($mense==12)AND(
		($die==17)
		OR($die==18)
		OR($die==19)
		OR($die==20)
		OR($die==21)
		OR($die==22)
		OR($die==23)
		OR($die==24)
)
) {
	$prop=$mense.$die;
	// Chargement du fichier de la date fixe
	$fichier="propres_r/sanctoral/".$prop.".csv";
	if (!file_exists($fichier)) print_r("<p>Sanctoral avant noel : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$sanctoral[$id]['latin']=$data[1];
			$sanctoral[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
	}
		
	// Chargement du fichier du jour de la semaine
	$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine."post1712.csv";
	if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];$latin=$data[1];$francais=$data[2];
			$ferial[$id]['latin']=$latin;
			$ferial[$id]['francais']=$francais;
			$row++;
		}
		fclose($fp);
	}
	// Transfert de l'intitule
	$sanctoral['intitule']['latin']=$ferial['intitule']['latin'];
	$sanctoral['intitule']['francais']=$ferial['intitule']['francais'];
}

/*
 * Vérification du temporal - solennités et fetes
 * Chargement de $temporal avec les valeurs du temporal
 *
 */

if($calendarium['temporal'][$do]) {
	$tempo=$calendarium['temporal'][$do];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$temporal[$id]['latin']=$data[1];
			$temporal[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
	}
	if ($temporal[$bene]['latin']) {
		$temporal['benedictus']['latin']=$temporal[$bene]['latin'];
		$temporal['benedictus']['francais']=$temporal[$bene]['francais'];
	}
	if ($temporal[$magni]['latin']) {
		$temporal['magnificat']['latin']=$temporal[$magni]['latin'];
		$temporal['magnificat']['francais']=$temporal[$magni]['francais'];
	}

	$date_fr=$date_l=null;
	if($_GET['office']=='vepres') {
		// Gestion intitule Ieres ou IIndes vepres en latin
		if (($calendarium['intitule'][$do]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$do]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l="<br> ad ";
		elseif ($calendarium['1V'][$do]) $date_l="<br> ad II ";
		else $date_l = "<br> ad ";

		// Gestion intitule Ieres ou IIndes vepres en francais
		if (($calendarium['intitule'][$do]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$do]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr="<br> aux ";
		elseif ($calendarium['1V'][$do]) $date_fr = "<br> aux IIdes ";
		else $date_fr = "<br> aux ";
	}
}

/*
 * Gestion du 4e Dimanche de l'Avent
 * si c'est le 24/12, prendre toutes les antiennes au 24, rien &agrave; modifier
 * sinon prendre uniquement l'antienne benedictus ==> recopier le temporal dans le sanctoral
 */
if ($temporal['intitule']['latin']=="Dominica IV Adventus") {
	if ($die!="24") {
		$benelat=$sanctoral['benedictus']['latin'];
		$benefr=$sanctoral['benedictus']['francais'];
		$magniflat=$sanctoral['magnificat']['latin'];
		$magniffr=$sanctoral['magnificat']['francais'];
		$sanctoral=$temporal;
		$sanctoral['benedictus']['latin']=$benelat;
		$sanctoral['benedictus']['francais']=$benefr;
		$sanctoral['magnificat']['latin']=$magniflat;
		$sanctoral['magnificat']['francais']=$magniffr;
	}
	else {
		$calendarium['priorite'][$do]++;
	}
}

/*
 * Vérification de premieres vepres au temporal - solennités et fetes
 * Chargement de $temporal avec les valeurs du temporal
 * Affectation des valeurs hymne, LB, RB, ... &agrave; partir de $temporal
 */
$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);

/*print_r("<p> demain : ".$demain."</p>");
 print_r("<p> 1V demain : ".$calendarium['1V'][$demain]."</p>");
 print_r("<p> priorite jour : ".$calendarium['priorite'][$do]."</p>");
 print_r("<p> priorite demain : ".$calendarium['priorite'][$demain]."</p>");
print_r("<p> intitule demain : ".$calendarium['intitule'][$demain]."</p>");*/
if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$do]>$calendarium['priorite'][$demain])&&($_GET['office']=='vepres')) {
	/*print_r("<p> 1V</p>");*/
	$tempo=null;
	$temporal=null;
	$tempo=$calendarium['temporal'][$demain];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal 1V : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$temporal[$id]['latin']=$data[1];
			$temporal[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
	}
	$sanctoral=null;
	$date_l = "ad I ";
	$date_fr = "aux I&egrave;res ";
	$temporal['HYMNUS_vepres']['latin']=$temporal['HYMNUS_1V']['latin'];
	$temporal['ant7']['latin']=$temporal['ant01']['latin'];
	$temporal['ant7']['francais']=$temporal['ant01']['francais'];
	$temporal['ant8']['latin']=$temporal['ant02']['latin'];
	$temporal['ant8']['francais']=$temporal['ant02']['francais'];
	$temporal['ant9']['latin']=$temporal['ant03']['latin'];
	$temporal['ant9']['francais']=$temporal['ant03']['francais'];
	$temporal['ps7']['latin']=$temporal['ps01']['latin'];
	$temporal['ps7']['francais']=$temporal['ps01']['francais'];
	$temporal['ps8']['latin']=$temporal['ps02']['latin'];
	$temporal['ps8']['francais']=$temporal['ps02']['francais'];
	$temporal['ps9']['latin']=$temporal['ps03']['latin'];
	$temporal['ps9']['francais']=$temporal['ps03']['francais'];
	$temporal['LB_soir']['latin']=$temporal['LB_1V']['latin'];
	$temporal['RB_soir']['latin']=$temporal['RB_1V']['latin'];
	$temporal['RB_soir']['francais']=$temporal['RB_1V']['francais'];
	if ($temporal[$pmagni]['latin']) {
		$temporal[$magni]['latin']=$temporal[$pmagni]['latin'];
		$temporal[$magni]['francais']=$temporal[$pmagni]['francais'];
	}
	else {
		$temporal['magnificat']['latin']=$temporal['pmagnificat']['latin'];
		$temporal['magnificat']['francais']=$temporal['pmagnificat']['francais'];
	}
	$temporal['preces_soir']['latin']=$temporal['preces_1V']['latin'];
	$temporal['oratio_soir']['latin']=$temporal['oratio_1V']['latin'];
	$temporal['oratio_soir']['francais']=$temporal['oratio_1V']['francais'];
	if ($temporal['intitule']['latin']=="Dominica IV Adventus"){
		$sanctoral['LB_soir']['latin']=$temporal['LB_1V']['latin'];
		$sanctoral['RB_soir']['latin']=$temporal['RB_1V']['latin'];
		$sanctoral['RB_soir']['francais']=$temporal['RB_1V']['francais'];
		$sanctoral['oratio']['latin']=$temporal['oratio']['latin'];
		$sanctoral['oratio']['francais']=$temporal['oratio']['francais'];
	}
}

/*
 * Gestion des Complies
 */

if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($jrdelasemaine!=7)) {
	////////////////////////////////////////
	/// il y a des "1ères Complies"  //////
	//////////////////////////////////////
	$fichier="romain/complies_r/comp_FVS.csv";
	if (!file_exists($fichier)) print_r("<p>Complies 1V : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$ferial[$id]['latin']=$data[1];
			$ferial[$id]['francais']=$data[2];
			$row++;
		}/*
		$tempo=$calendarium['temporal'][$demain];
		$fichier="propres_r/temporal/".$tempo.".csv";
		if (!file_exists($fichier)) print_r("<p>temporal Complies 1V : ".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$temporal[$id]['latin']=$data[1];
			$temporal[$id]['francais']=$data[2];
			$row++;
		}*/
		fclose($fp);
	}
}

if (($calendarium['1V'][$jour]==1)&&($calendarium['priorite'][$jour]<$calendarium['priorite'][$demain])&&($jrdelasemaine!=1)) {
	////////////////////////////////////////
	/// il y a des "2ndes Complies"  //////
	//////////////////////////////////////
	$fichier="romain/complies_r/comp_FS.csv";
	if (!file_exists($fichier)) print_r("<p>Complies 2V : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$ferial[$id]['latin']=$data[1];
			$ferial[$id]['francais']=$data[2];
			$row++;
		}/*
		$tempo=$calendarium['temporal'][$demain];
		$fichier="propres_r/temporal/".$tempo.".csv";
		if (!file_exists($fichier)) print_r("<p>temporal Complies 2V : ".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$temporal[$id]['latin']=$data[1];
			$temporal[$id]['francais']=$data[2];
			$row++;
		}*/
		fclose($fp);
	}
}


if(!$ferial['ant11']['latin']){
	$fichier="romain/complies_r/comp_F".$jrdelasemaine.".csv";
	if (!file_exists($fichier)) print_r("<p>Complies : ".$fichier." introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];$latin=$data[1];$francais=$data[2];
			$ferial[$id]['latin']=$latin;
			$ferial[$id]['francais']=$francais;
			$row++;
		}
		fclose($fp);
	}
}
/*
 * Fin de gestion des Complies
 */


switch($office){
	case "laudes" :
		//print epuration(laudes($do,$calendarium));
		if (($calendarium['intitule'][$do]=="IN PASSIONE DOMINI") or ($calendarium['intitule'][$do]=="Sabbato Sancto")) print epuration(tenebres($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
		else print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
	break;
	
	case "mdj" :
		//print epuration(mediahora($do,$calendarium));
		print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
	break;
	
	case "tierce" :
		//print epuration(tierce($do,$calendarium));
		print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
	break;
	
	case "sexte" :
		//print epuration(sexte($do,$calendarium));
		print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
	break;
	
	case "none" :
		//print epuration(none($do,$calendarium));
		print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
	break;
	
	case "vepres" :
		//print epuration(vepres($do,$calendarium));
		print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
	break;
	
	case "complies" :
		//print epuration(complies($do,$calendarium));
		print epuration(office_r($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium));
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