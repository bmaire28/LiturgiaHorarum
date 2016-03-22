<?php

function tierce($jour,$date_l,$date_fr,$var,$propre,$temp) {

/*
 * Chargement du squelette de tierce dans $lau
 * remplissage de $tierce pour l'affichage de l'office
 *
 */
$row = 0;
$fp = fopen ("offices_r/tierce.csv","r");
$jrdelasemaine--;
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
		if (!$pr_lat) {
			$pr_lat=$temp['jour']['latin'];
			$pr_fr=$temp['jour']['francais'];
		}
	    if($pr_lat){
	    	$tierce.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
            $tierce.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
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
            $tierce.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>";
            $tierce.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
	    }
	    if(!$rang_lat) {
	    	$rang_lat=$propre['rang']['latin'];
	    	$rang_fr=$propre['rang']['francais'];
	    }
	    if($rang_lat){
            $tierce.="<tr><td style=\"width: 49%; text-align: center;\"><h3> $rang_lat</h3></td>";
            $tierce.="<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
	    }
  		if ((!$pr_lat)and(!$intitule_lat)and(!$rang_lat)) {
  			$tierce.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] ad Tertiam</h2></td>";
  			$tierce.="<td td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] &agrave; Tierce</h2></td></tr>";
		}
		else {
			$tierce.="<tr><td style=\"width: 49%; text-align: center;\"><h2>Ad Tertiam</h2></td>";
			$tierce.="<td style=\"width: 49%; text-align: center;\"><h2>A Tierce</h2></td></tr>";
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
	    elseif ($var['oratio_3']['latin']) {
	    	$oratio3lat=$var['oratio_3']['latin'];
	    	$oratio3fr=$var['oratio_3']['francais'];
	    }
	    elseif ($var['oratio']['latin']) {
	    	$oratio3lat=$var['oratio']['latin'];
	    	$oratio3fr=$var['oratio']['francais'];
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
	    $tierce.="<tr><td>Or&eacute;mus</td><td>Prions</td></tr>
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
