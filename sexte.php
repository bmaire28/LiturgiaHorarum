<?php

function sexte($jour,$calendarium,$my) {

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
		$fp = fopen ($fichier,"r");while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $propre[$id]['latin']=$data[1];
	    $propre[$id]['francais']=$data[2];
	    $row++;
		}
	fclose($fp);
	}

/*
 * octave glissante pr√©c√©dente noel 
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
	    //print"<br>Temporal propre";
	    $tempo=$calendarium['temporal'][$jour];
	    $fp = fopen ("propres_r/temporal/".$tempo.".csv","r");
	    //$fp = fopen ("propres_r/temporal/".$prop.".csv","r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
		}
		//print_r($temp);
		$oratiolat=$temp['oratio']['latin'];
		$oratiofr=$temp['oratio']['francais'];
		$hymne6=$temp['HYMNUS_sextam']['latin'];
		$LB_6=$temp['LB_6']['latin'];;

		//print"<br>".$oratiolat;
		//print_r($tempo);
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
 * Chargement du squelette de Sexte dans $lau
 * remplissage de $sexte pour l'affichage de l'office
 *
 */
$row = 0;
$fp = fopen ("offices_r/sexte.csv","r");
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
	if(($tem=="Tempus Quadragesimae")&&($lat=="Allel˙ia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($lat=="Allel˙ia.")){
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
  			$l=$jo[$jrdelasemaine]['latin'];
  			$f=$jo[$jrdelasemaine]['francais'];
  			$sexte.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l ad Sextam.</h2></td>
  					<td style=\"width: 49%; text-align: center;\"><h2>$date_fr &agrave; Sexte.</h2></td></tr>";
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
