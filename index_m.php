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
include ("monastique/office_m.php");
include("tenebres.php");
//print_r("apr&egrave;s chargement des inclusions<br>");

/*
 * récupération des paramètres via GET
 */
$task=$_GET['task'];
$office=$_GET['office'];
if ($office == "") { $office="complies"; }
$rite=$_GET['rite'];
if ($rite == "") { $rite="monastique"; }

$do=$_GET['do'];
$do=$_GET['date'];
if($do=="") { $tfc=time(); $do=date("Ymd",$tfc); }
$mense=$_GET['mois_courant']; if ($mense=="") $mense=substr($do,4,2);
$anno=$_GET['an']; if ($anno=="") $anno=substr($do,0,4);
$die=substr($do,6,2);
$dts=mktime(12,0,0,$mense,$die,$anno);


/*
 * initialisation des variables de date
 */


$unJour=60*60*24;
$dtsmoinsun=$dts-$unJour;
$dtsplusun=$dts+$unJour;
$hier=date("Ymd",$dtsmoinsun);
$demain=date("Ymd",$dtsplusun);

switch ($office) {
	case 'p':
		unset($_GET['office']);
		$office="complies";
		$do=$hier;
		$die=substr($do,6,2);$mense=substr($do,4,2);$anno=substr($do,0,4);
		$dts=mktime(12,0,0,$mense,$die,$anno);
		break;
	case 's':
		unset($_GET['office']);
		$office="laudes";
		$do=$demain;
		$die=substr($do,6,2);$mense=substr($do,4,2);$anno=substr($do,0,4);
		$dts=mktime(12,0,0,$mense,$die,$anno);
		break;
}
$datelatin=date_latin($dts);

include("fonctions.php");

$calendarium=calendarium($do);
?>
<head>
	<?php print "<title>Liturgia Horarum, ".$datelatin."</title>"; ?>
	<meta charset="utf-8">
	<?php print"<link type=\"text/css\" rel=\"stylesheet\" href=\"CSS/stylesheet_".$calendarium['couleur_template'][$do].".css\"/>"?>
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
					print mod_calendarium($mense,$anno,$do,"monastique",$office);
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
$jrdelasemaine=date("w",$day);
$tomorow = $day+$unJour;
$demain=date("Ymd",$tomorow);

/*
 * Calcul de la date du Dimanche precedent
 */
$ecart=$jrdelasemaine*$unJour;
$sunday=$day-$ecart;
$dimanche=date("Ymd",$sunday);

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
if (($spsautier=="3")or($spsautier=="1"))  $spsautier="1"; //premiere semaine
else $spsautier="2"; // seconde semaine


/*
 * Déterminer le temps liturgique :
 * $psautier prend la caleur du temps liturgique abrégé
 *
 * Ouvrir et charger le propre du jour dans $ferial:
 * $q prend la valeur du nom du fichier en fonction du temps liturgique, du numéro de semaine et du jour :
 * - temps liturgique via $psautier
 * - numéro de la semaine soit dans $psautier pour Pascal et Careme, soit 1 a 4
 * - jour de la semaine de 1 pour Dimanche a 7 pour Samedi
 *
*/
$fichier="";
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
		//$fichier="monastique/temporal/".$q.$jrdelasemaine.".csv";
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
//print_r("</br>".$q."</br>".$psautier);

/*
 * Chargement de l'ordinaire du temps
 */

$fichier="monastique/commune_m/psautier_".$psautier.".csv";
if (!file_exists($fichier)) print_r("<p>Commun temps : ".$fichier." 276 introuvable !</p>");
else {
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$ferial[$id]['latin']=$latin;
		$ferial[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
	$fichier="";
}

/*
 * Chargement du psautier du jour et du temps
 */

$fichier="monastique/commune_m/psautier_".$psautier.$spsautier.$jrdelasemaine.".csv";
if (!file_exists($fichier)) print_r("<p>Commun jour : ".$fichier." 294 introuvable !</p>");
else {
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$ferial[$id]['latin']=$latin;
		$ferial[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
	$fichier="";
}

if ($fichier=="") $fichier="monastique/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
if (!file_exists($fichier)) print_r("<p>Temporal : ".$fichier." 308 introuvable !</p>");
else {
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		if ($id != "") {
			$ferial[$id]['latin']=$latin;
			$ferial[$id]['francais']=$francais;
		}
		$row++;
	}
	fclose($fp);
	$fichier="";
}

/*
 * Vérifier qu'il n'y a pas de saint a célébrer
 * Chargement du propre du sanctoral dans $sanctoral
 *
*/
if (($calendarium['rang'][$do])or($calendarium['priorite'][$do]==12)) {
	$prop=$mense.$die;
	$fichier="propres_r/sanctoral/".$prop.".csv";
	if (!file_exists($fichier)) print_r("<p>Sanctoral : ".$fichier." 331 introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$sanctoral[$id]['latin']=$data[1];
			$sanctoral[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
		$fichier="";
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
	if (!file_exists($fichier)) print_r("<p>Sanctoral avant noel : ".$fichier." 371 introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$sanctoral[$id]['latin']=$data[1];
			$sanctoral[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
		$fichier="";
	}

	// Chargement du fichier du jour de la semaine
	$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine."post1712.csv";
	if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." 386 introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];$latin=$data[1];$francais=$data[2];
			$ferial[$id]['latin']=$latin;
			$ferial[$id]['francais']=$francais;
			$row++;
		}
		fclose($fp);
		$fichier="";
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
	//$fichier="propres_r/temporal/".$tempo.".csv";
	$fichier="monastique/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." 413 introuvable !</p>");
	else {
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];
			$temporal[$id]['latin']=$data[1];
			$temporal[$id]['francais']=$data[2];
			$row++;
		}
		fclose($fp);
		$fichier="";
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
	if($office=='vepres') {
		// Gestion intitule Ieres ou IIndes vepres en latin
		if (($calendarium['intitule'][$do]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$do]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l="<br> ad ";
		elseif ($calendarium['1V'][$do]) $date_l="<br> ad II Vesperas";
		else $date_l = "<br> ad Vesperas";

		// Gestion intitule Ieres ou IIndes vepres en francais
		if (($calendarium['intitule'][$do]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$do]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr="<br> aux ";
		elseif ($calendarium['1V'][$do]) $date_fr = "<br> aux IIndes V&ecirc;pres";
		else $date_fr = "<br> aux V&ecirc;pres";
	}
}
else {
	if ($tem=="Tempus per annum") {
		$tempo=$calendarium['temporal'][$dimanche];
		$fichier="monastique/temporal/".$tempo.".csv";
		if (!file_exists($fichier)) $fichier="propres_r/temporal/".$tempo.".csv";
		if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." 452 introuvable !</p>");
		else {
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				if ($id=="oratio") {
					$temporal[$id]['latin']=$data[1];
					$temporal[$id]['francais']=$data[2];
				}
				$row++;
			}
			fclose($fp);
			$fichier="";
		}
	}
}

/*
 * Gestion du 4e Dimanche de l'Avent
 * si c'est le 24/12, prendre toutes les antiennes au 24, rien a modifier
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
if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$do]>$calendarium['priorite'][$demain])&&($office=='vepres')) {
	/*print_r("<p> 1V</p>");*/
	$tempo=null;
	$temporal=null;
	$tempo=$calendarium['temporal'][$demain];
	$fichier="monastique/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal 1V : ".$fichier." 510 introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$temporal[$id]['latin']=$data[1];
		$temporal[$id]['francais']=$data[2];
		$row++;
	}
	fclose($fp);
	$fichier="";
	$sanctoral=null;
	$date_l = "ad I Vesperas";
	$date_fr = "aux I&egrave;res V&ecirc;pres";
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
	$fichier="monastique/complies_m/comp_FVS.csv";
	if (!file_exists($fichier)) print_r("<p>Complies 1V : ".$fichier." 568 introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$ferial[$id]['latin']=$data[1];
		$ferial[$id]['francais']=$data[2];
		$row++;
	}
	$date_l = $intitule_lat."<br> Post I Vesperas, ad Completorium";
    $date_fr = $intitule_fr."<br> Apr&egrave;s les Ires V&ecirc;pres, aux Complies";
    /*
	$tempo=$calendarium['temporal'][$demain];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal Complies 1V : ".$fichier." 581 introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$temporal[$id]['latin']=$data[1];
		$temporal[$id]['francais']=$data[2];
		$row++;
	}*/
	fclose($fp);
	$fichier="";
}

if (($calendarium['1V'][$jour]==1)&&($calendarium['priorite'][$jour]<$calendarium['priorite'][$demain])&&($jrdelasemaine!=1)) {
	////////////////////////////////////////
	/// il y a des "2ndes Complies"  //////
	//////////////////////////////////////
	$fichier="monastique/complies_m/comp_FS.csv";
	if (!file_exists($fichier)) print_r("<p>Complies 2V : ".$fichier." 598 introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$ferial[$id]['latin']=$data[1];
		$ferial[$id]['francais']=$data[2];
		$row++;
	}
	$date_l = $intitule_lat."<br> Post II Vesperas, ad Completorium";
    $date_fr = $intitule_fr."<br> Apr&egrave;s les IIes V&ecirc;pres, aux Complies";/*
	$tempo=$calendarium['temporal'][$demain];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal Complies 2V : ".$fichier." 610 introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$temporal[$id]['latin']=$data[1];
		$temporal[$id]['francais']=$data[2];
		$row++;
	}*/
	fclose($fp);
	$fichier="";
}


if($ferial['LB_comp']['latin']==""){
	$fichier="monastique/complies_m/comp_F".$jrdelasemaine.".csv";
	if (!file_exists($fichier)) print_r("<p>Complies : ".$fichier." 625 introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$ferial[$id]['latin']=$latin;
		$ferial[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
	$fichier="";
}
/*
 * Fin de gestion des Complies
 */


switch($office){
	case "laudes" :
		//print epuration(laudes($do,$calendarium));
		if (($calendarium['intitule'][$do]=="IN PASSIONE DOMINI") or ($calendarium['intitule'][$do]=="Sabbato Sancto")) print epuration(tenebres($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
		else print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
	break;

	case "mdj" :
		//print epuration(mediahora($do,$calendarium));
		print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
	break;

	case "tierce" :
		//print epuration(tierce($do,$calendarium));
		print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
	break;

	case "sexte" :
		//print epuration(sexte($do,$calendarium));
		print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
	break;

	case "none" :
		//print epuration(none($do,$calendarium));
		print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
	break;

	case "vepres" :
		//print epuration(vepres($do,$calendarium));
		print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
	break;

	case "complies" :
		//print epuration(complies($do,$calendarium));
		print epuration(office_m($do,$date_l,$date_fr,$ferial,$sanctoral,$temporal,$calendarium,$office));
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
