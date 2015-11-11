<?php

include ("fonction_messe.php");


function messe($jour,$calendarium,$my) {

/*
if(!$my->email) {
	$messe="<center><i>Le textes des offices latin/fran�ais ne sont disponibles que pour les utilisateurs enregistr�s.</i></center>";
	return $messe;
}*/

$mod=$_GET['mod'];
/*if ($mod !="debug") {
	$messe= "Cette fonction n'est pas encore disponible. Merci de votre patience. Vous souhaitez nous aider � mettre ce contenu en ligne ? Contactez-nous : <a href=\"mailto:liturgia@scholasaintmaur.net\">liturgia@scholasaintmaur.net</a>";
	return $messe;
}*/

$jours_l = array("Dominica", "Feria secunda","Feria tertia","Feria quarta","Feria quinta","Feria sexta", "Sabbato");
$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
$seizedec=mktime(12,0,0,12,16,$anno);

$valeur_lettre=intval((($anno/3)-intval($anno/3))*3);
//print_r($valeur_lettre."<br>");




$jrdelasemaine=date("w",$day);
$date_fr=$jours_fr[$jrdelasemaine].", � la ";
$date_l=$jours_l[$jrdelasemaine].", ad ";
$datelatin=$jours_l[$jrdelasemaine];
$semainelatin=$calendarium['hebdomada'][$jour];

$fp = fopen ("calendrier/liturgia/jours.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
    $id=$data[0];$latin=$data[1];$francais=$data[2];
    $jo[$id]['latin']=$latin;
    $jo[$id]['francais']=$francais;
    $row++;
}
fclose($fp);

$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];

$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);
$prop=$mense.$die;
	

$var=null;
$tem=$calendarium['tempus'][$jour];


switch ($tem){
	case "Tempus per annum":
		$psautier="perannum";
		$spsautier="_".$calendarium['hebdomada_psalterium'][$jour];
	break; //Fin cas per annum
	
	/*case "Tempus Quadragesimae":
		$psautier="quadragesimae";
		switch($calendarium['hebdomada'][$jour]){
			case "Hebdomada I Quadragesimae":
				$spsautier="_1";
			break;
			case "Hebdomada II Quadragesimae":
				$spsautier="_2";
			break;
			case "Hebdomada III Quadragesimae":
				$spsautier="_3";
			break;
			case "Hebdomada IV Quadragesimae":
				$spsautier="_4";
			break;
			case "Hebdomada V Quadragesimae":
				$spsautier="_5";
			break;
			case "Dies post Cineres":
			default:
				$spsautier="_0";
			break;
		}
	break; //Fin cas Car�me
	
	case "Tempus passionis":
		$psautier="hebdomada_sancta";
		$spsautier=null;
	break; //Fin cas semaine sainte
	
	case "Tempus Paschale":
		$psautier="pascha";
		switch($calendarium['hebdomada'][$jour]){
			case "Infra octavam paschae":
				$spsautier="_1";
			break;
			case "Hebdomada II Paschae":
				$spsautier="_2";
			break;
			case "Hebdomada III Paschae":
				$spsautier="_3";
			break;
			case "Hebdomada IV Paschae":
				$spsautier="_4";
			break;
			case "Hebdomada V Paschae":
				$spsautier="_5";
			break;
			case "Hebdomada VI Paschae":
				$spsautier="_6";
			break;
			case "Hebdomada VII Paschae":
				$spsautier="_7";
			break;
			case " ":
				$spsautier="_8";
			break;
		}
	break;*/ //Fin cas p�ques
	
	case "Tempus Adventus":
		$valeur_lettre++;
		$psautier="adven";
	break; //Fin cas advent
	
	case "Tempus Nativitatis":
		$valeur_lettre++;
		$psautier="noel";
	break; //Fin cas no�l
	
	default:
		$messe="<br><i>Cet office n'est pas encore compl�tement disponible. Merci de bien vouloir patienter.</i>";
		return $messe;
	break; //Fin default
}

//print_r("Priorit� : ".$calendarium['priorite'][$jour]);
	
//if(($calendarium['priorite'][$jour]>6)&&($datelatin!="Dominica")){
if(($calendarium['priorite'][$jour]>6)&&($datelatin!="Dominica")&&($prop!="1224")){
	$messe="<br><i>Cet office n'est pas encore compl�tement disponible pour les f�ries. Merci de bien vouloir patienter.</i>";
	return $messe;
}

//d�finition des variables
switch($valeur_lettre){
	case 1:
		$lettre_annee="_A";
	break;
	case 2:
		$lettre_annee="_B";
	break;
	case 0:
	case 3:
		$lettre_annee="_C";
	break;
}//print_r($lettre_annee."<br>");

$val_introit="ant_introit".$lettre_annee;
$val_graduel="graduel".$lettre_annee;
$val_acclam="acclamation".$lettre_annee;
$val_off="ant_off".$lettre_annee;
$val_comm="ant_com".$lettre_annee;
$val_LM1="LM_1".$lettre_annee;
$val_LM2="LM_2".$lettre_annee;
$val_LM3="LM_3".$lettre_annee;

$introit=null;
$graduel=null;
$acclam=null;
$sequence=null;
$offertoire=null;
$communion=null;

$collecte_lat=null;
$secrete_lat=null;
$postcommunio_lat=null;
$bene_lat="";
$ben_simplex=false;
$ora_superpop_lat=null;
$praefatio_lat=null;

$collecte_fr=null;
$secrete_fr=null;
$postcommunio_fr=null;
$bene_fr=null;
$ora_superpop_fr=null;
$praefatio_fr=null;


//Lecture du fichier propre au jour courant selon le temporal
if (file_exists("calendrier/liturgia/psautier/".$psautier.$spsautier.$jrdelasemaine.".csv")) {
	$fp = fopen ("calendrier/liturgia/psautier/".$psautier.$spsautier.$jrdelasemaine.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$var[$id]['latin']=$latin;
		$var[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
}


//Lecture du fichier de r�partition des lectures
/*
colonne 0 (A) : semaine de l'ann�e
colonne 1 (B) : jour de la semaine
colonne 2 (C) : intro�t
colonne 3 (D) : collecte
colonne 4 (E) : 1e lecture
colonne 5 (F) : graduel
colonne 6 (G) : 2e lecture
colonne 7 (H) : acclamation
colonne 8 (I) : sequence
colonne 9 (J) : evangile
colonne 10 (K) : offertoire
colonne 11 (L) : secrete
colonne 12 (M) : communion
colonne 13 (N) : post communion
*/
$fp = fopen ("calendrier/liturgia/messe/lectio/lectio_missa.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	if ($row=0) $row++;
	else {
    $semaine=$data[0];$feria=$data[1];$lect1=$data[2];$lect2=$data[3];$lect3=$data[4];
    $lecture1[$semaine][$feria]=$lect1; 
	if($lect2)$lecture2[$semaine][$feria]=$lect2;
    $lecture3[$semaine][$feria]=$lect3;
	$int[$semaine][$feria]=$data[2];
	$grad[$semaine][$feria]=$data[5];
	$accl[$semaine][$feria]=$data[7];
	$seq[$semaine][$feria]=$data[8];
	$off[$semaine][$feria]=$data[10];
	$comm[$semaine][$feria]=$data[12];

	$col_lat[$semaine][$feria]=$data[3];
	$sec_lat[$semaine][$feria]=$data[11];
	$post_lat[$semaine][$feria]=$data[13];
	/*$bene_lat=$temp['ben_sol']['latin'];
	$ora_superpop_lat=$temp['ora_sup']['latin'];
	$praefatio_lat=$temp['praefatio']['latin'];

	$collecte_fr=$temp['ora_coll']['francais'];
	$secrete_fr=$temp['ora_secr']['francais'];
	$postcommunio_fr=$temp['ora_post']['francais'];
	$bene_fr=$temp['ben_sol']['francais'];
	$ora_superpop_fr=$temp['ora_sup']['francais'];
	$praefatio_fr=$temp['praefatio']['francais'];*/
	$row++;
	}
}
fclose($fp);
$lectio1=$lecture1[$semainelatin][$datelatin];
$lectio2=$lecture2[$semainelatin][$datelatin];
$lectio3=$lecture3[$semainelatin][$datelatin];
$introit=$int[$semainelatin][$datelatin];
$graduel=$grad[$semainelatin][$datelatin];
$acclam=$accl[$semainelatin][$datelatin];
$sequence=$seq[$semainelatin][$datelatin];
$offertoire=$off[$semainelatin][$datelatin];
$communion=$comm[$semainelatin][$datelatin];
$collecte_lat=$col_lat[$semainelatin][$datelatin];
$secrete_lat=$sec_lat[$semainelatin][$datelatin];
$postcommunio_lat=$post_lat[$semainelatin][$datelatin];


//print_r("test : ".$calendarium['temporal'][$jour]." (temporal) ?=? ".$calendarium['intitule'][$jour]." (intitule)");

////////////////////////
//gestion du temporal//
////////////////////////
//if ($calendarium['temporal'][$jour]==$calendarium['intitule'][$jour]){
if (($calendarium['temporal'][$jour]==$calendarium['intitule'][$jour])&&($prop!="1224")){
	//print_r("<br> Entrer dans la boucle temporal");
$tempo=$calendarium['temporal'][$jour];
$fp = fopen ("calendrier/liturgia/messe/temporal/".$calendarium['hebdomada'][$jour].".csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
   	$id=$data[0];
   	$temp[$id]['latin']=$data[1];
    $temp[$id]['francais']=$data[2];
   	$row++;
}
fclose($fp);
$rang_lat=$temp['rang']['latin'];
$rang_fr=$temp['rang']['francais'];
$intitule_lat=$temp['intitule']['latin'];
$intitule_fr=$temp['intitule']['francais'];
$introit=$temp[$val_introit]['latin'];
$graduel=$temp[$val_graduel]['latin'];
$acclam=$temp[$val_acclam]['latin'];
$sequence=$temp['sequence']['latin'];
$offertoire=$temp[$val_off]['latin'];
$communion=$temp[$val_comm]['latin'];
$lgn=$temp['praefatio']['latin'];

//Lectures du temporal
if($calendarium['temporal'][$jour]) {
	$fp = fopen ("calendrier/liturgia/messe/lectio/".$tempo.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	   	$id=$data[0];
	   	$temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	   	$row++;
	}
	fclose($fp);
	
	$rang_lat=$temp['rang']['latin'];
	$rang_fr=$temp['rang']['francais'];
	$intitule_lat=$temp['intitule']['latin'];
	$intitule_fr=$temp['intitule']['francais'];

	$collecte_lat=$temp['ora_coll']['latin'];
	$secrete_lat=$temp['ora_secr']['latin'];
	$postcommunio_lat=$temp['ora_post']['latin'];
	$bene_lat=$temp['ben_sol']['latin'];
	if ($bene_lat=="") $ben_simplex=true;
	$ora_superpop_lat=$temp['ora_sup']['latin'];

	$collecte_fr=$temp['ora_coll']['francais'];
	$secrete_fr=$temp['ora_secr']['francais'];
	$postcommunio_fr=$temp['ora_post']['francais'];
	$bene_fr=$temp['ben_sol']['francais'];
	$ora_superpop_fr=$temp['ora_sup']['francais'];

	$lectio1=$temp[$val_LM1]['latin'];
	$lectio2=$temp[$val_LM2]['latin'];
	$lectio3=$temp[$val_LM3]['latin'];
}
}
////////////////////////
//Gestion du sanctoral//
////////////////////////
//elseif($calendarium['priorite'][$jour]<=7)or($prop=="1224") {
elseif(($calendarium['priorite'][$jour]<=7)or($prop=="1224")) {
	//print_r("<br> Entrer dans la boucle sanctoral");
	if (file_exists("calendrier/liturgia/messe/sanctoral/".$prop.".csv")) {
		$fp = fopen ("calendrier/liturgia/messe/sanctoral/".$prop.".csv","r");}
    else {
    	$fp = fopen ("calendrier/liturgia/messe/sanctoral/".$calendarium['intitule'][$jour].".csv","r");}
    	
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $propre[$id]['latin']=$data[1];
	    $propre[$id]['francais']=$data[2];
	    $row++;
	}
	fclose($fp);
	
	$rang_lat=$propre['rang']['latin'];//print_r("rang : ".$rang_lat."<br>");
	$rang_fr=$propre['rang']['francais'];
	$intitule_lat=$propre['intitule']['latin'];//print_r("intitule : ".$intitule_lat."<br>");
	$intitule_fr=$propre['intitule']['francais'];
	    	
	$introit=$propre[$val_introit]['latin'];//print_r($val_introit." : ".$propre[$val_introit]['latin']."<br>");
	$graduel=$propre[$val_graduel]['latin'];//print_r($val_graduel." : ".$graduel."<br>");
	$acclam=$propre[$val_acclam]['latin'];//print_r($val_acclam." : ".$acclam."<br>");
	$sequence=$propre['sequence']['latin'];//print_r("sequence : ".$sequence."<br>");
	$offertoire=$propre[$val_off]['latin'];//print_r($val_off." : ".$offertoire."<br>");
	$communion=$propre[$val_comm]['latin'];//print_r($val_comm." : ".$communion."<br>");

	$collecte_lat=$propre['ora_coll']['latin'];//print_r("ora_coll : ".$collecte_lat."<br>");
	$secrete_lat=$propre['ora_secr']['latin'];//print_r("ora_secr : ".$secrete_lat."<br>");
	$postcommunio_lat=$propre['ora_post']['latin'];//print_r("ora_post : ".$postcommunio_lat."<br>");
	$bene_lat=$propre['ben_sol']['latin'];//print_r("ben_sol : ".$bene_lat."<br>");
	if ($bene_lat=="") $ben_simplex=true;
	$ora_superpop_lat=$propre['ora_sup']['latin'];//print_r("ora_sup : ".$ora_superpop_lat."<br>");
	$praefatio_lat=$propre['praefatio']['latin'];//print_r("praefatio : ".$praefatio_lat."<br>");

	$collecte_fr=$propre['ora_coll']['francais'];
	$secrete_fr=$propre['ora_secr']['francais'];
	$postcommunio_fr=$propre['ora_post']['francais'];
	$bene_fr=$propre['ben_sol']['francais'];
	$ora_superpop_fr=$propre['ora_sup']['francais'];
	$praefatio_fr=$propre['praefatio']['francais'];
	
	$lectio1=$propre[$val_LM1]['latin'];//print_r($val_LM1." : ".$lectio1."<br>");
	$lectio2=$propre[$val_LM2]['latin'];//print_r($val_LM2." : ".$lectio2."<br>");
	$lectio3=$propre[$val_LM3]['latin'];//print_r($val_LM3." : ".$lectio3."<br>");
}


//Lecture du fichier des pr�faces
//$lgn=0;
$fpref=fopen("calendrier/liturgia/messe/pref_".$psautier.".csv","r");
while ($data_pref=fgetcsv($fpref, 10000,";")){
	$lignum=$data_pref[0];$lgn_lat=$data_pref[1];$lgn_fr=$data_pref[2];
	$preface[$lignum]['latin']=$lgn_lat;
	$preface[$lignum]['francais']=$lgn_fr;
}
/*switch ($datelatin){
	case "Dominica":
		switch ($calendarium['hebdomada_psalterium'][$jour]){
			case "1":
			case "3": $lgn=1;
			break;
			case "2":
			case "4": $lgn=8;
			break;
		} 
	break;
	case "Feria secunda":
		$lgn=2;
	break;
	case "Feria tertia":
		$lgn=3;
	break;
	case "Feria quarta":
		$lgn=4;
	break;
	case "Feria quinta":
		$lgn=5;
	break;
	case "Feria sexta":
		$lgn=6;
	break;
	case "Sabbato":
		$lgn=7;
	break;
}*/

//Lecture du fichier des pri�res Eucharistiques
$ligne=0;
//$fprex=fopen("calendrier/liturgia/messe/prex_eucharistia.csv","r");
$fprex=fopen("calendrier/liturgia/messe/prex_I.csv","r");
while ($data_prex = fgetcsv ($fprex, 10000,";")) {
    $prex1[$ligne]['latin']=$data_prex[0];$prex1[$ligne]['fr']=$data_prex[1];
	$prex2[$ligne]['latin']=$data_prex[2];$prex2[$ligne]['fr']=$data_prex[3];
	$prex3[$ligne]['latin']=$data_prex[4];$prex3[$ligne]['fr']=$data_prex[5];
	$prex4[$ligne]['latin']=$data_prex[6];$prex4[$ligne]['fr']=$data_prex[7];
    $ligne++;
}
fclose($fprex);

//Ouverture du fichier squelette de la Messe
$row = 0;
$fp = fopen ("calendrier/liturgia/messe/messe.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
    $latin=$data[0];$francais=$data[1];
    $comp[$row]['latin']=$latin;
    $comp[$row]['francais']=$francais;
    $row++;
}
fclose($fp);

$max=$row;
$messe="<table bgcolor=#FEFEFE>";

for($row=0;$row<$max;$row++){
    $lat=$comp[$row]['latin'];
    $fr=$comp[$row]['francais'];
    if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
    if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	switch ($lat){
		case "#JOUR" :
		    if($intitule_lat){
				$messe.="<tr><td width=49%><center><b><font color=red>$intitule_lat</font></b></center></td><td width=49%><center><b><font color=red>$intitule_fr</font></b></center></td></tr>";
				$messe.="<tr><td width=49%><center><font color=red>$rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
				$messe.="<tr><td width=49%><center><font color=red>Ad Missam</font></center></td><td width=49%><center><font color=red>A la Messe</font></center></td></tr>";
			}
			else {
				$messe.="<tr><td width=49%><center><font color=red><b>$date_l Missam</b></font></center></td>";
				$messe.="<td width=49%><b><center><font color=red><b>$date_fr Messe</b></font></center></td></tr>";
				$messe.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
			}
		break; //fin du cas #JOUR
		
		case "#ANT_INTROIT":
			if($introit) $messe.=propre($introit);
		break;
		
		case "#ACCUEIL":
			$messe.="<tr><td width=49%><b>Gr�tia D�mini nostri Iesu Christi, et c�ritas Dei, et communic�tio Sancti Sp�ritus sit cum �mnibus vobis.</b></td><td width=49%><b>La gr�ce de notre Seigneur J�sus-Christ, et la charit� de Dieu, et la communion de l'Esprit Saint soit avec vous tous.</b></td></tr>";
			$messe.="<tr><td width=49%>Et cum sp�ritu tuo.</td><td width=49%>Et avec votre esprit.</td></tr>";
			$messe.="
			<SCRIPT LANGUAGE=\"JavaScript\">
				function accueil2() {
					// ouvre une fenetre sans barre d'etat, ni d'ascenceur
					w=open(\"\",'popup','width=500,height=150,toolbar=no,scrollbars=auto,resizable=no');
					w.document.write(\"<TITLE>Ad Missa, Salutatio Populi formula 2</TITLE>\");
					w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
					w.document.write(\"<tr><td width=49%><center><font color=red>Salutatio populi formula 2</font></center></td><td width=49%><center><font color=red>Salutation du peuple 2e formule</font></center></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Gr�tia vobis et pax a Deo Patre nostro et D�mino Iesu Christo.</b></td><td width=49%><b>Que la gr�ce de Dieu le P�re et et la paix du Seigneur J�sus Christ soit avec vous.<b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Et cum sp�ritu tuo.</td><td width=49%>Et avec votre esprit.</td></tr>\");
					w.document.write(\"</table></center></BODY>\");
					w.document.close();
				}
			</SCRIPT>";
			$messe.="
			<SCRIPT LANGUAGE=\"JavaScript\">
				function accueil3() {
					// ouvre une fenetre sans barre d'etat, ni d'ascenceur
					w=open(\"\",'popup','width=500,height=100,toolbar=no,scrollbars=auto,resizable=no');
					w.document.write(\"<TITLE>Ad Missa, Salutatio Populi formula 3</TITLE>\");
					w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
					w.document.write(\"<tr><td width=49%><center><font color=red>Salutatio populi formula 2</font></center></td><td width=49%><center><font color=red>Salutation au peuple 3e formule</font></center></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>D�minus vob�scum.</b></td><td width=49%><b>Le Seigneur soit avec vous.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Et cum sp�ritu tuo.</td><td width=49%>Et avec votre esprit.</td></tr>\");
					w.document.write(\"</table></center></BODY>\");
					w.document.close();
				}
			</SCRIPT>";
			$messe.="
			<SCRIPT LANGUAGE=\"JavaScript\">
				function accueilE() {
					// ouvre une fenetre sans barre d'etat, ni d'ascenceur
					w=open(\"\",'popup','width=500,height=100,toolbar=no,scrollbars=auto,resizable=no');
					w.document.write(\"<TITLE>Ad Missam, Salutatio Populi formula episcopalis</TITLE>\");
					w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
					w.document.write(\"<tr><td width=49%><center><font color=red>Salutatio populi formula episcopalis</font></center></td><td width=49%><center><font color=red>Salutation au peuple formule �piscopale</font></center></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Pax vobis.</b></td><td width=49%><b>Paix � vous.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Et cum sp�ritu tuo.</td><td width=49%>Et avec votre esprit.</td></tr>\");
					w.document.write(\"</table></center></BODY>\");
					w.document.close();
				}
			</SCRIPT>";
			$messe.="<tr><td width=49%><center><A HREF='javascript:accueil2()'>formula 2</A>, <A HREF='javascript:accueil3()'>formula 3</A></center></td>
					<td width=49%><center><A HREF='javascript:accueil2()'>2nde formule</A>, <A HREF='javascript:accueil3()'>3e formule</A></center></td></tr>";
			$messe.="<tr><td width=49%><center><font color=red><A HREF='javascript:accueilE()'>formula episcopalis</A></font></center></td><td width=49%><center><font color=red><A HREF='javascript:accueilE()'>formule Episcopale</A></font></center></td></tr>";
		break;//Fin du cas #ACCUEIL
		
		case "#PAENI":
			$messe.="<tr><td width=49%><b>Fratres, agnosc�mus pecc�ta nostra, ut apti simus ad sacra myst�ria celebr�nda.</b></td><td width=49%><b>Fr�res, reconnaissons notre p�ch�, afin que nous soyons aptes � la c�l�bration des saints myst�res.<b></td></tr>";
			$messe.="<tr><td width=49%><font color=red size=-1>Omnes dicens :</font></td><td width=49%><font color=red size=-1>Tous disent :</font></td></tr>";
			$messe.="
			<tr><td width=49%>Conf�teor Deo omnipot�nti et vobis, fratres, quia pecc�vi nimis cogitati�ne, verbo, �pere et omissi�ne: 
			<font color=red size=-1>et, percutientes sibi pectus, dicunt: </font>mea culpa, mea culpa, mea m�xima culpa. 
			<font color=red size=-1>Deinde prosequuntur:</font>
			Ideo precor be�tam Mar�am semper V�rginem, omnes Angelos et Sanctos, et vos, fratres, or�re pro me ad D�minum Deum nostrum.</td>
			<td width=49%>Je confesse � Dieu tout puissant et � vous, mes fr�res, car j'ai beaucoup p�ch� par pens�es, par paroles, par actions et par omissions : 
			<font color=red size=-1>et, en se frappant la poitrine, on dit :</font> c'est ma faute, c'est ma faute, c'est ma tr�s grande faute. 
			<font color=red size=-1>Ensuite, on continue : </font>
			C'est pourquoi je supplie la bienheureuse Marie toujours Vierge, tous les Anges et les Saints, et vous fr�res, de prier pour moi le Seigneur notre Dieu.</td></tr>";
			$messe.="
			<SCRIPT LANGUAGE=\"JavaScript\">
				function paeni2() {
					// ouvre une fenetre sans barre d'etat, ni d'ascenceur
					w=open(\"\",'popup','width=500,height=250,toolbar=no,scrollbars=auto,resizable=no');
					w.document.write(\"<TITLE>Ad Missa, Actus paenitentialis formula 2</TITLE>\");
					w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
					w.document.write(\"<tr><td width=49%><center><font color=red>Actus paenitentialis formula 2</font></center></td><td width=49%><center><font color=red>Acte p�nitentiel 2e formule</font></center></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Fratres, agnosc�mus pecc�ta nostra, ut apti simus ad sacra myst�ria celebr�nda.</b></td><td width=49%><b>Fr�res, reconnaissons notre p�ch�, afin que nous soyons aptes � la c�l�bration des saints myst�res.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Miser�re nostri, D�mine.</b></td><td width=49%><b>Aie piti� de nous, Seigneur.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Quia pecc�vimus tibi.</td><td width=49%>Car nous avons p�ch� contre toi.</td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Ost�nde nobis, D�mine, miseric�rdiam tuam.</b></td><td width=49%><b>Fais-nous voir, Seigneur, ta bont�.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Et salut�re tuum da nobis.</td><td width=49%>Et accorde-nous ton salut.</td></tr>\");
					w.document.write(\"</table></center></BODY>\");
					w.document.close();
				}
			</SCRIPT>";
			$messe.="
			<SCRIPT LANGUAGE=\"JavaScript\">
				function paeni3() {
					// ouvre une fenetre sans barre d'etat, ni d'ascenceur
					w=open(\"\",'popup','width=500,height=350,toolbar=no,scrollbars=no,resizable=no');
					w.document.write(\"<TITLE>Ad Missa, Actus paenitentialis formula 3</TITLE>\");
					w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
					w.document.write(\"<tr><td width=49%><center><font color=red>Actus paenitentialis formula 3</font></center></td><td width=49%><center><font color=red>Acte p�nitentiel 3e forme</font></center></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Fratres, agnosc�mus pecc�ta nostra, ut apti simus ad sacra myst�ria celebr�nda.</b></td><td width=49%><b>Fr�res, reconnaissons notre p�ch�, afin que nous soyons aptes � la c�l�bration des saints myst�res.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Qui missus es san�re contr�tos corde: Kyrie, el�ison.</b></td><td width=49%><b>Toi qui a �t� envoy� pour gu�rir les coeurs contris : Seigneur, aie piti�.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Kyrie, el�ison.</td><td width=49%>Seigneur, aie piti�.</td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Qui peccat�res voc�re ven�sti: Christe, el�ison.</b></td><td width=49%><b>Toi qui es venu appel� les p�cheurs : O Christ, aie piti�.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Christe, el�ison.</td><td width=49%>O Christ, aie piti�.</td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Qui ad d�xteram Patris sedes, ad interpell�ndum pro nobis: Kyrie, el�ison.</b></td><td width=49%><b>Toi qui es assis la doite du P�re, pour L'interpeller pour nous : Seigneur, aie piti�.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Kyrie, el�ison.</td><td width=49%> Seigneur, aie piti�.</td></tr>\");
					w.document.write(\"</table></center></BODY>\");
					w.document.close();
				}
			</SCRIPT>";
			$messe.="<tr><td width=49%><center><A HREF='javascript:paeni2()'>formula 2</A>, <A HREF='javascript:paeni3()'>formula 3</A></center></td>
					<td width=49%><center><A HREF='javascript:paeni2()'>2nde formule</A>, <A HREF='javascript:paeni3()'>3e formule</A></center></td></tr>";
		break; //Fin du Cas Paeni
		
		case "#HY_GLORIA":
			if(($calendarium['tempus'][$jour]!="Tempus Adventus")&&($calendarium['tempus'][$jour]!="Tempus Quadragesimae")&&($calendarium['priorite'][$jour]<=7)){
				$messe.=propre(hy_gloria);
			}
		break;
		
		case "#ORA_COLLECTE":
			$messe.=oraison($collecte_lat,$collecte_fr);
		break;
		
		case "#LECTIO1":
				$messe.="<tr><td width=49%><center><font color=red size=-1>Lectio 1</font></center></td><td width=49%><center><font color=red size=-1>1�re Lecture</font></center></td></tr>";
				if($lectio1) $messe.=lecture_1($lectio1);
				$messe.="<tr><td width=49%>Verbum Domini</td><td width=49%>Parole du Seigneur</td></tr>";
				$messe.="<tr><td width=49%>R/. Deo gratias</td><td width=49%>R/. Nous rendons gr�ce � Dieu</td></tr>";
		break;
		
		case "#GRADUALE":
			if($graduel) $messe.=propre($graduel);
		break;
		
		case "#LECTIO2":
			if($lectio2){
				$messe.="<tr><td width=49%><center><font color=red size=-1>Lectio 2</font></center></td><td width=49%><center><font color=red size=-1>2e Lecture</font></center></td></tr>";
				$messe.=lecture_2($lectio2);
				$messe.="<tr><td width=49%>Verbum Domini</td><td width=49%>Parole du Seigneur</td></tr>";
				$messe.="<tr><td width=49%>R/. Deo gratias</td><td width=49%>R/. Nous rendons gr�ce � Dieu</td></tr>";
			}
		break;
		
		case "#TRACTUS":
			if($sequence)$messe.=propre($sequence);
			if($acclam) $messe.=propre($acclam);
		break;
		
		case "#LECTIO3":
				$messe.="<tr><td width=49%><center><font color=red size=-1>Sancti Envangeli</font></center></td><td width=49%><center><font color=red size=-1>Saint Evangile</font></center></td></tr>";
				$messe.="<tr><td width=49%>Diaconus: <b>D�minus vob�scum.</b></td><td width=49%>le Diacre : <b>Le Seigneur soit avec vous.</b></td></tr>";
				$messe.="<tr><td width=49%>R/. Et cum sp�ritu tuo.</td><td width=49%>R/. Et avec votre esprit.</td></tr>";
				switch (substr($lectio3, 0, 5)){
					case "LM_Lc":
						$annonce['latin']="L�ctio sancti Evang�lii sec�ndum Lucam.";
						$annonce['francais']="Lecture du saint Evangile selon Luc.";
					break;
					case "LM_Mt":
						$annonce['latin']="L�ctio sancti Evang�lii sec�ndum Matth�um.";
						$annonce['francais']="Lecture du saint Evangile selon Matthieu.";
					break;
					case "LM_Mc":
						$annonce['latin']="L�ctio sancti Evang�lii sec�ndum Marcum.";
						$annonce['francais']="Lecture du saint Evangile selon Marc.";
					break;
					case "LM_Jn":
						$annonce['latin']="L�ctio sancti Evang�lii sec�ndum Io�nnem.";
						$annonce['francais']="Lecture du saint Evangile selon Jean.";
					break;
					default:
						$annonce['latin']="L�ctio sancti Evang�lii.";
						$annonce['francais']="Lecture du saint Evangile.";
					break;
				}
				$messe.="<tr><td width=49%>Diaconus: <b>".$annonce['latin']."</b></td><td width=49%>le Diacre : <b>".$annonce['francais']."</b></td></tr>";
				//$messe.="<tr><td width=49%>V/. L�ctio sancti Evang�lii sec�ndum N.</td><td width=49%>V/. Lecture du saint Evangile selon N.</td></tr>";
				$messe.="<tr><td width=49%>R/. Gl�ria tibi, D�mine.</td><td width=49%>R/. Gloire � toi, Seigneur.</td></tr>";
				//if($lectio3)$messe.=evangile($lectio3);
				if($lectio3)$messe.=evangile($lectio3);
				$messe.="<tr><td width=49%>Diaconus: <b>Verbum D�mini.</b></td><td width=49%>le Diacre : <b>Parole du Seigneur.</b></td></tr>";
				$messe.="<tr><td width=49%>R/. Laus tibi, Christe.</td><td width=49%>R/. Louange � toi, � Christ.</td></tr>";
		break;
		
		case "#CREDO":
			if($calendarium['priorite'][$jour]<=6){
				$messe.=propre(credo);
			}
		break;
		
		case "#ORA_FIDEL":
			$preces="";
			if($calendarium['priorite'][$jour]<=6){
				if($propre['preces_matin']['latin']) $preces=$propre['preces_matin']['latin'];
		    	if($temp['preces_matin']['latin']) $preces=$temp['preces_matin']['latin'];
	    		else $preces=$var['preces_matin']['latin'];
	    		if ($preces!=""){
					$messe.="<tr><td id=\"colgauche\"><center><font color=red>Oratio Universalis seu Oratio fidelium</font></center></td><td id=\"coldroite\"><center><font color=red>Pri�re Universelle ou Pri�re des fid�les</font></center></td></tr>";
					$messe.=preces($preces);
	    		}
			}
		break;
		
		case "#ANT_OFF":
			if($offertoire) $messe.=propre($offertoire);
		break;
		
		case "#ORA_SECRETE":
			$messe.=oraison($secrete_lat,$secrete_fr);
		break;
		
		case "#PREF":
			if(!$lgn)$lgn=preface($calendarium,$jour,$datelatin);
			//print_r("lgn : ".$lgn." tempo : ".$tempo." propre : ".$propre);
			/*if($preface[$propre]['latin'])$messe.="<tr><td id=\"colgauche\">".$preface[$propre]['latin']."</td><td id=\"coldroite\">".$preface[$propre]['francais']."</td></tr>";
			elseif($preface[$tempo]['latin'])$messe.="<tr><td id=\"colgauche\">".$preface[$tempo]['latin']."</td><td id=\"coldroite\">".$preface[$tempo]['francais']."</td></tr>";
			else*/if($preface[$lgn]['latin'])$messe.="<tr><td id=\"colgauche\"><b>".$preface[$lgn]['latin']."</b></td><td id=\"coldroite\"><b>".$preface[$lgn]['francais']."</b></td></tr>";
			else $messe.="<tr><td id=\"colgauche\"><b>".$preface['1']['latin']."</b></td><td id=\"coldroite\"><b>".$preface['1']['francais']."</b></td></tr>";
		break;
		
		case "#CANON":
			//$messe.="<tr><td id=\"colgauche\">$lat $lat</td><td id=\"coldroite\">$fr $fr</td></tr>";
			$iterateur=0;
			while($iterateur<=$ligne){
				$lat=$prex1[$iterateur]['latin'];
				$fr=$prex1[$iterateur]['fr'];
				switch($lat){
					case"#ANAMNESE":
						$messe.="<tr><td width=49%><b>Myst�rium f�dei.</b></td><td width=49%><b>Myst�re de la Foi.</b></td></tr>";
						$messe.="<tr><td width=49%>R/. Mortem tuam annunti�mus, D�mine, et tuam resurrecti�nem confit�mur, donec v�nias.</td><td width=49%>R/. Nous annon�ons ta mort, Seigneur, et nous confessons ta r�surection jusqu'� ce que tu viennes.</td></tr>";
						$messe.="
						<SCRIPT LANGUAGE=\"JavaScript\">
							function anamnese2() {
								// ouvre une fenetre sans barre d'etat, ni d'ascenceur
								w=open(\"\",'popup','width=500,height=200,toolbar=no,scrollbars=auto,resizable=no');
								w.document.write(\"<TITLE>Ad Missam, Anamnesis formula 2</TITLE>\");
								w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
								w.document.write(\"<tr><td width=49%><center><font color=red>Anamnesis formula 2</font></center></td><td width=49%><center><font color=red>Anamn�se 2e formule</font></center></td></tr>\");
								w.document.write(\"<tr><td width=49%><b>Myst�rium f�dei.</b></td><td width=49%><b>Myst�re de la foi.</b></td></tr>\");
								w.document.write(\"<tr><td width=49%>R/. Quotiesc�mque manduc�mus panem hunc et c�licem b�bimus, mortem tuam annunti�mus, D�mine, donec v�nias.</td><td width=49%>R/. Quand nous mangeons ce pain et bouvons ce calice, nous annon�ons ta mort, Seigneur, jusqu'� ce que tu viennes.</td></tr>\");
								w.document.write(\"</table></center></BODY>\");
								w.document.close();
							}
						</SCRIPT>";
						$messe.="
						<SCRIPT LANGUAGE=\"JavaScript\">
							function anamnese3() {
								// ouvre une fenetre sans barre d'etat, ni d'ascenceur
								w=open(\"\",'popup','width=500,height=200,toolbar=no,scrollbars=auto,resizable=no');
								w.document.write(\"<TITLE>Ad Missam, Anamnesis formula 3</TITLE>\");
								w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
								w.document.write(\"<tr><td width=49%><center><font color=red>Anamnesis formula 2</font></center></td><td width=49%><center><font color=red>Anamn�se 2e formule</font></center></td></tr>\");
								w.document.write(\"<tr><td width=49%><b>Myst�rium f�dei.</b></td><td width=49%><b>Myst�re de la foi.</b></td></tr>\");
								w.document.write(\"<tr><td width=49%>R/. Salv�tor mundi, salva nos, qui per crucem et resurrecti�nem tuam liber�sti nos.</td><td width=49%>R/. Sauveur du monde, sauve nous, toi qui par ta croix et ta r�surrection nous as lib�r�.</td></tr>\");
								w.document.write(\"</table></center></BODY>\");
								w.document.close();
							}
						</SCRIPT>";
						$messe.="<tr><td width=49%><center><A HREF='javascript:anamnese2()'>formula 2</A>, <A HREF='javascript:anamnese3()'>formula 3</A></center></td><td width=49%><center><A HREF='javascript:anamnese2()'>2nde formule</A>, <A HREF='javascript:anamnese3()'>3e formule</A></center></td></tr>";
					break;
					case"":
					break;
					default:
						/*if($lat[0]=="A")$messe.="<tr><td id=\"colgauche\"><b>$lat</b></td><td id=\"coldroite\"><b>$fr</b></td></tr>";
						else $messe.="<tr><td id=\"colgauche\"><b>$lat</b></td><td id=\"coldroite\"><b>$fr</b></td></tr>";*/
						$messe.="<tr><td id=\"colgauche\"><b>$lat</b></td><td id=\"coldroite\"><b>$fr</b></td></tr>";
					break;
				}
				$iterateur++;
			}
		break;
		
		case "#ANT_COMM":
			if($communion) $messe.=propre($communion);
		break;
		
		case "#ORA_POSTCOMMUNIO":
			$messe.=oraison($postcommunio_lat,$postcommunio_fr);
		break;
		
		case "#ORA_SUPERPOP":
			//$ben_simplex=false;
			if($ora_superpop_lat){
				$messe.="<tr><td id=\"colgauche\"><center><font color=red>Oratio super populum</font></center></td><td id=\"coldroite\"><center><font color=red>Pri�re sur le peuple</font></center></td></tr>";
				$messe.="<tr><td id=\"colgauche\">Diaconus: <b>Inclin�te vos ad benedicti�nem.</b></td><td id=\"coldroite\">le Diacre : <b>Inclinez vous pour la  b�n�diction.</b></td></tr>";
				$messe.="<tr><td id=\"colgauche\">Sacerdos: $ora_superpop_lat</td><td id=\"coldroite\">le Pr�tre : $ora_superpop_fr</td></tr>";
				$messe.="<tr><td id=\"colgauche\">R/. Amen.</td><td id=\"coldroite\">R/. Amen.</td></tr>";
				$ben_simplex=true;
			}
		break;
		
		case "#BENSOL":
			//$ben_simplex=false;
			if(!$ben_simplex) {
				$messe.="<tr><td id=\"colgauche\"><center><font color=red>Benedictio Sollemni</font></center></td><td id=\"coldroite\"><center><font color=red>Benediction</font></center></td></tr>";
				$messe.="<tr><td id=\"colgauche\">Diaconus: <b>Inclin�te vos ad benedicti�nem.</b></td><td id=\"coldroite\">le Diacre : <b>Inclinez vous pour la  b�n�diction.</b></td></tr>";
				$messe.=bene_sol("<tr><td id=\"colgauche\">Sacerdos : <b>$bene_lat</b></td><td id=\"coldroite\">le Pr�tre : <b>$bene_fr</b></td></tr>");
				$messe.="<tr><td id=\"colgauche\"><b>Et bened�ctio Dei omnipot�ntis, Patris, et F�lii, <font color=red size=+1>+</font> et Sp�ritus Sancti, desc�ndat super vos et m�neat semper.</b></td><td id=\"coldroite\"><b>Et que la b�n�diction de Dieu tout puissant, P�re, et Fils, <font color=red size=+1>+</font> et Esprit Saint, descende sur vous et y reste toujours.</b></td></tr>";
				$messe.="<tr><td id=\"colgauche\">R/. Amen.</td><td id=\"coldroite\">R/. Amen.</td></tr>";
			}			
		break;
		
		case "#BENE":
			$messe.="
			<SCRIPT LANGUAGE=\"JavaScript\">
				function ben_simplex_E() {
					// ouvre une fenetre sans barre d'etat, ni d'ascenceur
					w=open(\"\",'popup','width=500,height=400,toolbar=no,scrollbars=no,resizable=no');
					w.document.write(\"<TITLE>Ad Missam, Benedictio Episcopi</TITLE>\");
					w.document.write(\"<BODY><center><table bgcolor=#FEFEFE>\");
					w.document.write(\"<tr><td width=49%><center><font color=red>Benedictio Episcopi</font></center></td><td width=49%><center><font color=red>B�n�diction de l'Ev�que</font></center></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>D�minus vob�scum.</b></td><td width=49%><b>Le Seigneur soit avec vous.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Et cum sp�ritu tuo.</td><td width=49%>Et avec votre esprit.</td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Sit nomen D�mini bened�ctum</b></td><td width=49%><b>Que le nom du Seigneur soit b�ni,</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Ex hoc nunc et usque in saeculum.</td><td width=49%>D�s maintenant et � jamais.</td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Adiut�rium nostrum in n�mine D�mini,</b></td><td width=49%><b>Notre secours est dans le nom du Seigneur,</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>Qui fecit caelum et terram.</td><td width=49%>qui a fait les cieux et la terre.</td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Bened�cat vos omn�potens Deus, Pater, <font color=red size=+1>+</font> et F�lius, <font color=red size=+1>+</font> et Sp�ritus <font color=red size=+1>+</font> Sanctus.</b></td><td width=49%><b>Que Dieu tout puissant vous b�nisse, P�re, <font color=red size=+1>+</font> et Fils, <font color=red size=+1>+</font> et Esprit <font color=red size=+1>+</font> Saint.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%><font color=red size=-1>vel</font></td><td width=49%><font color=red size=-1>ou</font></td></tr>\");
					w.document.write(\"<tr><td width=49%><b>Et bened�ctio Dei omnipot�ntis, Patris, et F�lii, <font color=red size=+1>+</font> et Sp�ritus Sancti, desc�ndat super vos et m�neat semper.</b></td><td width=49%><b>Et que la b�n�diction de Dieu tout puissant, P�re, et Fils, <font color=red size=+1>+</font> et Esprit Saint, descende sur vous et y reste toujours.</b></td></tr>\");
					w.document.write(\"<tr><td width=49%>R/. Amen.</td><td width=49%>R/. Amen.</td></tr>\");
					w.document.write(\"</table></center></BODY>\");
					w.document.close();
				}
			</SCRIPT>";
			if($ben_simplex){
				$messe.="<tr><td id=\"colgauche\"><center><font color=red>Benedictio</font></center></td><td id=\"coldroite\"><center><font color=red>Benediction</font></center></td></tr>";
				$messe.="<tr><td id=\"colgauche\"><b>D�minus vob�scum.</b></td><td id=\"coldroite\"><b>Le Seigneur soit avec vous.</b></td></tr>";
				$messe.="<tr><td id=\"colgauche\">Et cum sp�ritu tuo.</td><td id=\"coldroite\">Et avec votre esprit.</td></tr>";
				$messe.="<tr><td id=\"colgauche\"><b>Bened�cat vos omn�potens Deus, Pater, et F�lius, <font color=red size=+1>+</font> et Sp�ritus Sanctus.</b></td><td id=\"coldroite\"><b>Que Dieu tout puissant vous b�nisse, P�re, et Fils, <font color=red size=+1>+</font> et Esprit Saint.</b></td></tr>";
				$messe.="<tr><td id=\"colgauche\">R/. Amen</td><td id=\"coldroite\">R/. Amen</td></tr>";
				$messe.="<tr><td width=49%><center><font color=red><A HREF='javascript:ben_simplex_E()'>formula Episcopi</A></font></center></td><td width=49%><center><font color=red><A HREF='javascript:ben_simplex_E()'>formule de l'Ev�que :</A></font></center></td></tr>";
			}
		break;
		
		case "#DIMISSIO":
			$alleluia=false;
			switch ($calendarium['intitule'][$jour]){
				case "DOMINICA RESURRECTIONIS" :
				case "Dominica II Paschae" :
				case "Dominica Pentecostes" :
					$alleluia=true;
				break;
			}
			if($calendarium['hebdomada'][$jour]=="Infra octavam paschae"){
				$alleluia=true;
			}
			if($alleluia) $messe.="<tr><td id=\"colgauche\">Diaconus: <b>Ite, Missa est, allel�ia, allel�ia.</b></td><td id=\"coldroite\">le Diacre : <b>Allez, c'est la mission, all�luia, all�luia.</b></td></tr>";
			else $messe.="<tr><td id=\"colgauche\">Diaconus: <b>Ite, Missa est.</b></td><td id=\"coldroite\">le Diacre : <b>Allez, c'est la mission.</b></td></tr>";
			if($alleluia) $messe.="<tr><td id=\"colgauche\">R/. Deo gr�tias, allel�ia, allel�ia.</td><td id=\"coldroite\">R/. Rendons gr�ce � Dieu, all�luia, all�luia.</td></tr>";
			else $messe.="<tr><td id=\"colgauche\">R/. Deo gr�tias.</td><td id=\"coldroite\">R/. Rendons gr�ce � Dieu.</td></tr>";
		break;
		
		default :
			$messe.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
		break; //fin default

	}
}
	$messe.="</table>";
	$messe= rougis($messe);
return $messe;
}
?>
