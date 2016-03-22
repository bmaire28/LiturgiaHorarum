<?php

function none($jour,$date_l,$date_fr,$var,$propre,$temp) {

/*
 * Chargement du squelette de None dans $lau
 * remplissage de $none pour l'affichage de l'office
 *
 */
$row = 0;
$fp = fopen ("offices_r/none.csv","r");
$jrdelasemaine--;
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
	if(($tem=="Tempus Quadragesimae")&&($testAlleluia=="Allelúia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($testAlleluia=="Allelúia.")){
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
  			$none.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] ad Nonam.</h2></td>
  					<td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] &agrave; None.</h2></td></tr>";
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