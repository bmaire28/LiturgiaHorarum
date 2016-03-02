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
	if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
	}
	fclose($fp);
	if ($temp['oratio_soir']['latin']) {
		$temp['oratio']['latin']=$temp['oratio_soir']['latin'];
		$temp['oratio']['francais']=$temp['oratio_soir']['francais'];
	}
	$date_fr=$date_l=null;
	// Gestion intitule Ieres ou IIndes vepres en latin
	if (($calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l="<br> ad ";
	elseif ($calendarium['1V'][$jour]) $date_l="<br> ad II ";
	else $date_l = "<br> ad ";
	
	// Gestion intitule Ieres ou IIndes vepres en francais
	if (($calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr="<br> aux ";
	elseif ($calendarium['1V'][$jour]) $date_fr = "<br> aux IIdes ";
	else $date_fr = "<br> aux ";
	
	if ($temp['intitule']['latin']=="IN NATIVITATE DOMINI") {
		$temp['oratio']['latin']=$temp['oratio_vepres']['latin'];
		$temp['oratio']['francais']=$temp['oratio_vepres']['francais'];
	}
}


/*
 * Gestion du 4e Dimanche de l'Avent
 * si c'est le 24/12, prendre toutes les antiennes au 24, rien à modifier
 * sinon prendre uniquement l'antienne benedictus ==> recopier le temporal dans le sanctoral
 */
if ($temp['intitule']['latin']=="Dominica IV Adventus") {
	if ($die!="24") {
		$magniflat=$propre['magnificat']['latin'];
		$magniffr=$propre['magnificat']['francais'];
		$propre=$temp;
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
	$magnificat="pmagnificat_".$lettre;
	if ($temp[$magnificat]['latin']) {
		$temp['magnificat']['latin']=$temp[$magnificat]['latin'];
		$temp['magnificat']['francais']=$temp[$magnificat]['francais'];
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
 * Chargement du squelette des Vepres dans $lau
 * remplissage de $vepres pour l'affichage de l'office
 *
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
	$testAlleluia=utf8_encode($lat);
		if(($tem=="Tempus Quadragesimae")&&($testAlleluia=="Allelúia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($testAlleluia=="Allelúia.")) {
		$lat="";
		$fr="";
	}
	
	if($lat=="#JOUR") {
		if ($propre['jour']['latin']) {
			$pr_lat=$propre['jour']['latin'];
			$pr_fr=$propre['jour']['francais'];
		}
		if ((!$pr_lat)or($calendarium['1V'][$demain])) {
			$pr_lat=$temp['jour']['latin'];
			$pr_fr=$temp['jour']['francais'];
		}
		if($pr_lat){
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
			$vepres.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
			$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
		}
		if ($propre['intitule']['latin']) {
			$intitule_lat=$propre['intitule']['latin'];
			$intitule_fr=$propre['intitule']['francais'];
		}
		if ((!$intitule_lat)or($calendarium['1V'][$demain])) {
			$intitule_lat=$temp['intitule']['latin'];
			$intitule_fr=$temp['intitule']['francais'];
		}
		if ($intitule_lat){
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>";
			$vepres.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
			$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
		}
		if($propre['rang']['latin']) {
			$rang_lat=$propre['rang']['latin'];
			$rang_fr=$propre['rang']['francais'];
		}
		if ((!$rang_lat)or($calendarium['1V'][$demain])) {
			$rang_lat=$temp['rang']['latin'];
			$rang_fr=$temp['rang']['francais'];
		}
		if ($rang_lat){
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><h3> $rang_lat</h3></td>";
			$vepres.="<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
			$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
		}
		if (($pr_lat)or($intitule_lat)or($rang_lat)) {
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l Vesperas</h2></td>";
			$vepres.="<td style=\"width: 49%; text-align: center;\"><h2>$date_fr V&ecirc;pres</h2></td></tr>";
		}
		if (!$date_l) {
			$jrdelasemaine--;
			$vepres.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] Vesperas</h2></td>";
			$vepres.="<td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] V&ecirc;pres</h2></td></tr>";
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
		$magnificat="magnificat_".$lettre;
		if($propre[$magnificat]['latin']) {
			$magniflat=$propre[$magnificat]['latin'];
			$magniffr=$propre[$magnificat]['francais'];
		}
		elseif($propre['magnificat']['latin']) {
			$magniflat=$propre['magnificat']['latin'];
			$magniffr=$propre['magnificat']['francais'];
		}
		elseif ($temp[$magnificat]['latin']) {
			$magniflat=$temp[$magnificat]['latin'];
			$magniffr=$temp[$magnificat]['francais'];
		}
		elseif($temp['magnificat']['latin']) {
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
		if($propre['oratio_soir']['latin']) {
			$oratiolat=$propre['oratio_soir']['latin'];
			$oratiofr=$propre['oratio_soir']['francais'];
		}
		elseif($propre['oratio']['latin']) {
			$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
		}
		elseif($temp['oratio_soir']['latin']) {
			$oratiolat=$temp['oratio_soir']['latin'];
			$oratiofr=$temp['oratio_soir']['francais'];
		}
		elseif($temp['oratio']['latin']) {
			$oratiolat=$temp['oratio']['latin'];
			$oratiofr=$temp['oratio']['francais'];
		}
	    elseif ($oratiolat=$var['oratio_vesperas']['latin']) {
	    	$oratiolat=$var['oratio_vesperas']['latin'];
	    	$oratiofr=$var['oratio_vesperas']['francais'];
	    }
	    elseif ($oratiolat=$var['oratio']['latin']) {
	    	$oratiolat=$var['oratio']['latin'];
	    	$oratiofr=$var['oratio']['francais'];
	    }
	    if ((substr($oratiolat,-6))=="minum.") {
	    	$oratiolat=str_replace(substr($oratiolat,-13), " Per D&oacute;minum nostrum Iesum Christum, F&iacute;lium tuum, qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Par notre Seigneur J&eacute;sus-Christ, ton Fils, qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }
	    if ((substr($oratiolat,-17))==" Qui tecum vivit.") {
	        $oratiolat=str_replace(" Qui tecum vivit.", " Qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Lui qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }
	    if ((substr($oratiolat,-11))==" Qui vivis.") {
	        $oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
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