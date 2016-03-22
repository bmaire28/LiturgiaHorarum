<?php

function laudes($jour,$date_l,$date_fr,$var,$propre,$temp) {

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
fclose($fp);

$max=$row;
$laudes="<table>";
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
				$laudes.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] Laudes matutinas</h2></td>";
				$laudes.="<td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] Laudes du matin</h2></td></tr>";
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