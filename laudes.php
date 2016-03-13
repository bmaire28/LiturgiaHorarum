<?php

function laudes($jour,$calendarium,$my) {

if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
	$temp['ps1']['latin']="ps62";
	$temp['ps2']['latin']="AT41";
	$temp['ps3']['latin']="ps149";
}

/*
 * Initialisation des variables
 * $anno = année de l'office
 * $mense = mois de l'office
 * $die = jour de l'office
 * $day = timestamp du jour de l'office
 * $jour_l = liste de noms des jours en latin
 * $jour_fr = liste de noms des jours en français
 * $jrdelasemaine = numéro du jour dans la semaine (0 à 6)
 * $date_l = nom du jour de l'office en latin
 * $date_fr = nom du jour de l'office en français
 *
 */
$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);

$jours_l = array("Dominica, ad II ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, ad I ");
$jours_fr=array("Le Dimanche aux IIes ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche aux I&egrave;res ");
$jrdelasemaine=date("w",$day);
//$date_fr=$jours_fr[$jrdelasemaine];
//$date_l=$jours_l[$jrdelasemaine];


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
//print_r($lettre."<br>");

$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];

/*
 * Déterminer le temps liturgique :
* $psautier prend la caleur du temps liturgique abrégé
*
* Ouvrir et charger le propre du jour dans $var:
* $q prend la valeur du nom du fichier en fonction du temps liturgique, du numéro de semaine et du jour :
* - temps liturgique via $psautier
* - numéro de la semaine soit dans $psautier pour Pascal et Carême, soit 1 à 4
* - jour de la semaine de 1 pour Dimanche à 7 pour Samedi
*
*/
$tem=$calendarium['tempus'][$jour];
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
			if ($calendarium['intitule'][$jour]=="Feria IV Cinerum") { $q="quadragesima_0";}
			switch ($calendarium['hebdomada'][$jour]) {
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
        	switch ($calendarium['hebdomada'][$jour]) {
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
$fp = fopen ($fichier,"r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$latin=$data[1];$francais=$data[2];
	$var[$id]['latin']=$latin;
	$var[$id]['francais']=$francais;
	$row++;
}
fclose($fp);

/*
* Chargement du propre au psautier du jour
 */
$fichier="propres_r/commune/psautier_".$spsautier.$jrdelasemaine.".csv";
if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
$fp = fopen ($fichier,"r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$ref=$data[1];
	$reference[$id]=$ref;
	$row++;
}
fclose($fp);

/*
* Vérifier qu'il n'y a pas de saint à célébrer
* Chargement du propre du sanctoral dans $propre
*
*/
if (($calendarium['rang'][$jour])or($calendarium['priorite'][$jour]==12)) {
	$prop=$mense.$die;
	$fichier="propres_r/sanctoral/".$prop.".csv";
	if (!file_exists($fichier)) print_r("<p>Sanctoral : ".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$propre[$id]['latin']=$data[1];
		$propre[$id]['francais']=$data[2];
		$row++;
	}
	fclose($fp);
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
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$propre[$id]['latin']=$data[1];
				$propre[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
			
			// Chargement du fichier du jour de la semaine
			$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine."post1712.csv";
			if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];$latin=$data[1];$francais=$data[2];
				$var[$id]['latin']=$latin;
				$var[$id]['francais']=$francais;
				$row++;
			}
			fclose($fp);
			// Transfert de l'intitule
			$propre['intitule']['latin']=$var['intitule']['latin'];
			$propre['intitule']['francais']=$var['intitule']['francais'];
}

/*
* Vérification du temporal - solennités et fetes
* Chargement de $temp avec les valeurs du temporal
*
*/

if($calendarium['temporal'][$jour]) {
	$tempo=$calendarium['temporal'][$jour];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
		$row++;
	}
	fclose($fp);
	
	$date_fr=$date_l=null;
	// Gestion intitule Ieres ou IIndes vepres en latin
	if (($calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l="<br> ad ";
	elseif ($calendarium['1V'][$jour]) $date_l="<br> ad II ";
	else $date_l = "<br> ad ";
	
	// Gestion intitule Ieres ou IIndes vepres en francais
	if (($calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr="<br> aux ";
	elseif ($calendarium['1V'][$jour]) $date_fr = "<br> aux IIdes ";
	else $date_fr = "<br> aux ";
}


/*
* Gestion du 4e Dimanche de l'Avent
* si c'est le 24/12, prendre toutes les antiennes au 24, rien à modifier
* sinon prendre uniquement l'antienne benedictus ==> recopier le temporal dans le sanctoral
*/
if ($temp['intitule']['latin']=="Dominica IV Adventus") {
	if ($die!="24") {
		$benelat=$propre['benedictus']['latin'];
		$benefr=$propre['benedictus']['francais'];
		$magniflat=$propre['magnificat']['latin'];
		$magniffr=$propre['magnificat']['francais'];
		$propre=$temp;
		$propre['benedictus']['latin']=$benelat;
		$propre['benedictus']['francais']=$benefr;
		$propre['magnificat']['latin']=$magniflat;
		$propre['magnificat']['francais']=$magniffr;
	}
	else {
		$calendarium['priorite'][$jour]++;
	}
}

/*
* Vérification de premieres vepres au temporal - solennités et fetes
* Chargement de $temp avec les valeurs du temporal
* Affectation des valeurs hymne, LB, RB, ... à partir de $temp
*/
$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);

/*print_r("<p> demain : ".$demain."</p>");
print_r("<p> 1V demain : ".$calendarium['1V'][$demain]."</p>");
print_r("<p> priorite jour : ".$calendarium['priorite'][$jour]."</p>");
print_r("<p> priorite demain : ".$calendarium['priorite'][$demain]."</p>");
print_r("<p> intitule demain : ".$calendarium['intitule'][$demain]."</p>");*/
if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])) {
	/*print_r("<p> 1V</p>");*/
	$tempo=null;
	$tempo=$calendarium['temporal'][$demain];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>temporal 1V : ".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
	}
	fclose($fp);
	$propre=null;
	$date_l = "ad I ";
	$date_fr = "aux I&egrave;res ";
	$temp['HYMNUS_vepres']['latin']=$temp['HYMNUS_1V']['latin'];
	$temp['ant7']['latin']=$temp['ant01']['latin'];
	$temp['ant7']['francais']=$temp['ant01']['francais'];
	$temp['ant8']['latin']=$temp['ant02']['latin'];
	$temp['ant8']['francais']=$temp['ant02']['francais'];
	$temp['ant9']['latin']=$temp['ant03']['latin'];
	$temp['ant9']['francais']=$temp['ant03']['francais'];
	$temp['ps7']['latin']=$temp['ps01']['latin'];
	$temp['ps7']['francais']=$temp['ps01']['francais'];
	$temp['ps8']['latin']=$temp['ps02']['latin'];
	$temp['ps8']['francais']=$temp['ps02']['francais'];
	$temp['ps9']['latin']=$temp['ps03']['latin'];
	$temp['ps9']['francais']=$temp['ps03']['francais'];
	$temp['LB_soir']['latin']=$temp['LB_1V']['latin'];
	$temp['RB_soir']['latin']=$temp['RB_1V']['latin'];
	$temp['RB_soir']['francais']=$temp['RB_1V']['francais'];
	$pmagnificat="pmagnificat_".$lettre;
	$magnificat="magnificat_".$lettre;
	if ($temp[$pmagnificat]['latin']) {
		$temp[$magnificat]['latin']=$temp[$pmagnificat]['latin'];
		$temp[$magnificat]['francais']=$temp[$pmagnificat]['francais'];
	}
	else {
		$temp['magnificat']['latin']=$temp['pmagnificat']['latin'];
		$temp['magnificat']['francais']=$temp['pmagnificat']['francais'];
	}
	$temp['preces_soir']['latin']=$temp['preces_1V']['latin'];
	$temp['oratio_soir']['latin']=$temp['oratio_1V']['latin'];
	$temp['oratio_soir']['francais']=$temp['oratio_1V']['francais'];
	if ($temp['intitule']['latin']=="Dominica IV Adventus"){
		$propre['LB_soir']['latin']=$temp['LB_1V']['latin'];
		$propre['RB_soir']['latin']=$temp['RB_1V']['latin'];
		$propre['RB_soir']['francais']=$temp['RB_1V']['francais'];
		$propre['oratio']['latin']=$temp['oratio']['latin'];
		$propre['oratio']['francais']=$temp['oratio']['francais'];
	}
}

/*
 * Chargement du squelette des Laudes dans $lau
 * remplissage de $laudes pour l'affichage de l'office
 *
 */

$row = 0;
$fp = fopen ("offices_r/laudes.csv","r");
$jrdelasemaine--;
while ($data = fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
	$lau[$row]['latin']=$latin;
	$lau[$row]['francais']=$francais;
	$row++;
}
$max=$row;
$laudes="<table>";
for($row=0;$row<$max;$row++){
	$lat=$lau[$row]['latin'];
	$fr=$lau[$row]['francais'];
	$testAlleluia=utf8_encode($lat);
	if(($tem=="Tempus Quadragesimae")&&($testAlleluia=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($testAlleluia=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	
	switch ($lat) {
		case "#JOUR" :
			if ($propre['jour']['latin']) {
				$pr_lat=$propre['jour']['latin'];
				$pr_fr=$propre['jour']['francais'];
			}
			if (!$pr_lat) {
				$pr_lat=$temp['jour']['latin'];
				$pr_fr=$temp['jour']['francais'];
			}
			if($pr_lat){
				$laudes.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
				$laudes.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
				$oratiolat=$propre['oratio']['latin'];
				$oratiofr=$propre['oratio']['francais'];
			}
			if ($propre['intitule']['latin']) {
				$intitule_lat=$propre['intitule']['latin'];
				$intitule_fr=$propre['intitule']['francais'];
			}
			if (!$intitule_lat) {
				$intitule_lat=$temp['intitule']['latin'];
				$intitule_fr=$temp['intitule']['francais'];
			}
			if ($intitule_lat){
				$laudes.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>";
				$laudes.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
				$oratiolat=$propre['oratio']['latin'];
				$oratiofr=$propre['oratio']['francais'];
			}
			if(!$rang_lat) {
				$rang_lat=$propre['rang']['latin'];
				$rang_fr=$propre['rang']['francais'];
			}
			if($rang_lat){
				$laudes.="<tr><td style=\"width: 49%; text-align: center;\"><h3> $rang_lat</h3></td>";
				$laudes.="<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
				$oratiolat=$propre['oratio']['latin'];
				$oratiofr=$propre['oratio']['francais'];
			}
			if (($pr_lat)or($intitule_lat)or($rang_lat)) {
				$laudes.="<tr><td style=\"width: 49%; text-align: center;\"><h2>Ad Laudes matutinas</h2></td>";
				$laudes.="<td style=\"width: 49%; text-align: center;\"><h2>Aux Laudes du matin</h2></td></tr>";
			}
			else {
				$laudes.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] ad Laudes matutinas</h2></td>";
				$laudes.="<td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] aux Laudes du matin</h2></td></tr>";
			}
			break;
		
		case "#HYMNUS" :
			if($propre['HYMNUS_laudes']['latin']) $hymne=$propre['HYMNUS_laudes']['latin'];
			elseif ($temp['HYMNUS_laudes']['latin']) $hymne=$temp['HYMNUS_laudes']['latin'];
			else $hymne=$var['HYMNUS_laudes']['latin'];
			$laudes.= hymne($hymne);
			break;
		
		case "#ANT1*":
			if($propre['ant1']['latin']) {
				$antlat=nl2br($propre['ant1']['latin']);
				$antfr=nl2br($propre['ant1']['francais']);
			}
			elseif ($temp['ant1']['latin']) {
				$antlat=nl2br($temp['ant1']['latin']);
				$antfr=nl2br($temp['ant1']['francais']);
			}
			else {
				$antlat=$var['ant1']['latin'];
				$antfr=$var['ant1']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
						break;
			
		case "#PS1":
			if($propre['ps1']['latin']) $psaume=$propre['ps1']['latin'];
			elseif ($temp['ps1']['latin']) $psaume=$temp['ps1']['latin'];
			elseif($var['ps1']['latin']) $psaume=$var['ps1']['latin'];
			else $psaume=$reference['ps1'];
			$laudes.=psaume($psaume);
			break;
			
		case "#ANT1":
			if($propre['ant1']['latin']) {
				$antlat=nl2br($propre['ant1']['latin']);
				$antfr=nl2br($propre['ant1']['francais']);
			}
			elseif($temp['ant1']['latin']) {
				$antlat=nl2br($temp['ant1']['latin']);
				$antfr=nl2br($temp['ant1']['francais']);
			}
			else {
				$antlat=$var['ant1']['latin'];
				$antfr=$var['ant1']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
			break;
		
		case "#ANT2*":
			if($propre['ant2']['latin']) {
				$antlat=nl2br($propre['ant2']['latin']);
				$antfr=nl2br($propre['ant2']['francais']);
			}
			elseif($temp['ant2']['latin']) {
				$antlat=nl2br($temp['ant2']['latin']);
				$antfr=nl2br($temp['ant2']['francais']);
			}
			else {
				$antlat=$var['ant2']['latin'];
				$antfr=$var['ant2']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
			break;
		
		case "#PS2":
			if($propre['ps2']['latin']) $psaume=$propre['ps2']['latin'];
			elseif($temp['ps2']['latin']) $psaume=$temp['ps2']['latin'];
			elseif($var['ps2']['latin']) $psaume=$var['ps2']['latin'];
			else $psaume=$reference['ps2'];
			$laudes.=psaume($psaume);
			break;
		
		case "#ANT2":
			if($propre['ant2']['latin']) {
				$antlat=nl2br($propre['ant2']['latin']);
				$antfr=nl2br($propre['ant2']['francais']);
			}
			elseif($temp['ant2']['latin']) {
				$antlat=nl2br($temp['ant2']['latin']);
				$antfr=nl2br($temp['ant2']['francais']);
			}
			else {
				$antlat=$var['ant2']['latin'];
				$antfr=$var['ant2']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
			break;
		
		case "#ANT3*":
			if($propre['ant3']['latin']) {
				$antlat=nl2br($propre['ant3']['latin']);
				$antfr=nl2br($propre['ant3']['francais']);
			}
			elseif($temp['ant3']['latin']) {
				$antlat=nl2br($temp['ant3']['latin']);
				$antfr=nl2br($temp['ant3']['francais']);
			}
			else {
				$antlat=$var['ant3']['latin'];
				$antfr=$var['ant3']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>";
			break;
		
		case "#PS3":
			if($propre['ps3']['latin']) $psaume=$propre['ps3']['latin'];
			elseif($temp['ps3']['latin']) $psaume=$temp['ps3']['latin'];
			elseif($var['ps3']['latin']) $psaume=$var['ps3']['latin'];
			else $psaume=$reference['ps3'];
			$laudes.=psaume($psaume);
			break;
		
		case "#ANT3":
			if($propre['ant3']['latin']) {
				$antlat=nl2br($propre['ant3']['latin']);
				$antfr=nl2br($propre['ant3']['francais']);
			}
			elseif($temp['ant3']['latin']) {
				$antlat=nl2br($temp['ant3']['latin']);
				$antfr=nl2br($temp['ant3']['francais']);
			}
			else {
				$antlat=$var['ant3']['latin'];
				$antfr=$var['ant3']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>";
			break;
		
		case "#LB":
			if($propre['LB_matin']['latin']) $LB_matin=$propre['LB_matin']['latin'];
			elseif ($temp['LB_matin']['latin']) $LB_matin=$temp['LB_matin']['latin'];
			else $LB_matin=$var['LB_matin']['latin'];
			$laudes.=lectiobrevis($LB_matin);
			break;
		
		case "#RB":
			if($propre['RB_matin']['latin']) {
				$rblat=nl2br($propre['RB_matin']['latin']);
				$rbfr=nl2br($propre['RB_matin']['francais']);
			}
			elseif($temp['RB_matin']['latin']) {
				$rblat=nl2br($temp['RB_matin']['latin']);
				$rbfr=nl2br($temp['RB_matin']['francais']);
			}
			else {
				$rblat=nl2br($var['RB_matin']['latin']);
				$rbfr=nl2br($var['RB_matin']['francais']);
			}
			$laudes.="<tr><td><h2>Responsorium Breve</h2></td>
					<td><h2>R&eacute;pons bref</h2></td></tr>
	    		<tr><td>$rblat</td><td>$rbfr</td></tr>";
			break;
		
		case "#ANT_BENE":
			$benedictus="benedictus_".$lettre;
			if($propre[$benedictus]['latin']) {
				$benelat=$propre[$benedictus]['latin'];
				$benefr=$propre[$benedictus]['francais'];
			}
			elseif($propre['benedictus']['latin']) {
				$benelat=$propre['benedictus']['latin'];
				$benefr=$propre['benedictus']['francais'];
			}
			elseif ($temp[$benedictus]['latin']) {
				$benelat=$temp[$benedictus]['latin'];
				$benefr=$temp[$benedictus]['francais'];
			}
			elseif ($temp['benedictus']['latin']) {
				$benelat=$temp['benedictus']['latin'];
				$benefr=$temp['benedictus']['francais'];
			}
			else {
				$benelat=$var['benedictus']['latin'];
				$benefr=$var['benedictus']['francais'];
			}
			$laudes.="<tr><td><p><span style=\"color:red\">Ant. </span>$benelat</p></td>
					<td><p><span style=\"color:red\">Ant. </span> $benefr</p></td></tr>";
			break;
		
		case "#BENEDICTUS":
			$laudes.=psaume("benedictus");
			break;
		
		case "#PRECES":
			if($propre['preces_matin']['latin']) $preces=$propre['preces_matin']['latin'];
			elseif($temp['preces_matin']['latin']) $preces=$temp['preces_matin']['latin'];
			else $preces=$var['preces_matin']['latin'];
			$laudes.=preces($preces);
			break;
		
		case "#PATER":
			$laudes.=psaume("pater");
			break;
		
		case "#ORATIO":
			if($propre['oratio']['latin']) {
				$oratiolat=$propre['oratio']['latin'];
				$oratiofr=$propre['oratio']['francais'];
			}
			elseif($temp['oratio']['latin']) {
				$oratiolat=$temp['oratio']['latin'];
				$oratiofr=$temp['oratio']['francais'];
			}
			elseif ($oratiolat=$var['oratio_laudes']['latin']) {
				$oratiolat=$var['oratio_laudes']['latin'];
				$oratiofr=$var['oratio_laudes']['francais'];
			}
			elseif ($oratiolat=$var['oratio']['latin']) {
				$oratiolat=$var['oratio']['latin'];
				$oratiofr=$var['oratio']['francais'];
			}
			if ((substr($oratiolat,-6))=="minum.") {
				$oratiolat=str_replace(substr($oratiolat,-13), " Per D&oacute;minum nostrum Iesum Christum, F&iacute;lium tuum, qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
				$oratiofr.=" Par notre Seigneur J&eacute;sus-Christ, ton Fils, qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
			}
			if ((substr($oratiolat,-11))==" Qui tecum.") {
				$oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
				$oratiofr.=" Lui qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
			}
			if ((substr($oratiolat,-11))==" Qui vivis.") {
				$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
				$oratiofr.=" Toi qui vis et r&egrave;gnes avec Dieu le P&egrave;re dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
			}
			$laudes.="<tr><td>$oratiolat</td><td>$oratiofr</td></tr>";
			break;
		
		case "Ite in pace. ":
			if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")) {
				$lat="Ite in pace, allel&uacute;ia, allel&uacute;ia.";
				$fr="Allez en paix, all&eacute;luia, all&eacute;luia.";
				$laudes.="<tr><td>$lat</td><td>$fr</td></tr>";
			}
			else $laudes.="<tr><td>$lat</td><td>$fr</td></tr>";
			break;
		
		case "R/. Deo gr�tias.":
			if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")) {
				$lat="R/. Deo gr&aacute;tias, allel&uacute;ia, allel&uacute;ia.";
				$fr="R/. Rendons gr&acirc;ces &agrave; Dieu, all&eacute;luia, all&eacute;luia.";
				$laudes.="<tr><td>$lat</td><td>$fr</td></tr>";
			}
			else $laudes.="<tr><td>$lat</td><td>$fr</td></tr>";
			break;
		
		default:
			$laudes.="<tr><td>$lat</td><td>$fr</td></tr>";
			break;
	}
}
$laudes.="</table>";
$laudes= rougis_verset ($laudes);

return $laudes;
}

?>
