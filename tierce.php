<?php



function tierce($jour,$calendarium,$my) {

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

$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
$jrdelasemaine=date("w",$day);
//print " <br>jrdelasemaine : $jrdelasemaine";
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];

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
	}


$fp = fopen ("offices_r/jours.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$latin=$data[1];$francais=$data[2];
	$jo[$id]['latin']=$latin;
	$jo[$id]['francais']=$francais;
	$row++;
}
fclose($fp);

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
if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
$fp = fopen ($fichier,"r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$latin=$data[1];$francais=$data[2];
	$var[$id]['latin']=$latin;
	$var[$id]['francais']=$francais;
	$row++;
}
fclose($fp);

$fp = fopen ("propres_r/commune/psautier_".$spsautier.$jrdelasemaine.".csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$ref=$data[1];
	$reference[$id]=$ref;
	$row++;
}
fclose($fp);

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

if($calendarium['temporal'][$jour]) {
	$tempo=$calendarium['temporal'][$jour];
	$fp = fopen ("propres_r/temporal/".$tempo.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
	}
	$oratiolat=$temp['oratio']['latin'];
	$oratiofr=$temp['oratio']['francais'];
	$hymne3=$temp['HYMNUS_tertiam']['latin'];
	$LB_3=$temp['LB_3']['latin'];
	$intitule_lat=$temp['intitule']['latin'];
	$rang_lat=$temp['rang']['latin'];
	if($rang_lat)$intitule_lat .="</b><br>".$rang_lat."<b>";
	$date_l = $intitule_lat."<br> ";
	$intitule_fr=$temp['intitule']['francais'];
	$rang_fr=$temp['rang']['francais'];
	if($rang_fr)$intitule_fr .="</b><br></b>".$rang_fr."<b>";
	$date_fr = $intitule_fr."<br> ";
}


$row = 0;
$fp = fopen ("offices_r/tierce.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
	$lau[$row]['latin']=$latin;
	$lau[$row]['francais']=$francais;
	$row++;
}
fclose($fp);
$max=$row;
$tierce="<table>";
for($row=0;$row<$max;$row++){
	$lat=$lau[$row]['latin'];
	$fr=$lau[$row]['francais'];
	if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	if($lat=="#JOUR") {
		$pr_lat=$propre['jour']['latin'];
	    if($pr_lat){
	    	$pr_fr=$propre['jour']['francais'];
            $tierce.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>
            		<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
            $intitule_lat=$propre['intitule']['latin'];
            $intitule_fr=$propre['intitule']['francais'];
            $tierce.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>
            		<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
            $rang_lat=$propre['rang']['latin'];
            $rang_fr=$propre['rang']['francais'];
            $tierce.="<tr><td style=\"width: 49%; text-align: center;\"><h3> $rang_lat</h3></td>
        		<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
            $tierce.="<tr><td style=\"width: 49%; text-align: center;\"><h2>Ad Tertiam.</h2></td>
            		<td style=\"width: 49%; text-align: center;\"><h2>A Tierce.</h2></td></tr>";
		}
  		else {
  			$l=$jo[$jrdelasemaine]['latin'];
  			$f=$jo[$jrdelasemaine]['francais'];
  			$tierce.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l ad Tertiam.</h2></td>
  					<td td style=\"width: 49%; text-align: center;\"><h2>$date_fr &agrave; Tierce.</h2></td></tr>";
		}
	}

	elseif($lat=="#HYMNUS_tertiam") {
		if($propre['HYMNUS_tertiam']['latin']) $hymne3=$propre['HYMNUS_tertiam']['latin'];
		elseif ($temp['HYMNUS_tertiam']['latin']) $hymne3=$temp['HYMNUS_tertiam']['latin'];
		else $hymne3=$var['HYMNUS_tertiam']['latin'];
		$tierce.=hymne($hymne3);
	}

	elseif($lat=="#ANT1*"){
		if($propre['ant4']['latin']) {
			$antlat=nl2br($propre['ant4']['latin']);
	    	$antfr=nl2br($propre['ant4']['francais']);
	    }
	    elseif($temp['ant4']['latin']) {
	    	$antlat=nl2br($temp['ant4']['latin']);
	    	$antfr=nl2br($temp['ant4']['francais']);
	    }
	    else {
	    	$antlat=$var['ant4']['latin'];
	    	$antfr=$var['ant4']['francais'];
	    }
	    $tierce.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS1"){
		$psaume="ps119";
		$tierce.=psaume($psaume);
	}

	elseif($lat=="#ANT1"){
		if($propre['ant4']['latin']) {
	        $antlat=nl2br($propre['ant4']['latin']);
	    	$antfr=nl2br($propre['ant4']['francais']);
	    }
	    elseif($temp['ant4']['latin']) {
	        $antlat=nl2br($temp['ant4']['latin']);
	    	$antfr=nl2br($temp['ant4']['francais']);
		}
		else {
			$antlat=$var['ant4']['latin'];
			$antfr=$var['ant4']['francais'];
		}
	    $tierce.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#ANT2*"){
	    if($propre['ant5']['latin']) {
	        $antlat=nl2br($propre['ant5']['latin']);
	    	$antfr=nl2br($propre['ant5']['francais']);
	    }
	    elseif($temp['ant5']['latin']) {
	        $antlat=nl2br($temp['ant5']['latin']);
	    	$antfr=nl2br($temp['ant5']['francais']);
	    }
	    else {
	    	$antlat=$var['ant5']['latin'];
	    	$antfr=$var['ant5']['francais'];
	    }
	    $tierce.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS2"){
	    $psaume="ps120";
	    $tierce.=psaume($psaume);
	}

 	elseif($lat=="#ANT2"){
 	    if($propre['ant5']['latin']) {
	        $antlat=nl2br($propre['ant5']['latin']);
	    	$antfr=nl2br($propre['ant5']['francais']);
 	    }
	    elseif($temp['ant5']['latin']) {
	        $antlat=nl2br($temp['ant5']['latin']);
	    	$antfr=nl2br($temp['ant5']['francais']);
		}
		else {
			$antlat=$var['ant4']['latin'];
			$antfr=$var['ant4']['francais'];
		}
	    $tierce.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#ANT3*"){
	    if($propre['ant6']['latin']) {
	        $antlat=nl2br($propre['ant6']['latin']);
	    	$antfr=nl2br($propre['ant6']['francais']);
	    }
	    elseif($temp['ant6']['latin']) {
	        $antlat=nl2br($temp['ant6']['latin']);
	    	$antfr=nl2br($temp['ant6']['francais']);
	    }
	    else {
	    	$antlat=$var['ant6']['latin'];
	    	$antfr=$var['ant6']['francais'];
	    }
	    $tierce.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	    }

	elseif($lat=="#PS3"){
	    $psaume="ps121";
	    $tierce.=psaume($psaume);
	}

 	elseif($lat=="#ANT3"){
 	    if($propre['ant6']['latin']) {
	        $antlat=nl2br($propre['ant6']['latin']);
	    	$antfr=nl2br($propre['ant6']['francais']);
 	    }
        elseif($temp['ant6']['latin']) {
	        $antlat=nl2br($temp['ant6']['latin']);
	    	$antfr=nl2br($temp['ant6']['francais']);
	    }
	    else {
	    	$antlat=$var['ant6']['latin'];
	    	$antfr=$var['ant6']['francais'];
	    }
	    $tierce.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	    }


 	elseif($lat=="#LB_3"){
 		if ($propre['LB_3']['latin']) $lectiobrevis=$propre['LB_3']['latin'];
	    elseif ($temp['LB_3']['latin']) $lectiobrevis=$temp['LB_3']['latin'];
	    else $lectiobrevis=$var['LB_3']['latin'];
	    $tierce.=lectiobrevis($lectiobrevis);
	}
	
	elseif($lat=="#RB_3"){
	    if ($propre['RB_3']['latin']) {
	        $rblat=nl2br($propre['RB_3']['latin']);
	        $rbfr=nl2br($propre['RB_3']['francais']);
	    }
	    elseif ($temp['RB_3']['latin']) {
	        $rblat=nl2br($temp['RB_3']['latin']);
	        $rbfr=nl2br($temp['RB_3']['francais']);
	    }
	    else {
	    	$rblat=nl2br($var['RB_3']['latin']);
	    	$rbfr=nl2br($var['RB_3']['francais']);
	    }
	    $tierce.="<tr> <td>$rblat</td> <td>$rbfr</td></tr>";
	}

	elseif($lat=="#ORATIO_3"){
		if ($propre['oratio']['latin']) {
	        $oratio3lat=$propre['oratio']['latin'];
	    	$oratio3fr=$propre['oratio']['francais'];
	    }
	    elseif ($temp['oratio']['latin']) {
	    	$oratio3lat=$temp['oratio']['latin'];
	    	$oratio3fr=$temp['oratio']['francais'];
	    }
	    else {
	    	if(!$oratiolat)$oratio3lat=$var['oratio_3']['latin'];
	    	if(!$oratiofr)$oratio3fr=$var['oratio_3']['francais'];
	    	if($oratiolat) {
	    		$oratio3lat=$oratiolat;
	    		$oratio3fr=$oratiofr;
	    	}
	    }
	    switch (substr($oratio3lat,-6)){
	    	case "istum." :
	    		$oratio3lat=str_replace(" Per Christum.", " Per Christum D&oacute;minum nostrum.",$oratio3lat);
	    		$oratio3fr.=" Par le Christ notre Seigneur.";	    		
	    	break;
	    	case "minum." :
	    		$oratio3lat=str_replace(substr($oratio3lat,-13), " Per Christum D&oacute;minum nostrum.",$oratio3lat);
	    		$oratio3fr.=" Par le Christ notre Seigneur.";
	    	break;
	    	case "tecum." :
    			$oratio3lat=str_replace(" Qui tecum.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio3lat);
	    		$oratio3fr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    	case "vivit.":
    			$oratio3lat=str_replace(" Qui vivit.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio3lat);
	    		$oratio3fr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    	case "vivis." :
	    		$oratio3lat=str_replace(" Qui vivis.", " Qui vivis et regnas in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio3lat);
	    		$oratio3fr.=" Toi qui vis et r&egrave;gnes pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    }
	    $tierce.="<tr><td>Oremus</td><td>Prions</td></tr>
	    		<tr><td>$oratio3lat</td> <td>$oratio3fr</td></tr>";
	}

	else $tierce.="<tr><td>$lat</td>
			<td>$fr</td></tr>";
}
$tierce.="</table>";
$tierce= rougis_verset ($tierce);
return $tierce;
}


?>
