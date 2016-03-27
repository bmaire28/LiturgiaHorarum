<?php

function sexte($jour,$date_l,$date_fr,$var,$propre,$temp) {


/*
 * Chargement du squelette de Sexte dans $lau
 * remplissage de $sexte pour l'affichage de l'office
 *
 */
$row = 0;
$fp = fopen ("offices_r/sexte.csv","r");
$jrdelasemaine--;
while ($data = fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
	$lau[$row]['latin']=$latin;
	$lau[$row]['francais']=$francais;
	$row++;
}
fclose($fp);

$max=$row;
$sexte="<table>";
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
            $sexte.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
            $sexte.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
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
            $sexte.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>";
            $sexte.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
	    }
	    if(!$rang_lat) {
	    	$rang_lat=$propre['rang']['latin'];
	    	$rang_fr=$propre['rang']['francais'];
	    }
	    if($rang_lat){
            $sexte.="<tr><td style=\"width: 49%; text-align: center;\"><h3>$rang_lat</h3></td>";
            $sexte.="<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
	    }
	    if ((!$pr_lat)and(!$intitule_lat)and(!$rang_lat)) {
  			
  			$sexte.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] ad Sextam.</h2></td>
  					<td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] &agrave; Sexte.</h2></td></tr>";
  		}
  		else {
  			$sexte.="<tr><td style=\"width: 49%; text-align: center;\"><h2>Ad Sextam</h2></td>";
  			$sexte.="<td style=\"width: 49%; text-align: center;\"><h2>A Sexte</h2></td></tr>";
  		}
	}

	elseif($lat=="#HYMNUS_sextam") {
		if($propre['HYMNUS_sextam']['latin']) $hymne6=$propre['HYMNUS_sextam']['latin'];
		elseif ($temp['HYMNUS_sextam']['latin']) $hymne6=$temp['HYMNUS_sextam']['latin'];
		else $hymne6=$var['HYMNUS_sextam']['latin'];
		$sexte.=hymne($hymne6);
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
	    $sexte.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS1"){
		$psaume=$reference['ps4'];
		if($propre['ps4']['latin']) $psaume=$propre['ps4']['latin'];
		elseif($temp['ps4']['latin']) $psaume=$temp['ps4']['latin'];
		elseif($var['ps4']['latin']) $psaume=$var['ps4']['latin'];
	    $sexte.=psaume($psaume);
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
	    $sexte.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
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
	    $sexte.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	   }

	elseif($lat=="#PS2"){
		$psaume=$reference['ps5'];
		if($propre['ps5']['latin']) $psaume=$propre['ps5']['latin'];
		elseif($temp['ps5']['latin']) $psaume=$temp['ps5']['latin'];
	    elseif($var['ps5']['latin']) $psaume=$var['ps5']['latin'];
	    $sexte.=psaume($psaume);
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
	    	$antlat=$var['ant5']['latin'];
	    	$antfr=$var['ant5']['francais'];
	    }
	    $sexte.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
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
	    $sexte.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}

	elseif($lat=="#PS3"){
	    $psaume=$reference['ps6'];
	    if($propre['ps6']['latin']) $psaume=$propre['ps6']['latin'];
	    elseif($temp['ps6']['latin']) $psaume=$temp['ps6']['latin'];
	    elseif($var['ps6']['latin']) $psaume=$var['ps6']['latin'];
	    $sexte.=psaume($psaume);
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
	    $sexte.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
 	}

 	elseif($lat=="#LB_6"){
	    if ($propre['LB_6']['latin']) $lectiobrevis=$propre['LB_6']['latin'];
	    elseif ($temp['LB_6']['latin']) $lectiobrevis=$temp['LB_6']['latin'];
	    else $lectiobrevis=$var['LB_6']['latin'];
	    $sexte.=lectiobrevis($lectiobrevis);
	}
	
	elseif($lat=="#RB_6"){
	    if ($propre['RB_6']['latin']) {
	        $rblat=nl2br($propre['RB_6']['latin']);
	        $rbfr=nl2br($propre['RB_6']['francais']);
	    }
	    elseif ($temp['RB_6']['latin']) {
	        $rblat=nl2br($temp['RB_6']['latin']);
	        $rbfr=nl2br($temp['RB_6']['francais']);
	    }
	    else {
	    	$rblat=nl2br($var['RB_6']['latin']);
	    	$rbfr=nl2br($var['RB_6']['francais']);
	    }
	    $sexte.="<tr><td>$rblat</td>
	    		 <td>$rbfr</td></tr>";
	}

	elseif($lat=="#ORATIO_6"){
	    if ($propre['oratio']['latin']) {
	        $oratio6lat=$propre['oratio']['latin'];
	    	$oratio6fr=$propre['oratio']['francais'];
	    }
		elseif ($temp['oratio']['latin']) {
	    	$oratio6lat=$temp['oratio']['latin'];
	    	$oratio6fr=$temp['oratio']['francais'];
	    }
	    elseif ($var['oratio_6']['latin']) {
	    	$oratio6lat=$var['oratio_6']['latin'];
	    	$oratio6fr=$var['oratio_6']['francais'];
	    }
	    elseif ($var['oratio']['latin']) {
	    	$oratio6lat=$var['oratio']['latin'];
	    	$oratio6fr=$var['oratio']['francais'];
	    }
	    switch (substr($oratio6lat,-6)){
	    	case "istum." :
	    		$oratio6lat=str_replace(" Per Christum.", " Per Christum D&oacute;minum nostrum.",$oratio6lat);
	    		$oratio6fr.=" Par le Christ notre Seigneur.";	    		
	    	break;
	    	case "minum." :
	    		$oratio6lat=str_replace(substr($oratio6lat,-13), " Per Christum D&oacute;minum nostrum.",$oratio6lat);
	    		$oratio6fr.=" Par le Christ notre Seigneur.";
	    	break;
	    	case "tecum." :
    			$oratio6lat=str_replace(" Qui tecum.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio6lat);
	    		$oratio6fr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    	case "vivit.":
    			$oratio6lat=str_replace(" Qui vivit.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio6lat);
	    		$oratio6fr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    	case "vivis." :
	    		$oratio6lat=str_replace(" Qui vivis.", " Qui vivis et regnas in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio6lat);
	    		$oratio6fr.=" Toi qui vis et r&egrave;gnes pour tous les si&egrave;cles des si&egrave;cles.";
	    	break;
	    }
	    $sexte.="<tr><td>Or&eacute;mus</td>
	    		<td>Prions</td></tr>
	    		<tr><td>$oratio6lat</td>
	    		 <td>$oratio6fr</td></tr>";
	}
	else $sexte.="<tr><td>$lat</td>
			<td>$fr</td></tr>";
}
$sexte.="</table>";
$sexte= rougis_verset ($sexte);
return $sexte;
}
?>
