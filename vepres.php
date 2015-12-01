<?php

function vepres($jour,$calendarium,$my) {
	//print_r($calendarium);
	//print_r($calendarium['hebdomada'][$jour]);
	if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
	    $temp['ps7']['latin']="ps109";
		$temp['ps8']['latin']="ps113A";
		$temp['ps9']['latin']="NT12";
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
	$date_fr=$jours_fr[$jrdelasemaine];
	$date_l=$jours_l[$jrdelasemaine];
	
	
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

	
	
$tem=$calendarium['tempus'][$jour];
switch ($tem) {
    case "Tempus Adventus" :
        $psautier="adven";
        break;

    case "Tempus Nativitatis" :
        $psautier="noel";
        break;

    case "Tempus per annum" :
        $psautier="perannum";
        break;

    case "Tempus Quadragesimae" :
        $psautier="quadragesimae";
        break;

    case "Tempus passionis" :
        $psautier="hebdomada_sancta";
        break;

    case "Tempus Paschale" :
        $psautier="pascha";
        break;

    default :
        print"<br><i>Cet office n'est pas encore compl&egrave;tement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider &agrve; compl&eacute;ter ce travail.</a></i>";
        return;
        break;

}


$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];

if($tem=="Tempus Quadragesimae") {
    if ($calendarium['intitule'][$jour]=="Feria IV Cinerum") { $q="quadragesima_0";}
	if ($calendarium['hebdomada'][$jour]=="Dies post Cineres") {$q="quadragesima_0";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada I Quadragesimae") { $q="quadragesima_1";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada II Quadragesimae"){ $q="quadragesima_2";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada III Quadragesimae"){ $q="quadragesima_3";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada IV Quadragesimae"){ $q="quadragesima_4";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada V Quadragesimae"){ $q="quadragesima_5";}
	$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $var[$id]['latin']=$latin;
	    $var[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
}

elseif($tem=="Tempus passionis") {
	$q="hebdomada_sancta";
	$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$var[$id]['latin']=$latin;
		$var[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
}

elseif($tem=="Tempus Paschale") {
	if ($calendarium['hebdomada'][$jour]=="Infra octavam paschae") { $q="pascha_1";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada II Paschae") { $q="pascha_2";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada III Paschae") { $q="pascha_3";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada IV Paschae") { $q="pascha_4";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada V Paschae") { $q="pascha_5";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada VI Paschae") { $q="pascha_6";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada VII Paschae") { $q="pascha_7";}
	if ($calendarium['hebdomada'][$jour]==" ") { $q="pascha_8";}
	$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$var[$id]['latin']=$latin;
		$var[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
}
else {
	$fichier="propres_r/temporal/".$psautier."/".$psautier."_".$spsautier.$jrdelasemaine.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $var[$id]['latin']=$latin;
	    $var[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
}

/*
 * Vérification du sanctoral
 * Chargement de $propre avec les valeurs du sanctoral
 * Affectation des valeurs hymne, LB, RB, ... à partir de $propre
 */
//print_r($calendarium['rang'][$jour]);
if($calendarium['rang'][$jour]) {
	$prop=$mense.$die;
	$fichier="propres_r/sanctoral/".$prop.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$propre[$id]['latin']=$data[1];
		$propre[$id]['francais']=$data[2];
		$row++;
	}
	fclose($fp);
	if($propre['HYMNUS_vepres']['latin']) $hymne=$propre['HYMNUS_vepres']['latin'];
	if($propre['LB_soir']['latin']) $LB_soir=$propre['LB_soir']['latin'];
	if($propre['RB_soir']['latin']) $RB_soir=$propre['RB_soir']['latin'];
	if($propre['jour']['latin']) $pr_lat=$propre['jour']['latin'];
	if($propre['jour']['francais'])	$pr_fr=$propre['jour']['francais'];
	if($propre['intitule']['latin']) $intitule_lat=$propre['intitule']['latin'];
   	if($propre['intitule']['francais']) $intitule_fr=$propre['intitule']['francais'];
   	if($propre['rang']['latin']) $rang_lat=$propre['rang']['latin'];
   	if($propre['rang']['francais']) $rang_fr=$propre['rang']['francais'];
   	if($propre['preces_soir']['latin']) $preces=$propre['preces_soir']['latin'];
}

/*
 * octave glissante précédente noel
 */
if(
		($calendarium['intitule'][$jour]=="Die 17 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 18 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 19 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 20 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 21 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 22 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 23 Decembris")
		OR($calendarium['intitule'][$jour]=="Die 24 Decembris")
) {
	$prop=$mense.$die;
	$fichier="propres_r/sanctoral/".$prop.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
		$propre[$id]['latin']=$data[1];
		$propre[$id]['francais']=$data[2];
		$row++;
	}
	fclose($fp);
	if($propre['HYMNUS_laudes']['latin']) $hymne = $propre['HYMNUS_laudes']['latin'];
	if($propre['LB_matin']['latin']) $LB_matin=$propre['LB_matin']['latin'];
	if($propre['RB_matin']['latin']) $RB_matin=$propre['RB_matin']['latin'];
}


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
 * Vérification du temporal - solennités et fetes
 * Chargement de $temp avec les valeurs du temporal
 * Affectation des valeurs hymne, LB, RB, ... à partir de $temp
 */
if($calendarium['temporal'][$jour]) {
	$tempo=$calendarium['temporal'][$jour];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
	}
	fclose($fp);
	$yy=$temp['magnificat']['francais'];
	print"<br>$yy";
	$oratiolat=$temp['oratio']['latin'];
	$oratiofr=$temp['oratio']['francais'];
	$LB_soir=$temp['LB_soir']['latin'];
	$magniflat=$temp['magnificat']['latin'];
	$magniffr=$temp['magnificat']['francais'];
	$magnificat2="2magnificat_".$lettre;
	if (!$magniflat)$magniflat=$temp[$magnificat2]['latin'];
	if (!$magniffr) $magniffr=$temp[$magnificat2]['francais'];
	$intitule_lat=$temp['intitule']['latin'];
	$rang_lat=$temp['rang']['latin'];
	if($rang_lat)$intitule_lat .="<br>".$rang_lat;
	$intitule_fr=$temp['intitule']['francais'];
	$rang_fr=$temp['rang']['francais'];
	if($rang_fr)$intitule_fr .="<br>".$rang_fr;
	if (($intitule_lat == "FERIA QUARTA CINERUM")||($intitule_lat == "DOMINICA RESURRECTIONIS")||($intitule_fr == "TRIDUUM PASCAL<br>VENDREDI SAINT")||($intitule_fr == "TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l=$intitule_lat."<br> ad ";
	else $date_l = $intitule_lat."<br> ad II ";
	if (($intitule_lat == "FERIA QUARTA CINERUM")||($intitule_lat == "DOMINICA RESURRECTIONIS")||($intitule_fr == "TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr=$intitule_fr."<br> aux ";
	else $date_fr = $intitule_fr."<br> aux IIes ";
	$hymne=$temp['HYMNUS_vepres']['latin'];
	$preces=$temp['preces_soir']['latin'];
}

/*
 * Vérification de premieres vepres au temporal - solennités et fetes
 * Chargement de $temp avec les valeurs du temporal
 * Affectation des valeurs hymne, LB, RB, ... à partir de $temp
 */
$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);
if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])) {
	$propre=null;
	$tempo=$calendarium['temporal'][$demain];
	$fichier="propres_r/temporal/".$tempo.".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
	}
	fclose($fp);
	$intitule_lat=$temp['intitule']['latin'];
	$rang_lat=$temp['rang']['latin'];
	if($rang_lat)$intitule_lat .="<br>".$rang_lat;
	$date_l = $intitule_lat."<br> ad I ";
	$intitule_fr=$temp['intitule']['francais'];
	$rang_fr=$temp['rang']['francais'];
	if($rang_fr)$intitule_fr .="<br>".$rang_fr;
	$date_fr = $intitule_fr."<br> aux I&egrave;res ";
	$oratiolat=$temp['oratio']['latin'];
	$oratiofr=$temp['oratio']['francais'];
	$magnificat="pmagnificat_".$lettre;
	$magniflat=$temp[$magnificat]['latin'];
	$magniffr=$temp[$magnificat]['francais'];
	$hymne=$temp['HYMNUS_1V']['latin'];
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
	$LB_soir=$temp['LB_1V']['latin'];
	$temp['RB_soir']['latin']=$temp['RB_1V']['latin'];
	$temp['RB_soir']['francais']=$temp['RB_1V']['francais'];
	$pr_lat=null;
	$pr_fr=null;
	$intitule_lat=null;
    $intitule_fr=null;
    $preces=null;
}


/*
 * Chargement du squelette des Vêpres et génération de l'affichage de l'office
 */
$row = 0;
$fp = fopen ("offices_r/vepres.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
    $latin=$data[0];$francais=$data[1];
    $vesp[$row]['latin']=$latin;
    $vesp[$row]['francais']=$francais;
    $row++;
}
fclose($fp);

$max=$row;
$vepres="<table>";
for($row=0;$row<$max;$row++){
	$lat=$vesp[$row]['latin'];
	$fr=$vesp[$row]['francais'];
	if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	
	if($lat=="#JOUR") {
		if($pr_lat){
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
            $vepres.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
        	$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\"> $intitule_lat</p></td>
        			<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
        	$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><h3>$rang_lat</h3></td>
        			<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
        	$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><h2>Ad Vesperas</h2></td>
        			<td style=\"width: 49%; text-align: center;\"><h2>Aux V&ecirc;pres</h2></td></tr>";
        	$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
		}
		else {
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l Vesperas</h2></td>
					<td style=\"width: 49%; text-align: center;\"><h2>$date_fr V&ecirc;pres</h2></td></tr>";
		}
	}

	elseif($lat=="#HYMNUS") {
		if($propre['HYMNUS_vepres']['latin']) $hymne=$propre['HYMNUS_vepres']['latin'];
		elseif ($temp['HYMNUS_vepres']['latin']) $hymne=$temp['HYMNUS_vepres']['latin'];
		else $hymne=$var['HYMNUS_vesperas']['latin'];
		$vepres.=hymne($hymne);
	}

	elseif($lat=="#ANT1*"){
	    if($propre['ant7']['latin']) {
			$antlat=$propre['ant7']['latin'];
	    	$antfr=$propre['ant7']['francais'];
	    }
	    elseif($temp['ant7']['latin']){
			$antlat=$temp['ant7']['latin'];
	    	$antfr=$temp['ant7']['francais'];
	    }
        else {
			$antfr=$var['ant7']['francais'];
			$antlat=$var['ant7']['latin'];
        }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS1"){
	    if($propre['ps7']['latin']) $psaume=$propre['ps7']['latin'];
	    elseif($temp['ps7']['latin']) $psaume=$temp['ps7']['latin'];
	    elseif($var['ps7']['latin']) $psaume=$var['ps7']['latin'];
	    else $psaume=$reference['ps7'];
	    $vepres.=psaume($psaume);
	}

	elseif($lat=="#ANT1"){
	    if($propre['ant7']['latin']) {
			$antlat=$propre['ant7']['latin'];
	    	$antfr=$propre['ant7']['francais'];
	    }
	    elseif($temp['ant7']['latin']){
			$antlat=$temp['ant7']['latin'];
	    	$antfr=$temp['ant7']['francais'];
	    }
        else {
			$antfr=$var['ant7']['francais'];
			$antlat=$var['ant7']['latin'];
        }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#ANT2*"){
	    if($propre['ant8']['latin']) {
			$antlat=$propre['ant8']['latin'];
	    	$antfr=$propre['ant8']['francais'];
	    }
	    elseif($temp['ant8']['latin']){
			$antlat=$temp['ant8']['latin'];
	    	$antfr=$temp['ant8']['francais'];
	    }
        else {
			$antfr=$var['ant8']['francais'];
			$antlat=$var['ant8']['latin'];
        }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS2"){
	    if($propre['ps8']['latin']) $psaume=$propre['ps8']['latin'];
	    elseif($temp['ps8']['latin']) $psaume=$temp['ps8']['latin'];
	    elseif($var['ps8']['latin']) $psaume=$var['ps8']['latin'];
	    else $psaume=$reference['ps8'];
	    $vepres.=psaume($psaume);
	}

	elseif($lat=="#ANT2"){
	    if($propre['ant8']['latin']) {
			$antlat=$propre['ant8']['latin'];
	    	$antfr=$propre['ant8']['francais'];
	    }
	    elseif($temp['ant8']['latin']){
			$antlat=$temp['ant8']['latin'];
	    	$antfr=$temp['ant8']['francais'];
	    }
        else {
			$antfr=$var['ant8']['francais'];
			$antlat=$var['ant8']['latin'];
        }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#ANT3*"){
	    if($propre['ant9']['latin']) {
			$antlat=$propre['ant9']['latin'];
	    	$antfr=$propre['ant9']['francais'];
	    }
	    elseif($temp['ant9']['latin']){
			$antlat=$temp['ant9']['latin'];
	    	$antfr=$temp['ant9']['francais'];
	    }
        else {
			$antfr=$var['ant9']['francais'];
			$antlat=$var['ant9']['latin'];
        }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>";
	}
	
	elseif($lat=="#PS3"){
	    if($propre['ps9']['latin']) $psaume=$propre['ps9']['latin'];
	    elseif($temp['ps9']['latin']) $psaume=$temp['ps9']['latin'];
	    elseif($var['ps9']['latin']) $psaume=$var['ps9']['latin'];
	    elseif($var['ps9']['latin']) $psaume=$var['ps9']['latin'];
	    else $psaume=$reference['ps9'];
	    $vepres.=psaume($psaume);
	}
	
	elseif($lat=="#ANT3"){
	    if($propre['ant9']['latin']) {
			$antlat=$propre['ant9']['latin'];
	    	$antfr=$propre['ant9']['francais'];
	    }
	    elseif($temp['ant9']['latin']){
			$antlat=$temp['ant9']['latin'];
	    	$antfr=$temp['ant9']['francais'];
	    }
        else {
			$antfr=$var['ant9']['francais'];
			$antlat=$var['ant9']['latin'];
        }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>";
	}
	
	elseif($lat=="#LB"){
		if($propre['LB_soir']['latin']) $LB_soir=$propre['LB_soir']['latin'];
		elseif ($temp['LB_soir']['latin']) $LB_soir=$temp['LB_soir']['latin'];
		else $LB_soir=$var['LB_soir']['latin'];
	    $vepres.=lectiobrevis($LB_soir);
	}
	
	elseif($lat=="#RB"){
	    if($propre['RB_soir']['latin']) {
	        $rblat=nl2br($propre['RB_soir']['latin']);
	    	$rbfr=nl2br($propre['RB_soir']['francais']);
	    }
	    elseif($temp['RB_soir']['latin']) {
	        $rblat=nl2br($temp['RB_soir']['latin']);
	    	$rbfr=nl2br($temp['RB_soir']['francais']);
	    }
	    else {
	    	$rblat=nl2br($var['RB_soir']['latin']);
	    	$rbfr=nl2br($var['RB_soir']['francais']);
	    }
	    $vepres.="<tr><td><h2>Responsorium Breve</h2></td>
	    		<td><h2>R&eacute;pons bref</h2></td></tr>
	    		<tr><td>$rblat</td>
	    		<td>$rbfr</td></tr>";
	}
	
	elseif($lat=="#ANT_MAGN"){
	    if($propre['magnificat']['latin']) {
			$magniflat=$propre['magnificat']['latin'];
			$magniffr=$propre['magnificat']['francais'];
	    }
	    if($temp['magnificat']['latin']) {
			$magniflat=$temp['magnificat']['latin'];
			$magniffr=$temp['magnificat']['francais'];
	    }
	    else {
	    	if(!$magniflat) $magniflat=$var['magnificat']['latin'];
	    	if(!$magniffr) $magniffr=$var['magnificat']['francais'];
	    }
	    $vepres.="<tr><td><p><span style=\"color:red\">Ant. </span>$magniflat</p></td>
	    		<td><p><span style=\"color:red\">Ant. </span>$magniffr</p></td></tr>";
	}

	elseif($lat=="#MAGNIFICAT"){
	    $vepres.=psaume("magnificat");
	}
	
	elseif($lat=="#PRECES"){
		if($propre['preces_soir']['latin']) $preces=$propre['preces_soir']['latin'];
		elseif($temp['preces_soir']['latin']) $preces=$temp['preces_soir']['latin'];
		else $preces=$var['preces_soir']['latin'];
	 	$vepres.=preces($preces);
	}
	
	elseif($lat=="#PATER"){
	    $vepres.=psaume("pater");
	}

	elseif($lat=="#ORATIO"){
	    if (!$oratiolat) {
	    	$oratiolat=$var['oratio_vesperas']['latin'];
	    	$oratiofr=$var['oratio_vesperas']['francais'];
	    }
	    if ((substr($oratiolat,-6))=="minum.") {
	    	$oratiolat=str_replace(substr($oratiolat,-13), " Per D&oacute;minum nostrum Iesum Christum, F&iacute;lium tuum, qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Par notre Seigneur J&eacute;sus-Christ, ton Fils, qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }
	    if ((substr($oratiolat,-11))==" Qui tecum.") {
	        $oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aeling;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Lui qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }
	    if ((substr($oratiolat,-11))==" Qui vivis.") {
	        $oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aeling;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Toi qui vis et r&egrave;gnes avec Dieu le P&egrave;re dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }
	    $vepres.="<tr><td>$oratiolat</td>
	    		<td>$oratiofr</td></tr>";
	}
	
	elseif (($lat=="Ite in pace. ")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
		$lat="Ite in pace, allel&uacute;ia, allel&uacute;ia.";
		$fr="Allez en paix, all&eacute;luia, all&eacute;luia.";
		$vepres.="<tr><td>$lat</td>
				<td>$fr</td></tr>";
	}
	elseif (($lat=="R/. Deo gr�tias.")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
	    $lat="R/. Deo gr&aacute;tias, allel&uacute;ia, allel&uacute;ia.";
	    $fr="R/. Rendons gr&acirc;ces &agrave; Dieu, all&eacute;luia, all&eacute;luia.";
	    $vepres.="<tr><td>$lat</td>
	    		<td>$fr</td></tr>";
	}
	else $vepres.="<tr><td>$lat</td>
			<td>$fr</td></tr>";
}
$vepres.="</table>";
$vepres= rougis_verset ($vepres);
return $vepres;
}
?>