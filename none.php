<?php

function none($jour,$calendarium,$my) {
/*
if(!$my->email) {
	print"<center><i>Le textes des offices latin/fran�ais ne sont disponibles que pour les utilisateurs enregistr�s. <a href=\"index.php?option=com_registration&task=register\">Enregistrez-vous ici pour continuer (simple et gratuit)</a>.</i></center>";
	return;
}*/

$tem=$calendarium['tempus'][$jour];
$spsautier=$calendarium['hebdomada_psalterium'][$jour];
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

$jrdelasemaine++; // pour avoir dimanche=1 etc...



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
	
	
$fp = fopen ("offices_r/jours.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $jo[$id]['latin']=$latin;
	    $jo[$id]['francais']=$francais;
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
		$hymne9=$temp['HYMNUS_nonam']['latin'];
		$LB_9=$temp['LB_9']['latin'];;
		$intitule_lat=$temp['intitule']['latin'];
		$rang_lat=$temp['rang']['latin'];
		if($rang_lat)$intitule_lat .="</b><br>".$rang_lat."<b>";
		$date_l = $intitule_lat."<br> ";
		$intitule_fr=$temp['intitule']['francais'];
		$rang_fr=$temp['rang']['francais'];
		if($rang_fr)$intitule_fr .="</b><br></b>".$rang_fr."<b>";
		$date_fr = $intitule_fr."<br> ";

	}

/*
 * Gestion du 4e Dimanche de l'Avent
 * si c'est le 24/12, prendre toutes les antiennes au 24
 * sinon prendre l'antienne benedictus
 */
if (($temp['intitule']['latin']=="Dominica IV Adventus") and($die!="24")) $propre=$temp;

/*
 * Chargement du squelette de None dans $lau
 * remplissage de $none pour l'affichage de l'office
 *
 */
$row = 0;
$fp = fopen ("offices_r/none.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
	$lau[$row]['latin']=$latin;
	$lau[$row]['francais']=$francais;
	$row++;

}
fclose($fp);
$max=$row;
$none="<table>";
for($row=0;$row<$max;$row++){
	$lat=$lau[$row]['latin'];
	$fr=$lau[$row]['francais'];
	$testAlleluia=utf8_encode($lat);
	if(($tem=="Tempus Quadragesimae")&&($testAlleluia=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($testAlleluia=="Allel�ia.")){
		$lat="";
		$fr="";
	}
	if($lat=="#JOUR") {
		if ($propre['jour']['latin']) {
			$pr_lat=$propre['jour']['latin'];
			$pr_fr=$propre['jour']['francais'];
		}
		if (!$pr_lat) {
			$pr_lat=$temp['jour']['latin'];
			$pr_fr=$temp['jour']['francais'];
		}
	    if($pr_lat){
            $none.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
            $none.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
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
            $none.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>";
            $none.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
	    }
	    if(!$rang_lat) {
	    	$rang_lat=$propre['rang']['latin'];
	    	$rang_fr=$propre['rang']['francais'];
	    }
	    if($rang_lat){
            $none.="<tr><td style=\"width: 49%; text-align: center;\"><h3>$rang_lat</h3></td>";
            $none.="<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
	    }
	    if ((!$pr_lat)and(!$intitule_lat)and(!$rang_lat)) {
  			$l=$jo[$jrdelasemaine]['latin'];
  			$f=$jo[$jrdelasemaine]['francais'];
  			$none.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l ad Nonam.</h2></td>
  					<td style=\"width: 49%; text-align: center;\"><h2>$date_fr &agrave; None.</h2></td></tr>";
  		}
  		else {
  			$none.="<tr><td style=\"width: 49%; text-align: center;\"><h2>Ad Nonam</h2></td>";
  			$none.="<td style=\"width: 49%; text-align: center;\"><h2>A None</h2></td></tr>";
  		}
	}
	
	elseif($lat=="#HYMNUS_nonam") {
		if($propre['HYMNUS_nonam']['latin']) $hymne9=$propre['HYMNUS_nonam']['latin'];
		elseif ($temp['HYMNUS_nonam']['latin']) $hymne9=$temp['HYMNUS_nonam']['latin'];
		else $hymne9=$var['HYMNUS_nonam']['latin'];
		$none.=hymne($hymne9);
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
		$none.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS1"){
	    $psaume="ps125";
	    $none.=psaume($psaume);
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
		$none.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
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
		$none.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS2"){
	    $psaume="ps126";
	    $none.=psaume($psaume);
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
		$none.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
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
		$none.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS3"){
	    $psaume="ps127";
	    $none.=psaume($psaume);
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
		$none.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
 	}

 	elseif($lat=="#LB_9"){
	    if ($propre['LB_9']['latin']) $lectiobrevis=$propre['LB_9']['latin'];
	    elseif ($temp['LB_9']['latin']) $lectiobrevis=$temp['LB_9']['latin'];
	    else $lectiobrevis=$var['LB_9']['latin'];
	    $none.=lectiobrevis($lectiobrevis);
	}
	
	elseif($lat=="#RB_9"){
	    if ($propre['RB_9']['latin']) {
	        $rblat=nl2br($propre['RB_9']['latin']);
	        $rbfr=nl2br($propre['RB_9']['francais']);
	    }
	    elseif ($temp['RB_9']['latin']) {
	        $rblat=nl2br($temp['RB_9']['latin']);
	        $rbfr=nl2br($temp['RB_9']['francais']);
	    }
	    else {
	    	$rblat=nl2br($var['RB_9']['latin']);
	    	$rbfr=nl2br($var['RB_9']['francais']);
	    }
	    $none.="<tr><td>$rblat</td><td>$rbfr</td></tr>";
	}

	elseif($lat=="#ORATIO_9"){
	    if ($propre['oratio']['latin']) {
	        $oratio9lat=$propre['oratio']['latin'];
	    	$oratio9fr=$propre['oratio']['francais'];
	    }
	    elseif ($temp['oratio']['latin']) {
	    	$oratio9lat=$temp['oratio']['latin'];
	    	$oratio9fr=$temp['oratio']['francais'];
	    }
	    elseif ($var['oratio_9']['latin']) {
	    	$oratio9lat=$var['oratio_9']['latin'];
	    	$oratio9fr=$var['oratio_9']['francais'];
	    }
	    elseif ($var['oratio']['latin']) {
	    	$oratio9lat=$var['oratio']['latin'];
	    	$oratio9fr=$var['oratio']['francais'];
	    }
	    switch (substr($oratio9lat,-6)){
	    	case "istum." :
	    		$oratio9lat=str_replace(" Per Christum.", " Per Christum D&oacute;minum nostrum.",$oratio9lat);
	    		$oratio9fr.=" Par le Christ notre Seigneur.";	    		
	    	break;
	    	case "minum." :
	    		$oratio9lat=str_replace(substr($oratio9lat,-13), " Per Christum D&oacute;minum nostrum.",$oratio9lat);
	    		$oratio9fr.=" Par le Christ notre Seigneur.";
	    	break;
	    	case "tecum." :
    			$oratio9lat=str_replace(" Qui tecum.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio9lat);
	    		$oratio9fr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    	case "vivit.":
    			$oratio9lat=str_replace(" Qui vivit.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio9lat);
	    		$oratio9fr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    	case "vivis." :
	    		$oratio9lat=str_replace(" Qui vivis.", " Qui vivis et regnas in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio9lat);
	    		$oratio9fr.=" Toi qui vis et r&egrave;gnes pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    }
	    $none.="<tr><td>Or&eacute;mus</td><td>Prions</td></tr>
	    		<tr><td>$oratio9lat</td><td>$oratio9fr</td></tr>";
	}
	
	else $none.="<tr><td>$lat</td><td>$fr</td></tr>";
}
$none.="</table>";
$none= rougis_verset ($none);
return $none;
}
?>