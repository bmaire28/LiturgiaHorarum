<?php

function vepres($jour,$date_l,$date_fr,$var,$propre,$temp) {


/*
 * Chargement du squelette des Vepres dans $vesp
 * remplissage de $vepres pour l'affichage de l'office
 *
 */
$row = 0;
$fp = fopen ("offices_r/vepres.csv","r");
$jrdelasemaine--;
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
		else {
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
	    //else $psaume=$reference['ps7'];
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