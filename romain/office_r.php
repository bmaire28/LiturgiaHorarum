<?php

function office_r($jour,$date_l,$date_fr,$var,$propre,$temp,$calendarium,$office) {

    $anno=substr($jour,0,4);
	$mense=substr($jour,4,2);
	$die=substr($jour,6,2);
	$day=mktime(12,0,0,$mense,$die,$anno);
	$jrdelasemaine=date("w",$day);
	$tomorow = $day+60*60*24;
	$demain=date("Ymd",$tomorow);
	$tem=$calendarium['tempus'][$jour];
	
/*
 * Chargement du squelette de l'office $squelOffice
 * remplissage de $officeRomain pour l'affichage de l'office
 *
 */
$row = 0;
$fichier="romain/offices_r/";
if ($office) $fichier.=$office;
else $fichier.="complies";

$fichier.=".csv";
$fp = fopen ($fichier,"r");
while ($data = fgetcsv ($fp, 1000, ";")) {
    $latin=$data[0];$francais=$data[1];
    $squelOffice[$row]['latin']=$latin;
    $squelOffice[$row]['francais']=$francais;
    $row++;
}
fclose($fp);

$max=$row;
$officeRomain="<table>";
for($row=0;$row<$max;$row++){
	$lat=$squelOffice[$row]['latin'];
	$fr=$squelOffice[$row]['francais'];
	
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
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_lat</p></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$pr_fr</p></td></tr>";
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
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_lat</p></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><p style=\"font-weight: bold;\">$intitule_fr</p></td></tr>";
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
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><h3> $rang_lat</h3></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
			$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
		}
		if (($pr_lat)or($intitule_lat)or($rang_lat)) {
			switch ($office) {
				case "laudes" :
					$date_l="Ad Laudes Matutinas";
					$date_fr="Aux Laudes";
					break;
				case "tierce" :
					$date_l="Ad Tertiam";
					$date_fr="&Agrave; Tierce";
					break;
				case "sexte" :
					$date_l="Ad Sextam";
					$date_fr="&Agrave; Sexte";
					break;
				case "none" :
					$date_l="Ad Nonam";
					$date_fr="&Agrave None";
					break;
				case "vepres" :
					if (($calendarium['1V'][$demain]) or ($jrdelasemaine==6)){
						$date_l="Ad I Vesperas";
						$date_fr="Aux I&egrave;res V&ecirc;pres";
					}
					elseif (($calendarium['1V'][$jour]) or ($jrdelasemaine==0)) {
						$date_l="Ad II Vesperas";
						$date_fr="Aux IIndes V&ecirc;pres";
					}
					else {
						$date_l="Ad Vesperas";
						$date_fr="Aux V&ecirc;pres";
					}
					break;
				case "complies" :
					if (($calendarium['1V'][$demain]) or ($jrdelasemaine==6)) {
						$date_l="post I Vesperas, ad Completorium";
						$date_fr="apr&egrave;s les I&egrave;res V&ecirc;pres, aux Complies";
					}
					elseif (($calendarium['1V'][$jour]) or ($jrdelasemaine==0)) {
						$date_l="post II Vesperas, ad Completorium";
						$date_fr="apr&egrave;s les IIes V&ecirc;pres, aux Complies";
					}
					else {
						$date_l="Ad Completorium";
						$date_fr="Aux Complies";
					}
					break;
			}
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l</h2></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><h2>$date_fr</h2></td></tr>";
		}
		else {
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l</h2></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><h2>$date_fr</h2></td></tr>";
		}
	} // Fin #JOUR
	
	elseif ($lat=="#INTRODUCTION") {
		$officeRomain.="<tr><td>V/. Deus, in adiut&oacute;rium meum int&eacute;nde.<br />\n
				R/. D&oacute;mine, ad adiuv&aacute;ndum me fest&iacute;na.<br/>\n
				Gl&oacute;ria Patri, et F&iacute;lio, et Spir&iacute;tui Sancto.<br />\n
				Sicut erat in principio, et nunc et semper et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.";
				if (($tem=="Tempus Quadragesimae") or ($tem=="Tempus passionis")) {
						$officeRomain.="</td>";
				}
				else $officeRomain.=" Allel&uacute;ia.</td>";
		$officeRomain.="<td>V/. O Dieu, h&acirc;te-toi de me d&eacute;livrer !<br />\n
				R/. Seigneur, h&acirc;te-toi de me secourir !<br />\n
				Gloire au P&egrave;re et au Fils et au Saint-Esprit,<br />\n
				Comme il &eacute;tait au commencement, maintenant et toujours,<br />\n
				Et dans les si&egrave;cles des si&egrave;cles. Amen.";
				if (($tem=="Tempus Quadragesimae") or ($tem=="Tempus passionis")) {
						$officeRomain.="</td></tr>";
				}
				else $officeRomain.=" All&eacute;luia.</td></tr>";
	}// Fin de #INTRODUCTION
	
	elseif ($lat=="#EXAMEN"){
		$officeRomain.="<tr><td><h2>Conscienti&aelig; discussio</h2></td>";
		$officeRomain.="<td><h2>Examen de conscience</h2></td></tr>";
		$officeRomain.="<tr><td>Conf&iacute;teor Deo omnipot&eacute;nti et vobis, fratres, quia pecc&aacute;vi nimis cogitati&oacute;ne, verbo, &oacute;pere et omissi&oacute;ne:</td>";
		$officeRomain.="<td>Je confesse &agrave; Dieu tout puissant et &agrave; vous, mes fr&egrave;res, car j'ai p&eacute;ch&eacute; par la pens&eacute;e, la parole, les actes et par omission :</td></tr>";
		$officeRomain.="<tr><td><h5>et, percutientes sibi pectus, dicunt :</h5></td>";
		$officeRomain.="<td><h5>et, en se frappant la poitrine, on dit :</h5></td></tr>";
		$officeRomain.="<tr><td>mea culpa, mea culpa, mea m&aacute;xima culpa.</td>";
		$officeRomain.="<td> je suis coupable, je suis coupable, je suis grandement coupable.</td></tr>";
		$officeRomain.="<tr><td><h5>Deinde prosequuntur:</h5></td>";
		$officeRomain.="<td><h5>ensuite, on continue :</h5></td></tr>";
		$officeRomain.="<tr><td>Ideo precor be&aacute;tam Mar&iacute;am semper V&iacute;rginem, omnes Angelos et Sanctos, et vos, fratres, or&aacute;re pro me ad D&oacute;minum Deum nostrum.</td>";
		$officeRomain.="<td>C'est pourquoi je supplie la bienheureuse Marie toujours Vierge, tous les Anges et les Saints, et vous, fr&egrave;res, de prier pour moi le Seigneur notre Dieu.</td></tr>";
		$officeRomain.="<tr><td>V/. Misere&aacute;tur nostri omn&iacute;potens Deus et, dimiss&iacute;s pecc&aacute;tis nostris, perd&uacute;cat nos ad vitam &aelig;t&eacute;rnam.</td>";
		$officeRomain.="<td>V/. Aie piti&eacute; de nous Dieu tout puissant et, nos p&eacute;ch&eacute;s ayant &eacute;t&eacute; renvoy&eacute;s, conduis-nous &agrave; la vie &eacute;ternelle.</td></tr>";
		$officeRomain.="<tr><td>R/. Amen.</td>";
		$officeRomain.="<td>R/. Amen.</td></tr>";
	}//Fin de #EXAMEN

	elseif($lat=="#HYMNUS") {
		switch ($office) {
			case "laudes" :
				$hymnus1=$hymnus2="HYMNUS_laudes";
				break;
			case "tierce" :
				$hymnus1=$hymnus2="HYMNUS_tertiam";
				break;
			case "sexte" :
				$hymnus1=$hymnus2="HYMNUS_sextam";
				break;
			case "none" :
				$hymnus1=$hymnus2="HYMNUS_nonam";
				break;
			case "vepres" :
				$hymnus1="HYMNUS_vepres";
				$hymnus2="HYMNUS_vesperas";
				break;
			case "complies" :
				switch ($calendarium['tempus'][$jour]) {
					case "Tempus Paschale":
						$hymne=utf8_decode("hy_Iesu, redémptor");
						break;
				
					case "Tempus Quadragesimae":
					case "Tempus per annum":
						switch ($calendarium['hebdomada_psalterium'][$jour]) {
							case 1:
							case 3:
								$hymne=utf8_decode("hy_Te lucis");
								break;
							case 2:
							case 4:
								$hymne=utf8_decode("hy_Christe, qui, splendor");
								break;
						}
						break;
				
					case "Tempus Adventus":
						$seizedec=mktime(12,0,0,12,16,$anno);
						if($day<=$seizedec) {
							$hymne="hy_Te lucis";
						}
						else{
							$hymne="hy_Christe, qui, splendor";
						}
						break;
				
					case "Tempus Nativitatis":
						$sixjanv=mktime(12,0,0,1,6,$anno);
						if($mense=="12"){
							$annosuivante=$anno+1;
							$sixjanv=mktime(12,0,0,1,6,$annosuivante);
						}
						if($day<=$sixjanv) {
							$hymne="hy_Te lucis";
						}
						else{
							$hymne="hy_Christe, qui, splendor";
						}
						break;
				}
				break;
		}
		if($propre[$hymnus1]['latin']) $hymne=$propre[$hymnus1]['latin'];
		elseif ($temp[$hymnus1]['latin']) $hymne=$temp[$hymnus1]['latin'];
		elseif (!$hymne) $hymne=$var[$hymnus2]['latin'];
		$officeRomain.=hymne($hymne);
	}// Fin de #HYMNUS

	elseif($lat=="#ANT1*"){
		switch ($office) {
			case "laudes" :
				$ant1="ant1";
				break;
			case "tierce" :
				$ant1="ant4";
				break;
			case "sexte" :
				$ant1="ant5";
				break;
			case "none" :
				$ant1="ant6";
				break;
			case "vepres" :
				$ant1="ant7";
				break;
			case "complies" :
				$ant1="ant11";
				break;
		}
	    if($propre[$ant1]['latin']) {
			$antlat=$propre[$ant1]['latin'];
	    	$antfr=$propre[$ant1]['francais'];
	    }
	    elseif($temp[$ant1]['latin']){
			$antlat=$temp[$ant1]['latin'];
	    	$antfr=$temp[$ant1]['francais'];
	    }
        else {
			$antfr=$var[$ant1]['francais'];
			$antlat=$var[$ant1]['latin'];
        }
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
	}//Fin de #ANT1*

	elseif($lat=="#PS1"){
		switch ($office) {
			case "laudes" :
				$ps1="ps1";
				break;
			case "sexte" :
				$ps1="ps4";
				break;
			case "vepres" :
				$ps1="ps7";
				break;
			case "complies" :
				$ps1="ps11";
				break;
		}
	    if($propre[$ps1]['latin']) $psaume=$propre[$ps1]['latin'];
	    elseif($temp[$ps1]['latin']) $psaume=$temp[$ps1]['latin'];
	    else $psaume=$var[$ps1]['latin'];
	    if ($office=="tierce") $psaume="ps119";
	    elseif ($office=="none") $psaume="ps125";
	    $officeRomain.=psaume($psaume);
	    if ($psaume!="AT41") {
	    	$officeRomain.="<tr><td>Gl&oacute;ria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.<br />\n
	    			Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>";
	    	$officeRomain.="<td>Gloire au P&egrave;re et au Fils et au Saint-Esprit,<br />\n
	    			Comme il &eacute;tait au commencement, maintenant et toujours,<br />\n
	    			Et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>";
	    }
	}//Fin de #PS1

	elseif($lat=="#ANT1"){
		switch ($office) {
			case "laudes" :
				$ant1="ant1";
				break;
			case "vepres" :
				$ant1="ant7";
				break;
			case "complies" :
				$ant1="ant11";
				break;
		}
	    if($propre[$ant1]['latin']) {
			$antlat=$propre[$ant1]['latin'];
	    	$antfr=$propre[$ant1]['francais'];
	    }
	    elseif($temp[$ant1]['latin']){
			$antlat=$temp[$ant1]['latin'];
	    	$antfr=$temp[$ant1]['francais'];
	    }
        else {
			$antfr=$var[$ant1]['francais'];
			$antlat=$var[$ant1]['latin'];
        }
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}//Fin de #ANT1

	elseif($lat=="#ANT2*"){
		switch ($office) {
			case "laudes" :
				$ant2="ant2";
				break;
			case "vepres" :
				$ant2="ant8";
				break;
			case "complies" :
				$ant2="ant12";
				break;
		}
	    if($propre[$ant2]['latin']) {
			$antlat=$propre[$ant2]['latin'];
	    	$antfr=$propre[$ant2]['francais'];
	    }
	    elseif($temp[$ant2]['latin']){
			$antlat=$temp[$ant2]['latin'];
	    	$antfr=$temp[$ant2]['francais'];
	    }
        else {
			$antfr=$var[$ant2]['francais'];
			$antlat=$var[$ant2]['latin'];
        }
        if ($antlat) {
        	$officeRomain.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>";
        	$officeRomain.="<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
        }
	}//Fin de #ANT2*

	elseif($lat=="#PS2"){
		switch ($office) {
			case "laudes" :
				$ps2="ps2";
				break;
			case "sexte" :
				$ps2="ps5";
				break;
			case "vepres" :
				$ps2="ps8";
				break;
			case "complies" :
				$ps2="ps12";
				break;
		}
		if($propre[$ps2]['latin']) $psaume=$propre[$ps2]['latin'];
	    elseif($temp[$ps2]['latin']) $psaume=$temp[$ps2]['latin'];
	    else $psaume=$var[$ps2]['latin'];
	    if ($office=="tierce") $psaume="ps120";
	    elseif ($office=="none") $psaume="ps126";
	    if ($psaume!="") $officeRomain.=psaume($psaume);
	    if ($psaume!="AT41") {
	    	$officeRomain.="<tr><td>Gl&oacute;ria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.<br />\n
	    			Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>";
	    	$officeRomain.="<td>Gloire au P&egrave;re et au Fils et au Saint-Esprit, <br />\n
	    			Comme il &eacute;tait au commencement, maintenant et toujours,<br />\n
	    			Et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>";
	    }
	}//Fin de #PS2

	elseif($lat=="#ANT2"){
		switch ($office) {
			case "laudes" :
				$ant2="ant2";
				break;
			case "vepres" :
				$ant2="ant8";
				break;
			case "complies" :
				$ant2="ant12";
				break;
		}
	    if($propre[$ant2]['latin']) {
			$antlat=$propre[$ant2]['latin'];
	    	$antfr=$propre[$ant2]['francais'];
	    }
	    elseif($temp[$ant2]['latin']){
			$antlat=$temp[$ant2]['latin'];
	    	$antfr=$temp[$ant2]['francais'];
	    }
        else {
			$antfr=$var[$ant2]['francais'];
			$antlat=$var[$ant2]['latin'];
        }
        if ($antlat) {
		    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>";
		    $officeRomain.="<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
        }
	}//Fin de #ANT2

	elseif($lat=="#ANT3*"){
		switch ($office) {
			case "laudes" :
				$ant3="ant3";
				break;
			case "vepres" :
				$ant3="ant9";
				break;
		}
	    if($propre[$ant3]['latin']) {
			$antlat=$propre[$ant3]['latin'];
	    	$antfr=$propre[$ant3]['francais'];
	    }
	    elseif($temp[$ant3]['latin']){
			$antlat=$temp[$ant3]['latin'];
	    	$antfr=$temp[$ant3]['francais'];
	    }
        else {
			$antfr=$var[$ant3]['francais'];
			$antlat=$var[$ant3]['latin'];
        }
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>";
	}//Fin de #ANT3*
	
	elseif($lat=="#PS3"){
		switch ($office) {
			case "laudes" :
				$ps3="ps3";
				break;
			case "sexte" :
				$ps3="ps6";
				break;
			case "vepres" :
				$ps3="ps9";
				break;
		}
		if($propre[$ps3]['latin']) $psaume=$propre[$ps3]['latin'];
	    elseif($temp[$ps3]['latin']) $psaume=$temp[$ps3]['latin'];
	    else $psaume=$var[$ps3]['latin'];
	    if ($office=="tierce") $psaume="ps121";
	    elseif ($office=="none") $psaume="ps127";
	    $officeRomain.=psaume($psaume);
	    if ($psaume!="AT41") {
	    	$officeRomain.="<tr><td>Gl&oacute;ria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.<br />\n
	    			Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>";
	    	$officeRomain.="<td>Gloire au P&egrave;re et au Fils et au Saint-Esprit,<br />\n
	    			Comme il &eacute;tait au commencement, maintenant et toujours,<br />\n
	    			Et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>";
	    }
	}//Fin de #PS3
	
	elseif($lat=="#ANT3"){
		switch ($office) {
			case "laudes" :
				$ant3="ant3";
				break;
			case "tierce" :
				$ant3="ant4";
				break;
			case "sexte" :
				$ant3="ant5";
				break;
			case "none" :
				$ant3="ant6";
				break;
			case "vepres" :
				$ant3="ant9";
				break;
		}
	    if($propre[$ant3]['latin']) {
			$antlat=$propre[$ant3]['latin'];
	    	$antfr=$propre[$ant3]['francais'];
	    }
	    elseif($temp[$ant3]['latin']){
			$antlat=$temp[$ant3]['latin'];
	    	$antfr=$temp[$ant3]['francais'];
	    }
        else {
			$antfr=$var[$ant3]['francais'];
			$antlat=$var[$ant3]['latin'];
        }
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>";
	}//Fin de #ANT3
	
	elseif($lat=="#LB"){
		switch ($office) {
			case "laudes" :
				$lectio="LB_matin";
				break;
			case "tierce" :
				$lectio="LB_3";
				break;
			case "sexte" :
				$lectio="LB_6";
				break;
			case "none" :
				$lectio="LB_9";
				break;
			case "vepres" :
				$lectio="LB_soir";
				break;
			case "complies" :
				$lectio="LB_comp";
				break;
		}
	    if($propre[$lectio]['latin']) $LB=$propre[$lectio]['latin'];
		elseif ($temp[$lectio]['latin']) $LB=$temp[$lectio]['latin'];
		else $LB=$var[$lectio]['latin'];
	    $officeRomain.=lectiobrevis($LB);
	}// Fin de #LB
	
	elseif($lat=="#RB"){
		switch ($office) {
			case "laudes" :
				$repons="RB_matin";
				break;
			case "tierce" :
				$repons="RB_3";
				break;
			case "sexte" :
				$repons="RB_6";
				break;
			case "none" :
				$repons="RB_9";
				break;
			case "vepres" :
				$repons="RB_soir";
				break;
			case "complies" :
				if ($calendarium['hebdomada'][$jour]=="Infra octavam paschae"){
					$rblat="H&aelig;c dies, * quam fecit D&oacute;minus: exsult&eacute;mus, et l&aelig;t&eacute;mur in ea.";
					$rbfr="Voici le jour * que le Seigneur a fait: passons-le dans la joie et l'all&eacutegresse.";
				}
				elseif ($calendarium['tempus'][$jour]=="Tempus Paschale") {
					$rblat="R/. In manus tuas, D&oacute;mine, Comm&eacute;ndo sp&iacute;ritum meum. * allel&uacute;ia, allel&uacute;ia.<br />\n";
					$rblat.="V/. Redem&iacute;sti nos, D&oacute;mine Deus verit&aacute;tis. * allel&uacute;ia, allel&uacute;ia. Gl&oacute;ria Patri. In manus.";
					$rbfr="R/. Entre tes mains, Seigneur, je remets mon esprit. * all&eacute;luia, all&eacute;luia. <br />\n";
					$rbfr.="V/. Tu nous rach&egrave;tes, Seigneur, Dieu de v&eacute;rit&eacute;. * all&eacute;luia, all&eacute;luia. Gloire au P&egrave;re. Entre tes mains.";
				}
				else {
					$rblat="R/. In manus tuas, D&oacute;mine, * Comm&eacute;ndo sp&iacute;ritum meum. In manus.<br />\n";
					$rblat.="V/. Redem&iacute;sti nos, D&oacute;mine Deus verit&aacute;tis. * Comm&eacute;ndo sp&iacute;ritum meum. Gl&oacute;ria Patri. In manus.";
					$rbfr="R/. Entre tes mains, Seigneur, * je remets mon esprit. Entre tes mains.<br />";
					$rbfr.="V/. Tu nous rach&egrave;tes, Seigneur, Dieu de v&eacute;rit&eacute;. * je remets. Gloire au P&egrave;re. Entre tes mains.";
				}
				
				break;
		}
	    if($propre[$repons]['latin']) {
	        $rblat=nl2br($propre[$repons]['latin']);
	    	$rbfr=nl2br($propre[$repons]['francais']);
	    }
	    elseif($temp[$repons]['latin']) {
	        $rblat=nl2br($temp[$repons]['latin']);
	    	$rbfr=nl2br($temp[$repons]['francais']);
	    }
	    elseif ($rblat=="") {
	    	$rblat=nl2br($var[$repons]['latin']);
	    	$rbfr=nl2br($var[$repons]['francais']);
	    }
	    $officeRomain.="<tr><td><h2>Responsorium Breve</h2></td>";
	    $officeRomain.="<td><h2>R&eacute;pons bref</h2></td></tr>";
	    $officeRomain.="<tr><td>$rblat</td>";
	    $officeRomain.="<td>$rbfr</td></tr>";
	}//Fin de #RB
	
	elseif($lat=="#CANT_EV"){
		switch ($office) {
			case "laudes" :
				$cantEv="benedictus";
				$cantEvLettre="benedictus_".$lettre;
				break;
			case "vepres" :
				$cantEv="magnificat";
				$cantEvLettre="magnificat_".$lettre;
				break;
			case "complies" :
				$cantEv="nuncdimittis";
				$magniflat="Salva nos, D&oacute;mine, vigil&aacute;ntes, cust&oacute;di nos dormi&eacute;ntes, ut vigil&eacute;mus cum Christo et requiesc&aacute;mus in pace.";
				$magniffr="Sauve nous, Seigneur, quand nous veillons, garde nous quand nous dormons, et nous veillerons avec le Messie et nous reposerons en paix.";
				if ($calendarium['tempus'][$jour]=="Tempus Paschale") {
					$magniflat.=" Allel&uacute;ia.";
					$magniffr.=" All&eacute;luia.";
				}
				break;
		}
		if($propre[$cantEvLettre]['latin']) {
			$magniflat=$propre[$cantEvLettre]['latin'];
			$magniffr=$propre[$cantEvLettre]['francais'];
		}
		elseif($propre[$cantEv]['latin']) {
			$magniflat=$propre[$cantEv]['latin'];
			$magniffr=$propre[$cantEv]['francais'];
		}
		elseif($temp[$cantEv]['latin']) {
	    	$magniflat=$temp[$cantEv]['latin'];
			$magniffr=$temp[$cantEv]['francais'];
	    }
	    else {
	    	if(!$magniflat) $magniflat=$var[$cantEv]['latin'];
	    	if(!$magniffr) $magniffr=$var[$cantEv]['francais'];
	    }
	    $officeRomain.="<tr><td><br /><p><span style=\"color:red\">Ant. </span>$magniflat</p></td>";
	    $officeRomain.="<td><br /><p><span style=\"color:red\">Ant. </span>$magniffr</p></td></tr>";
	    $officeRomain.=psaume($cantEv);
    	$officeRomain.="<tr><td>Gl&oacute;ria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.<br />\n
    			Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>";
    	$officeRomain.="<td>Gloire au P&egrave;re et au Fils et au Saint-Esprit,<br />\n
    			Comme il &eacute;tait au commencement, maintenant et toujours,<br />\n
    			Et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>";
	    $officeRomain.="<tr><td><br /><p><span style=\"color:red\">Ant. </span>$magniflat</p></td>";
	    $officeRomain.="<td><br /><p><span style=\"color:red\">Ant. </span>$magniffr</p></td></tr>";
	}//Fin de #CANT_EV
	
	elseif($lat=="#PRECES"){
		switch ($office) {
			case "laudes" :
				$prieres="preces_matin";
				break;
			case "vepres" :
				$prieres="preces_soir";
				break;
		}
		if($propre[$prieres]['latin']) $preces=$propre[$prieres]['latin'];
		elseif($temp[$prieres]['latin']) $preces=$temp[$prieres]['latin'];
		else $preces=$var[$prieres]['latin'];
	 	$officeRomain.=preces($preces);
	}//Fin de #PRECES
	
	elseif($lat=="#PATER"){
		$officeRomain.="<tr><td><h2>Pater</h2></td>";
		$officeRomain.="<td><h2>Notre P&egrave;re</h2></td></tr>";
		$officeRomain.="<tr><td>Pater noster, qui es in c&aelig;lis: </td>";
		$officeRomain.="<td>Notre P&egrave;re, qui es aux Cieux,</td></tr>";
		$officeRomain.="<tr><td>sanctific&eacute;tur nomen tuum; </td>";
		$officeRomain.="<td>que ton nom soit sanctifi&eacute; ;</td></tr>";
		$officeRomain.="<tr><td>adv&eacute;niat regnum tuum; </td>";
		$officeRomain.="<td>que ton r&egrave;gne arrive; </td></tr>";
		$officeRomain.="<tr><td>fiat vol&uacute;ntas tua, sicut in c&aelig;lo et in terra.</td>";
		$officeRomain.="<td>que ta volont&eacute; soit faite au Ciel comme sur la terre.</td></tr>";
		$officeRomain.="<tr><td>Panem nostrum cotidi&aacute;num da nobis h&oacute;die; </td>";
		$officeRomain.="<td>Donne-nous aujourd'hui notre pain quotidien,</td></tr>";
		$officeRomain.="<tr><td>et dim&iacute;tte nobis d&eacute;bita nostra, sicut et nos dim&iacute;ttimus debit&oacute;ribus nostris; </td>";
		$officeRomain.="<td>et remets-nous nos dettes,  comme nous les remettons nous-m&ecirc;mes &agrave; nos d&eacute;biteurs ;</td></tr>";
		$officeRomain.="<tr><td>et ne nos ind&uacute;cas in tentati&oacute;nem;</td>";
		$officeRomain.="<td>et ne nous abandonne pas dans l'&eacute;preuve, </td></tr>";
		$officeRomain.="<tr><td>sed l&iacute;bera nos a malo.</td>";
		$officeRomain.="<td>mais d&eacute;livre-nous du malin.</td></tr>";
	}//Fin de #PATER

	elseif($lat=="#ORATIO"){
		$officeRomain.="<tr><td><h2>Oratio</h2></td>";
		$officeRomain.="<td><h2>Oraison</h2></td></tr>";
		switch ($office) {
			case "laudes" :
				$oraison2=$oraison="oratio_laudes";
				break;
			case "tierce" :
				$oraison2=$oraison="oratio_3";
				
				break;
			case "sexte" :
				$oraison2=$oraison="oratio_6";
				break;
			case "none" :
				$oraison2=$oraison="oratio_9";
				break;
			case "vepres" :
				$oraison="oratio_soir";
				$oraison2="oratio_vesperas";
				break;
			case "complies" :
				$oratiolat=$var['oratio']['latin'];
				$oratiofr=$var['oratio']['francais'];
				break;
		}
		
		if ($office!="complies") {
			if($propre[$oraison]['latin']) {
				$oratiolat=$propre[$oraison]['latin'];
				$oratiofr=$propre[$oraison]['francais'];
			}
			elseif($propre['oratio']['latin']) {
				$oratiolat=$propre['oratio']['latin'];
				$oratiofr=$propre['oratio']['francais'];
			}
			elseif($temp[$oraison]['latin']) {
				$oratiolat=$temp[$oraison]['latin'];
				$oratiofr=$temp[$oraison]['francais'];
			}
			elseif($temp['oratio']['latin']) {
				$oratiolat=$temp['oratio']['latin'];
				$oratiofr=$temp['oratio']['francais'];
			}
		    elseif ($var[$oraison2]['latin']) {
		    	$oratiolat=$var[$oraison2]['latin'];
		    	$oratiofr=$var[$oraison2]['francais'];
		    }
		    else {
		    	$oratiolat=$var['oratio']['latin'];
		    	$oratiofr=$var['oratio']['francais'];
		    }
		}
	    
	    switch ($office) {
	    	case "laudes":
	    	case "vepres":
	    		if ((substr($oratiolat,-6))=="minum.") {
	    			$oratiolat=str_replace(substr($oratiolat,-13), " Per D&oacute;minum nostrum Iesum Christum, F&iacute;lium tuum, qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia sǽcula s&aelig;cul&oacute;rum.",$oratiolat);
	    			$oratiofr.=" Par notre Seigneur J&eacute;sus-Christ, ton Fils, qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    		}
	    		if ((substr($oratiolat,-11))==" Qui tecum.") {
	    			$oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia sǽcula s&aelig;cul&oacute;rum.",$oratiolat);
	    			$oratiofr.=" Lui qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    		}
	    		if ((substr($oratiolat,-11))==" Qui vivis.") {
	    			$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia sǽcula s&aelig;cul&oacute;rum.",$oratiolat);
	    			$oratiofr.=" Toi qui vis et r&egrave;gnes avec Dieu le P&egrave;re dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    		}
	    		break;
	    	case "tierce":
	    	case "sexte":
	    	case "none":
	    		switch (substr($oratiolat,-6)){
	    			case "istum." :
	    				$oratiolat=str_replace(" Per Christum.", " Per Christum D&oacute;minum nostrum.",$oratiolat);
	    				$oratiofr.=" Par le Christ notre Seigneur.";
	    				break;
	    			case "minum." :
	    				$oratiolat=str_replace(substr($oratiolat,-13), " Per Christum D&oacute;minum nostrum.",$oratiolat);
	    				$oratiofr.=" Par le Christ notre Seigneur.";
	    				break;
	    			case "tecum." :
	    				$oratiolat=str_replace(" Qui tecum.", " Qui vivit et regnat in sǽcula s&aelig;cul&oacute;rum.",$oratiolat);
	    				$oratiofr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    				break;
	    			case "vivit.":
	    				$oratiolat=str_replace(" Qui vivit.", " Qui vivit et regnat in sǽcula s&aelig;cul&oacute;rum.",$oratiolat);
	    				$oratiofr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
	    				break;
	    			case "vivis." :
	    				$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas in sǽcula s&aelig;cul&oacute;rum.",$oratiolat);
	    				$oratiofr.=" Toi qui vis et r&egrave;gnes pour tous les si&egrave;cles des si&egrave;cles.";
	    				break;
	    		}
	    		break;
	    }
	    if (($office=="tierce") or ($office=="sexte") or ($office=="none") or ($office=="complies")) {
	    	$officeRomain.="<tr><td>Or&eacute;mus</td>";
	    	$officeRomain.="<td>Prions</td></tr>";
	    }
	    $officeRomain.="<tr><td>$oratiolat</td>";
	    $officeRomain.="<td>$oratiofr</td></tr>";
	    $officeRomain.="<tr><td>R/. Amen.</td>";
	    $officeRomain.="<td>R/. Amen.</td></tr>";
	}//Fin de #ORATIO
	
	elseif ($lat=="#BENEDICTIO") {
		if ($office=="complies"){
			$officeRomain.="<tr><td><h2>Benedictio</h2></td>";
			$officeRomain.="<td><h2>B&eacute;n&eacute;diction</h2></td></tr>";
			$officeRomain.="<tr><td>V/. Noctem qui&eacute;tam et finem perf&eacute;ctum conc&eacute;dat nobis D&oacute;minus omn&iacute;potens.</td>";
			$officeRomain.="<td>Que le Dieu tout-puissant nous accorde une nuit tranquille et une fin parfaite.</td></tr>";
			$officeRomain.="<tr><td>R/. Amen.</td>";
			$officeRomain.="<td>R/. Amen.</td></tr>";
		}
		else {
			$officeRomain.="<tr><td><h2>Benedictio</h2></td>";
			$officeRomain.="<td><h2>B&eacute;n&eacute;diction</h2></td></tr>";
			$officeRomain.="<tr><td><h5>Deinde, si pr&aelig;est sacerdos vel diaconus, populum dimittit, dicens:</h5></td>";
			$officeRomain.="<td><h5>Ensuite, si l'office est pr&eacute;sid&eacute; par un pr&ecirc;tre ou un diacre, il renvoie le peuple, en disant :</h5></td></tr>";
			$officeRomain.="<tr><td>D&oacute;minus vob&iacute;scum. </td>";
			$officeRomain.="<td>Le Seigneur soit avec vous. </td></tr>";
			$officeRomain.="<tr><td>R/. Et cum sp&iacute;ritu tuo.</td>";
			$officeRomain.="<td>R/. Et avec votre Esprit.</td></tr>";
			$officeRomain.="<tr><td>Bened&iacute;cat vos omn&iacute;potens Deus, Pater, et F&iacute;lius, et Sp&iacute;ritus Sanctus. </td>";
			$officeRomain.="<td>Que le Dieu tout puissant vous b&eacute;nisse, le P&egrave;re, le Fils, et le Saint Esprit.</td></tr>";
			$officeRomain.="<tr><td>R/. Amen.</td>";
			$officeRomain.="<td>R/. Amen.</td></tr>";
			$officeRomain.="<tr><td><h5>Vel alia formula benedictionis, sicut in Missa.</h5></td>";
			$officeRomain.="<td><h5>Ou une autre formule de b&eacute;n&eacute;diction, comme &agrave; la Messe.</h5></td></tr>";
			$officeRomain.="<tr><td><h5>Absente sacerdote vel diacono, et in recitatione a solo, sic concluditur:</h5></td>";
			$officeRomain.="<td><h5>En l''absence d'un pr&ecirc;tre ou d'un diacre, et dans la r&eacute;citation seul, on conclut ainsi :</h5></td></tr>";
			$officeRomain.="<tr><td>D&oacute;minus nos bened&iacute;cat, et ab omni malo def&eacute;ndat, et ad vitam perd&uacute;cat &aelig;t&eacute;rnam. R/. Amen.</td>";
			$officeRomain.="<td>Que le Seigneur nous b&eacute;nisse, et qu'il nous d&eacute;fende de tout mal, et nous conduise &agrave; la vie &eacute;ternelle. R/. Amen.</td>";
		}
	}//Fin de #BENEDICTIO
	
	elseif ($lat=="#ACCLAMATIO") {
		$officeRomain.="<tr><td><h2>Acclamatio finalis</h2></td>";
		$officeRomain.="<td><h2>Acclamation finale</h2></td></tr>";
		$officeRomain.="<tr><td>Benedic&aacute;mus D&oacute;mino";
		if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes")) {
			$officeRomain.=", allel&uacute;ia, allel&uacute;ia.</td>";
		}
		else $officeRomain.=".</td>";
		$officeRomain.="<td>B&eacute;nissons le Seigneur";
		if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes")) {
			$officeRomain.=", all&eacute;luia, all&eacute;luia.</td></tr>";
		}
		else $officeRomain.=".</td></tr>";
		$officeRomain.="<tr><td>R/. Deo gr&aacute;tias";
		if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes")) {
			$officeRomain.=", allel&uacute;ia, allel&uacute;ia.</td>";
		}
		else $officeRomain.=".</td>";
		$officeRomain.="<td>R/. Nous rendons gr&acirc;ces &agrave; Dieu";
		if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes")) {
			$officeRomain.=", all&eacute;luia, all&eacute;luia.</td></tr>";
		}
		else $officeRomain.=".</td></tr>";
	}//Fin de #ACCLAMATIO
	
	elseif ($lat=="#ANT_MARIALE") {
		$ant_marie="";
        switch($calendarium['tempus'][$jour]){
            case "Tempus Paschale":
               $ant_marie="ant_regina caeli";
                break;
            case "Tempus Quadragesimae":
                $ant_marie="ant_ave regina";
                break;
            case "Tempus passionis":
                $ant_marie="ant_ave regina";
                break;
            case "Tempus Nativitatis":
                $ant_marie="ant_alma redemtoris";
                
                break;
            case "Tempus Adventus":
                $ant_marie="ant_alma redemtoris";
                break;
            case "Tempus per annum":{
                $deuxfev=mktime(12,0,0,2,2,$anno);
                if (($mense=="01") or ($mense=="02") or ($mense=="03")){
                    $ant_marie="ant_ave regina";
                }
                elseif($tempo=="IN ASSUMPTIONE B. MARIAE VIRGINIS") {
                    $ant_marie="ant_ave regina";
                }
                else {
                  $ant_marie="ant_salve regina";
                }
            }
        }

        if(($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($jrdelasemaine!=7)){
            $ant_marie="ant_sub tuum";
        }
		$officeRomain.=hymne($ant_marie);
	}//Fin de #ANT_MARIALE
	
}
$officeRomain.="</table>";
$officeRomain= rougis_verset ($officeRomain);
return $officeRomain;
}
?>
