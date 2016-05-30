<?php

function office_r($jour,$date_l,$date_fr,$var,$propre,$temp) {

/*
 * Chargement du squelette de l'office $squelOffice
 * remplissage de $officeRomain pour l'affichage de l'office
 *
 */
$row = 0;
$fichier="romain/offices_r/";
if ($_GET['office']) $fichier.=$_GET['office'];
else $fichier.="complies";

$fichier.=".csv";
$fp = fopen ($fichier,"r");
$jrdelasemaine--;
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
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l Vesperas</h2></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><h2>$date_fr V&ecirc;pres</h2></td></tr>";
		}
		else {
			$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$jours_l[$jrdelasemaine] Vesperas</h2></td>";
			$officeRomain.="<td style=\"width: 49%; text-align: center;\"><h2>$jours_fr[$jrdelasemaine] V&ecirc;pres</h2></td></tr>";
		}
	} // Fin #JOUR
	
	elseif ($lat=="#INTRODUCTION") {
		$officeRomain.="<tr><td style=\"width: 49%; text-align: center;\">V/. Deus, in adiutórium meum inténde.<br />\n
				R/. Dómine, ad adiuvándum me festína.<br/>\n
				Gloria Patri, et Fílio, * et Spirítui Sancto.<br />\n
				Sicut erat in principio, et nunc et semper * et in sæcula sæculórum. Amen.";
				if (($tem=="Tempus Quadragesimae") or ($tem=="Tempus passionis")) {
						$officeRomain.="</td>";
				}
				else $officeRomain.=" Allelúia.</td>";
		$officeRomain.="<td style=\"width: 49%; text-align: center;\">V/. O Dieu, hâte-toi de me délivrer !<br />\n
				R/. Seigneur, hâte-toi de me secourir !<br />\n
				Gloire au Père et au Fils et au Saint-Esprit,<br />\n
				Comme il était au commencement, maintenant et toujours,<br />\n
				Et dans les siècles des siècles. Amen.";
				if (($tem=="Tempus Quadragesimae") or ($tem=="Tempus passionis")) {
						$officeRomain.="</td></tr>";
				}
				else $officeRomain.=" Alléluia.</td></tr>";
	}// Fin de #INTRODUCTION

	elseif($lat=="#HYMNUS") {
		if($propre['HYMNUS_vepres']['latin']) $hymne=$propre['HYMNUS_vepres']['latin'];
		elseif ($temp['HYMNUS_vepres']['latin']) $hymne=$temp['HYMNUS_vepres']['latin'];
		else $hymne=$var['HYMNUS_vesperas']['latin'];
		$officeRomain.=hymne($hymne);
	}// Fin de #HYMNUS

	elseif($lat=="#ANT1*"){
		switch ($_GET['office']) {
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
		switch ($_GET['office']) {
			case "laudes" :
				$ps1="ps1";
				break;
			case "sexte" :
				$ps1="ps4";
				break;
			case "vepres" :
				$ps1="ps7";
				break;
		}
	    if($propre[$ps1]['latin']) $psaume=$propre[$ps1]['latin'];
	    elseif($temp[$ps1]['latin']) $psaume=$temp[$ps1]['latin'];
	    else $psaume=$var[$ps1]['latin'];
	    if ($_GET['office']=="tierce") $psaume="ps119";
	    elseif ($_GET['office']=="none") $psaume="ps125";
	    $officeRomain.=psaume($psaume);
	}//Fin de #PS1

	elseif($lat=="#ANT1"){
		switch ($_GET['office']) {
			case "laudes" :
				$ant1="ant1";
				break;
			case "vepres" :
				$ant1="ant7";
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
	}//Fin de #ANT1

	elseif($lat=="#ANT2*"){
		switch ($_GET['office']) {
			case "laudes" :
				$ant2="ant2";
				break;
			case "vepres" :
				$ant2="ant8";
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
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
	}//Fin de #ANT2*

	elseif($lat=="#PS2"){
		switch ($_GET['office']) {
			case "laudes" :
				$ps2="ps2";
				break;
			case "sexte" :
				$ps2="ps5";
				break;
			case "vepres" :
				$ps2="ps8";
				break;
		}
		if($propre[$ps2]['latin']) $psaume=$propre[$ps2]['latin'];
	    elseif($temp[$ps2]['latin']) $psaume=$temp[$ps2]['latin'];
	    else $psaume=$var[$ps2]['latin'];
	    if ($_GET['office']=="tierce") $psaume="ps120";
	    elseif ($_GET['office']=="none") $psaume="ps126";	    
	    $officeRomain.=psaume($psaume);
	}//Fin de #PS2

	elseif($lat=="#ANT2"){
		switch ($_GET['office']) {
			case "laudes" :
				$ant2="ant2";
				break;
			case "vepres" :
				$ant2="ant8";
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
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
	}//Fin de #ANT2

	elseif($lat=="#ANT3*"){
		switch ($_GET['office']) {
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
		switch ($_GET['office']) {
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
	    if ($_GET['office']=="tierce") $psaume="ps121";
	    elseif ($_GET['office']=="none") $psaume="ps127";
	    $officeRomain.=psaume($psaume);
	}//Fin de #PS3
	
	elseif($lat=="#ANT3"){
		switch ($_GET['office']) {
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
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>";
	}//Fin de #ANT3
	
	elseif($lat=="#LB"){
		switch ($_GET['office']) {
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
		}
	    if($propre[$lectio]['latin']) $LB=$propre[$lectio]['latin'];
		elseif ($temp[$lectio]['latin']) $LB=$temp[$lectio]['latin'];
		else $LB=$var[$lectio]['latin'];
	    $officeRomain.=lectiobrevis($LB);
	}// Fin de #LB
	
	elseif($lat=="#RB"){
		switch ($_GET['office']) {
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
		}
	    if($propre[$repons]['latin']) {
	        $rblat=nl2br($propre[$repons]['latin']);
	    	$rbfr=nl2br($propre[$repons]['francais']);
	    }
	    elseif($temp[$repons]['latin']) {
	        $rblat=nl2br($temp[$repons]['latin']);
	    	$rbfr=nl2br($temp[$repons]['francais']);
	    }
	    else {
	    	$rblat=nl2br($var[$repons]['latin']);
	    	$rbfr=nl2br($var[$repons]['francais']);
	    }
	    $officeRomain.="<tr><td><h2>Responsorium Breve</h2></td>";
	    $officeRomain.="<td><h2>R&eacute;pons bref</h2></td></tr>";
	    $officeRomain.="<tr><td>$rblat</td>";
	    $officeRomain.="<td>$rbfr</td></tr>";
	}//Fin de #RB
	
	elseif($lat=="#CANT_EV"){
		switch ($_GET['office']) {
			case "laudes" :
				$cantEv="benedictus";
				$cantEvLettre="benedictus_".$lettre;
				break;
			case "vepres" :
				$cantEv="magnificat";
				$cantEvLettre="magnificat_".$lettre;
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
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. </span>$magniflat</p></td>";
	    $officeRomain.="<td><p><span style=\"color:red\">Ant. </span>$magniffr</p></td></tr>";
	    $officeRomain.=psaume($cantEv);
	    $officeRomain.="<tr><td><p><span style=\"color:red\">Ant. </span>$magniflat</p></td>";
	    $officeRomain.="<td><p><span style=\"color:red\">Ant. </span>$magniffr</p></td></tr>";
	}//Fin de #CANT_EV
	
	elseif($lat=="#PRECES"){
		switch ($_GET['office']) {
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
	    $officeRomain.=psaume("pater");
	}//Fin de #PATER

	elseif($lat=="#ORATIO"){
		$officeRomain.="<tr><td><h2>Oratio</h2></td>";
		$officeRomain.="<td><h2>Oraison</h2></td></tr>";
		switch ($_GET['office']) {
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
		}
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
	    elseif ($oratiolat=$var[$oraison2]['latin']) {
	    	$oratiolat=$var[$oraison2]['latin'];
	    	$oratiofr=$var[$oraison2]['francais'];
	    }
	    elseif ($oratiolat=$var['oratio']['latin']) {
	    	$oratiolat=$var['oratio']['latin'];
	    	$oratiofr=$var['oratio']['francais'];
	    }
	    
	    switch ($_GET['office']) {
	    	case "laudes":
	    	case "vepres":
	    		if ((substr($oratiolat,-6))=="minum.") {
	    			$oratiolat=str_replace(substr($oratiolat,-13), " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sǽcula sæculórum.",$oratiolat);
	    			$oratiofr.=" Par notre Seigneur Jésus-Christ, ton Fils, qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    		}
	    		if ((substr($oratiolat,-11))==" Qui tecum.") {
	    			$oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sǽcula sæculórum.",$oratiolat);
	    			$oratiofr.=" Lui qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    		}
	    		if ((substr($oratiolat,-11))==" Qui vivis.") {
	    			$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sǽcula sæculórum.",$oratiolat);
	    			$oratiofr.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    		}
	    		break;
	    	case "tierce":
	    	case "sexte":
	    	case "none":
	    		print "$('<p>').appendTo('.oratio .latin').text('Orémus.');\n";
	    		print "$('<p>').appendTo('.oratio .francais').text('Prions.');\n";
	    		switch (substr($oratiolat,-6)){
	    			case "istum." :
	    				$oratiolat=str_replace(" Per Christum.", " Per Christum Dóminum nostrum.",$oratiolat);
	    				$oratiofr.=" Par le Christ notre Seigneur.";
	    				break;
	    			case "minum." :
	    				$oratiolat=str_replace(substr($oratiolat,-13), " Per Christum Dóminum nostrum.",$oratiolat);
	    				$oratiofr.=" Par le Christ notre Seigneur.";
	    				break;
	    			case "tecum." :
	    				$oratiolat=str_replace(" Qui tecum.", " Qui vivit et regnat in sǽcula sæculórum.",$oratiolat);
	    				$oratiofr.=" Lui qui vit et règne pour tous les siècles des siècles.";
	    				break;
	    			case "vivit.":
	    				$oratiolat=str_replace(" Qui vivit.", " Qui vivit et regnat in sǽcula sæculórum.",$oratiolat);
	    				$oratiofr.=" Lui qui vit et règne pour tous les siècles des siècles.";
	    				break;
	    			case "vivis." :
	    				$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas in sǽcula sæculórum.",$oratiolat);
	    				$oratiofr.=" Toi qui vis et règnes pour tous les siècles des siècles.";
	    				break;
	    		}
	    		break;
	    }
	    if (($_GET['office']=="tierce") or ($_GET['office']=="sexte") or ($_GET['office']=="none")) {
	    	$officeRomain.="<tr><td>Orémus</td>";
	    	$officeRomain.="<td>Prions</td></tr>";
	    }
	    $officeRomain.="<tr><td>$oratiolat</td>";
	    $officeRomain.="<td>$oratiofr</td></tr>";
	}//Fin de #ORATIO
	
	elseif ($lat=="#BENEDICTIO") {
		$officeRomain.="<tr><td><h2>Benedictio</h2></td>";
		$officeRomain.="<td><h2>Bénédiction</h2></td></tr>";
		$officeRomain.="<tr><td><h5>Deinde, si præest sacerdos vel diaconus, populum dimittit, dicens:</h5></td>";
		$officeRomain.="<td><h5>Ensuite, si l'office est présidé par un prêtre ou un diacre, il renvoie le peuple, en disant :</h5></td></tr>";
		$officeRomain.="<tr><td>Dóminus vobíscum. </td>";
		$officeRomain.="<td>Le Seigneur soit avec vous. </td></tr>";
		$officeRomain.="<tr><td>R/. Et cum spíritu tuo.</td>";
		$officeRomain.="<td>R/. Et avec votre Esprit.</td></tr>";
		$officeRomain.="<tr><td>Benedícat vos omnípotens Deus, Pater, et Fílius, et Spíritus Sanctus. </td>";
		$officeRomain.="<td>Que le Dieu tout puissant vous bénisse, le Père, le Fils, et le Saint Esprit.</td></tr>";
		$officeRomain.="<tr><td>R/. Amen.</td>";
		$officeRomain.="<td>R/. Amen.</td></tr>";
		$officeRomain.="<tr><td><h5>Vel alia formula benedictionis, sicut in Missa.</h5></td>";
		$officeRomain.="<td><h5>Ou une autre formule de bénédiction, comme à la Messe.</h5></td></tr>";
		$officeRomain.="<tr><td><h5>Et, si fit dimissio, sequitur invitatio:</h5></td>";
		$officeRomain.="<td><h5>Et, si on fait un envoi, on poursuit par l'invitation :</h5></td></tr";
		$officeRomain.="><tr><td>Ite in pace. </td><td>Allez en Paix. </td></tr>";
		$officeRomain.="<tr><td>R/. Deo grátias.</td>";
		$officeRomain.="<td>R/. Rendons grâces à Dieu.</td></tr>";
		$officeRomain.="<tr><td><h5>Absente sacerdote vel diacono, et in recitatione a solo, sic concluditur:</h5></td>";
		$officeRomain.="<td><h5>En l''absence d'un prêtre ou d'un diacre, et dans la récitation seul, on conclut ainsi :</h5></td></tr>";
		$officeRomain.="<tr><td>Dóminus nos benedícat, et ab omni malo deféndat, et ad vitam perdúcat ætérnam. R/. Amen.</td>";
		$officeRomain.="<td>Que le Seigneur nous bénisse, et qu'il nous défende de tout mal, et nous conduise à la vie éternelle. R/. Amen.</td>";
	}//Fin de #BENEDICTIO
	
	elseif ($lat=="#ACCLAMATIO") {
		$officeRomain.="<tr><td><h2>Acclamatio finalis</h2></td>";
		$officeRomain.="<td><h2>Acclamation finale</h2></td></tr>";
		$officeRomain.="<tr><td>Benedicámus Dómino.</td>";
		$officeRomain.="<td>Bénissons le Seigneur.</td></tr>";
		$officeRomain.="<tr><td>R/. Deo grátias.</td>";
		$officeRomain.="<td>R/. Nous rendons grâces à Dieu.</td></tr>";
	}//Fin de #ACCLAMATIO
	
	elseif (($lat=="Ite in pace. ")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
		$lat="Ite in pace, allel&uacute;ia, allel&uacute;ia.";
		$fr="Allez en paix, all&eacute;luia, all&eacute;luia.";
		$officeRomain.="<tr><td>$lat</td>
				<td>$fr</td></tr>";
	}
	elseif (($lat=="R/. Deo gr�tias.")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
	    $lat="R/. Deo gr&aacute;tias, allel&uacute;ia, allel&uacute;ia.";
	    $fr="R/. Rendons gr&acirc;ces &agrave; Dieu, all&eacute;luia, all&eacute;luia.";
	    $officeRomain.="<tr><td>$lat</td>
	    		<td>$fr</td></tr>";
	}
	else $officeRomain.="<tr><td>$lat</td>
			<td>$fr</td></tr>";
}
$officeRomain.="</table>";
$officeRomain= rougis_verset ($officeRomain);
return $officeRomain;
}
?>
