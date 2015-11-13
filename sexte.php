<?php

function sexte($jour,$calendarium,$my) {
/*
if(!$my->email) {
	print"<center><i>Le textes des offices latin/fran�ais ne sont disponibles que pour les utilisateurs enregistr�s. <a href=\"index.php?option=com_registration&task=register\">Enregistrez-vous ici pour continuer (simple et gratuit)</a>.</i></center>";
	return;
}*/

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
        print"<br><i>Cet office n'est pas encore compl�tement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider � compl�ter ce travail.</a></i>";
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
	    $fp = fopen ("propres_r/sanctoral/".$prop.".csv","r");
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


	$row = 0;
	$fp = fopen ("offices_r/sexte.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    $lau[$row]['latin']=$latin;
	    $lau[$row]['francais']=$francais;
	    $row++;

	}
	fclose($fp);

	$spsautier=$calendarium['hebdomada_psalterium'][$jour];

	if($tem=="Tempus Quadragesimae") {
	if ($calendarium['intitule'][$jour]=="Feria IV Cinerum") { $q="quadragesima_0";}
	if ($calendarium['hebdomada'][$jour]=="Dies post Cineres") {$q="quadragesima_0";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada I Quadragesimae") { $q="quadragesima_1";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada II Quadragesimae"){ $q="quadragesima_2";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada III Quadragesimae"){ $q="quadragesima_3";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada IV Quadragesimae"){ $q="quadragesima_4";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada V Quadragesimae"){ $q="quadragesima_5";}
	$fp = fopen ("propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $var[$id]['latin']=$latin;
	    $var[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
}

elseif($tem=="Tempus passionis") {
            $q="hebdomada_sancta";
            $fp = fopen ("propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
                while ($data = fgetcsv ($fp, 1000, ";")) {
                        $id=$data[0];$latin=$data[1];$francais=$data[2];
                        $var[$id]['latin']=$latin;
                        $var[$id]['francais']=$francais;
                        $row++;
                }
                fclose($fp);
        }

        elseif($tem=="Tempus Paschale") {
                if ($calendarium['hebdomada'][$jour]=="Infra octavam paschae") { $q="pascha_1";}
                if ($calendarium['hebdomada'][$jour]=="Hebdomada II Paschae") { $q="pascha_2";}
                if ($calendarium['hebdomada'][$jour]=="Hebdomada III Paschae") { $q="pascha_3";}
                if ($calendarium['hebdomada'][$jour]=="Hebdomada IV Paschae") { $q="pascha_4";}
                if ($calendarium['hebdomada'][$jour]=="Hebdomada V Paschae") { $q="pascha_5";}
                if ($calendarium['hebdomada'][$jour]=="Hebdomada VI Paschae") { $q="pascha_6";}
                if ($calendarium['hebdomada'][$jour]=="Hebdomada VII Paschae") { $q="pascha_7";}
                if ($calendarium['hebdomada'][$jour]==" ") { $q="pascha_8";}
                $fp = fopen ("propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
                //print_r ("propres_r/temporal/".$q.$jrdelasemaine.".csv");
                while ($data = fgetcsv ($fp, 1000, ";")) {
                        $id=$data[0];$latin=$data[1];$francais=$data[2];
                        $var[$id]['latin']=$latin;
                        $var[$id]['francais']=$francais;
                        $row++;
                }
                fclose($fp);
        }



else {
$fp = fopen ("propres_r/temporal/".$psautier."/".$psautier."_".$spsautier.$jrdelasemaine.".csv","r");

	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $var[$id]['latin']=$latin;
	    $var[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
}
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

 	$max=$row;
	$sexte="
	<table bgcolor=#FEFEFE>";
	for($row=0;$row<$max;$row++){
	    $lat=$lau[$row]['latin'];
	    $fr=$lau[$row]['francais'];
	    if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
			$lat="";
			$fr="";
			}
			if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")){
				$lat="";
				$fr="";
			}
	if($lat=="#JOUR") {
	    $pr_lat=$propre['jour']['latin'];
	    if($pr_lat){
            $sexte.="<tr><td width=49%><center><b>$pr_lat</b></center></td>";
            $pr_fr=$propre['jour']['francais'];
        $sexte.="<td width=49%><center><b>$pr_fr</b></center></td></tr>";
        $intitule_lat=$propre['intitule']['latin'];
        $intitule_fr=$propre['intitule']['francais'];
        $sexte.="<tr><td width=49%><center><b> $intitule_lat</b></center></td><td width=49%><center><b>$intitule_fr</b></center></td></tr>";
        $rang_lat=$propre['rang']['latin'];
        $rang_fr=$propre['rang']['francais'];
        $sexte.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
        $sexte.="<tr><td width=49%><center><font color=red><b>Ad Sextam</b></font></center></td>";
		$sexte.="<td width=49%><b><center><font color=red><b>A Sexte</b></font></center></td></tr>";
		}
  		else {
  		$l=$jo[$jrdelasemaine]['latin'];
	    $f=$jo[$jrdelasemaine]['francais'];
		$sexte.="<tr><td width=49%><center><font color=red><b>$date_l ad Sextam.</b></font></center></td>";
		$sexte.="<td td width=49%><b><center><font color=red><b>$date_fr &agrave; Sexte.</b></font></center></td></tr>";
			}
	}


	elseif($lat=="#HYMNUS_sextam") {

	    //$mediahora.=hymne("hy_�t�rne_rerum_c�nditor");
	    if(!$hymne6)$hymne6=$var['HYMNUS_sextam']['latin'];
	    $sexte.=hymne($hymne6);

	    //$row++;
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
	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 1 </font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 1 </font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS1"){
	    $psaume=$reference['ps4'];
	    if($temp['ps4']['latin']) $psaume=$temp['ps4']['latin'];
	    elseif($temp['ps4']['latin']) $psaume=$temp['ps4']['latin'];
	    elseif($var['ps4']['latin']) $psaume=$var['ps4']['latin'];
	    $sexte.=psaume($psaume);
	    //$row++;
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
	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font>$antfr</td></tr>";
	    //$row++;

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
	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 2 </font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 2 </font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS2"){
	    $psaume=$reference['ps5'];
	    //print"<br><b>temp : ".$temp['ps5']['latin']."</b>";
	    //print_r($temp);
	    if($temp['ps5']['latin']) $psaume=$temp['ps5']['latin'];
	    elseif($temp['ps5']['latin']) $psaume=$temp['ps5']['latin'];
	    elseif($var['ps5']['latin']) $psaume=$var['ps5']['latin'];
	    $sexte.=psaume($psaume);
	    //$row++;
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
	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;

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
	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 3</font> $antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
	    //$row++;

	}

	elseif($lat=="#PS3"){
	    $psaume=$reference['ps6'];
	    if($temp['ps6']['latin']) $psaume=$temp['ps6']['latin'];
	    elseif($temp['ps6']['latin']) $psaume=$temp['ps6']['latin'];
	    elseif($var['ps6']['latin']) $psaume=$var['ps6']['latin'];
	    $sexte.=psaume($psaume);
	    //$row++;
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
	    $sexte.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;

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
	    $sexte.="<tr><td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>";

	    //$row++;
		//$laudes.=respbrevis("resp_breve_Christe_Fili_Dei_vivi");
	}




	elseif($lat=="#ORATIO_6"){
	    if ($propre['oratio']['latin']) {
	        $oratio6lat=$propre['oratio']['latin'];
	    	$oratio6fr=$propre['oratio']['francais'];
	    }
	    else {
	    if(!$oratiolat)$oratio6lat=$var['oratio_6']['latin'];
	    if(!$oratiofr)$oratio6fr=$var['oratio_6']['francais'];
	    if($oratiolat) {
		    $oratio6lat=$oratiolat;
			$oratio6fr=$oratiofr;
		}
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
	    
	    $sexte.="
	    <tr>
	    <td>Oremus</td><td>Prions</td></tr>
	    <tr>
	<td id=\"colgauche\">$oratio6lat</td><td id=\"coldroite\">$oratio6fr</td></tr>";
	    //$row++;
	}



	else $sexte.="
	<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	$sexte.="</table>";
	$sexte= rougis_verset ($sexte);

	return $sexte;

}






?>
