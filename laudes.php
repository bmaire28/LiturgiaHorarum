<?php

function laudes($jour,$calendarium,$my) {
/*
if(!$my->email) {
	print"<center><i>Le textes des offices latin/français ne sont disponibles que pour les utilisateurs enregistrés.</i></center>";
	return;
}*/

if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
	    $temp['ps1']['latin']="ps62";
		$temp['ps2']['latin']="AT41";
		$temp['ps3']['latin']="ps149";
	}

//print_r($calendarium);
/// déterminer le temps liturgique
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
        print"<br><i>Cet office n'est pas encore complètement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider à compléter ce travail.</a></i>";
        return;
        break;

}

/*
if($tem=="Tempus per annum") $psautier="perannum";
if($tem=="Tempus Quadragesimae") $psautier="quadragesimae";
if($tem=="Tempus passionis") $psautier="hebdomada_sancta";
if($tem=="Tempus Paschale") $psautier="pascha";
//if($tem=="Tempus Adventus") $psautier="pascha";
if ($psautier=="") {
	print"<br><i>Cet office n'est pas encore complètement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider à compléter ce travail.</a></i><br><br>";
	return;
}
*/

/// vérifier qu'il n'y a pas de saint ou de célébration particulière

$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
$jrdelasemaine=date("w",$day);
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];
$fp = fopen ("calendrier/liturgia/jours.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $jo[$id]['latin']=$latin;
	    $jo[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];

if($tem=="Tempus Quadragesimae") {
    if ($calendarium['intitule'][$jour]=="Feria IV Cinerum") { $q="quadragesima_0";}
	if ($calendarium['hebdomada'][$jour]=="Dies post Cineres") { $q="quadragesima_0";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada I Quadragesimae") { $q="quadragesima_1";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada II Quadragesimae"){ $q="quadragesima_2";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada III Quadragesimae"){ $q="quadragesima_3";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada IV Quadragesimae"){ $q="quadragesima_4";}
	if ($calendarium['hebdomada'][$jour]=="Hebdomada V Quadragesimae"){ $q="quadragesima_5";}
	$fp = fopen ("calendrier/liturgia/psautier/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
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
            $fp = fopen ("calendrier/liturgia/psautier/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
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
                $fp = fopen ("calendrier/liturgia/psautier/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
                //print_r ("calendrier/liturgia/psautier/".$q.$jrdelasemaine.".csv");
                while ($data = fgetcsv ($fp, 1000, ";")) {
                        $id=$data[0];$latin=$data[1];$francais=$data[2];
                        $var[$id]['latin']=$latin;
                        $var[$id]['francais']=$francais;
                        $row++;
                }
                fclose($fp);
}

else {
$fp=fopen("calendrier/liturgia/psautier/temporal/".$psautier."/".$psautier."_".$spsautier.$jrdelasemaine.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$latin=$data[1];$francais=$data[2];
	    $var[$id]['latin']=$latin;
	    $var[$id]['francais']=$francais;
	    $row++;
	}
	fclose($fp);
}

$fp=fopen("calendrier/liturgia/psautier/commune/psautier_".$spsautier.$jrdelasemaine.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];$ref=$data[1];
	    $reference[$id]=$ref;
	    $row++;
	}
	fclose($fp);
	if($calendarium['rang'][$jour]) {
	    $prop=$mense.$die;
	    //print"<br>prop = $prop";
	    $fp = fopen ("calendrier/liturgia/psautier/sanctoral/".$prop.".csv","r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $propre[$id]['latin']=$data[1];
	    $propre[$id]['francais']=$data[2];
	    $row++;
		}
		fclose($fp);
		if($propre['HYMNUS_laudes']['latin']) $hymne = $propre['HYMNUS_laudes']['latin'];
	    //print"<br>['HYMNUS_laudes']['latin'] : ".$propre['HYMNUS_laudes']['latin'];
		if($propre['LB_matin']['latin']) $LB_matin=$propre['LB_matin']['latin'];
		if($propre['RB_matin']['latin']) $RB_matin=$propre['RB_matin']['latin'];
		//print"<br>LB_matin = $LB_matin";
	}


	if($calendarium['temporal'][$jour]) {
	    //print_r($calendarium['temporal']);
	    $tempo=$calendarium['temporal'][$jour];
	    //print"<br>Temporal propre : $tempo";
	    $fp = fopen ("calendrier/liturgia/psautier/".$tempo.".csv","r");
	    //$fp = fopen ("calendrier/liturgia/psautier/".$prop.".csv","r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
		}
		//print_r($temp);
		$LB_matin=$temp['LB_matin']['latin'];
		$oratiolat=$temp['oratio']['latin'];
		$oratiofr=$temp['oratio']['francais'];
  		$hymne=$temp['HYMNUS_laudes']['latin'];
		$benelat=$temp['benedictus_C']['latin'];
		if(!$benelat) $benelat=$temp['benedictus']['latin'];
		$benefr=$temp['benedictus_C']['francais'];
		if(!$benefr) $benefr=$temp['benedictus']['francais'];
		//print"<br>".$oratiolat;
		//print_r($tempo);
		$intitule_lat=$temp['intitule']['latin'];
		$date_l = $intitule_lat."</b><br> ";
		$rang_lat=$temp['rang']['latin'];
        if($rang_lat)$date_l .=$rang_lat."<br><b>";
        
		$intitule_fr=$temp['intitule']['francais'];
		$date_fr = $intitule_fr."</b><br> ";
		$rang_fr=$temp['rang']['francais'];
		if($rang_fr)$date_fr .="</b>".$rang_fr."<br><b>";
		
		$preces=$temp['preces_matin']['latin'];
		$rang_lat=$temp['rang']['latin'];
        $rang_fr=$temp['rang']['francais'];

		//print"<br>".$rang_lat;

	}

	//print_r($propre);


	// format $jour=AAAAMMJJ
	$row = 0;
	$fp = fopen ("calendrier/liturgia/laudes.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    $lau[$row]['latin']=$latin;
	    $lau[$row]['francais']=$francais;
	    $row++;
	}
	$max=$row;
	$laudes="
	<table bgcolor=#FEFEFE>";
	for($row=0;$row<$max;$row++){
	    $lat=$lau[$row]['latin'];
	    $fr=$lau[$row]['francais'];

	    if(($tem=="Tempus Quadragesimae")&&($lat=="Allelúia.")) {
			$lat="";
			$fr="";
			}
        if(($tem=="Tempus passionis")&&($lat=="Allelúia.")) {
			$lat="";
			$fr="";
			}

	if($lat=="#JOUR") {
	    //$l=$jo[2]['latin'];
	    //$f=$jo[2]['francais'];
	    $pr_lat=$propre['jour']['latin'];
	    //print"<br>".$pr_lat;
	    if (!$pr_lat) $pr_lat=$temp['jour']['latin'];
	    if($pr_lat){
            $laudes.="<tr><td width=49%><center><b>$pr_lat</b></center></td>";
            $pr_fr=$propre['jour']['francais'];
        $laudes.="<td width=49%><center><b>$pr_fr</b></center></td></tr>";
        $intitule_lat=$propre['intitule']['latin'];
        $intitule_fr=$propre['intitule']['francais'];
        $laudes.="<tr><td width=49%><center><b> $intitule_lat</b></center></td><td width=49%><center><b>$intitule_fr</b></center></td></tr>";
	    }
		if(!$rang_lat) {
			$rang_lat=$propre['rang']['latin'];
        	$rang_fr=$propre['rang']['francais'];
		}
		//print"<br>".$rang_lat;
		if($pr_lat){
        $laudes.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
        $laudes.="<tr><td width=49%><center><font color=red><b>Ad Laudes matutinas</b></font></center></td>";
		$laudes.="<td width=49%><b><center><font color=red><b>Aux Laudes du matin</b></font></center></td></tr>";
		$oratiolat=$propre['oratio']['latin'];
		$oratiofr=$propre['oratio']['francais'];
		}
			else {
		$laudes.="<tr><td width=49%><center><font color=red><b>$date_l ad Laudes matutinas</b></font></center></td>";
		$laudes.="<td width=49%><b><center><font color=red><b>$date_fr aux Laudes du matin</b></font></center></td></tr>";
			}

	}

	elseif($lat=="#HYMNUS") {
	    if(!$hymne) $laudes.=hymne($var['HYMNUS_laudes']['latin']);
	    else $laudes.= hymne($hymne);
	    //$row++;
	}

	elseif($lat=="#ANT1*"){
	if($propre['ant1']['latin']) {
	        $antlat=nl2br($propre['ant1']['latin']);
	    	$antfr=nl2br($propre['ant1']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. 1 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 1</font> $antfr</td></tr>";
	    }
	elseif ($temp['ant1']['latin']) {
			$antlat=nl2br($temp['ant1']['latin']);
	    	$antfr=nl2br($temp['ant1']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. 1 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 1</font> $antfr</td></tr>";
	    }
	else {

	    $antlat=$var['ant1']['latin'];
	    $antfr=$var['ant1']['francais'];
	    $laudes.="
	    <tr><td id=\"colgauche\"><font color=red>Ant. 1 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 1</font> $antfr</td></tr>";
	    //$row++;
		}
	}

	elseif($lat=="#PS1"){
	    if($propre['ps1']['latin']) $psaume=$propre['ps1']['latin'];
	    elseif ($temp['ps1']['latin']) $psaume=$temp['ps1']['latin'];
	    elseif($var['ps1']['latin']) $psaume=$var['ps1']['latin'];
	    else $psaume=$reference['ps1'];
	    $laudes.=psaume($psaume);
	    //$row++;
	}

	elseif($lat=="#ANT1"){
	if($propre['ant1']['latin']) {
	        $antlat=nl2br($propre['ant1']['latin']);
	    	$antfr=nl2br($propre['ant1']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    }
	elseif($temp['ant1']['latin']) {
	        $antlat=nl2br($temp['ant1']['latin']);
	    	$antfr=nl2br($temp['ant1']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    }

	else {

	    $antlat=$var['ant1']['latin'];
	    $antfr=$var['ant1']['francais'];
	    $laudes.="
	    <tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
		}
	}

	elseif($lat=="#ANT2*"){
	    if($propre['ant2']['latin']) {
	        $antlat=nl2br($propre['ant2']['latin']);
	    	$antfr=nl2br($propre['ant2']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. 2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 2</font> $antfr</td></tr>";
	    }
	    elseif($temp['ant2']['latin']) {
	        $antlat=nl2br($temp['ant2']['latin']);
	    	$antfr=nl2br($temp['ant2']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. 2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 2</font> $antfr</td></tr>";
	    }

	else {

	    $antlat=$var['ant2']['latin'];
	    $antfr=$var['ant2']['francais'];
	    $laudes.="
	    <tr><td id=\"colgauche\"><font color=red>Ant. 2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 2</font> $antfr</td></tr>";
	    //$row++;
		}
	}

	elseif($lat=="#PS2"){
	    if($propre['ps2']['latin']) $psaume=$propre['ps2']['latin'];
	    elseif($temp['ps2']['latin']) $psaume=$temp['ps2']['latin'];
	    elseif($var['ps2']['latin']) $psaume=$var['ps2']['latin'];
	    else $psaume=$reference['ps2'];
	    $laudes.=psaume($psaume);
	    	    //$row++;
	}

	elseif($lat=="#ANT2"){
	    if($propre['ant2']['latin']) {
	        $antlat=nl2br($propre['ant2']['latin']);
	    	$antfr=nl2br($propre['ant2']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    }
	    elseif($temp['ant2']['latin']) {
	        $antlat=nl2br($temp['ant2']['latin']);
	    	$antfr=nl2br($temp['ant2']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    }
	else {

	    $antlat=$var['ant2']['latin'];
	    $antfr=$var['ant2']['francais'];
	    $laudes.="
	    <tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
		}
	}

	elseif($lat=="#ANT3*"){
	    if($propre['ant3']['latin']) {
	        $antlat=nl2br($propre['ant3']['latin']);
	    	$antfr=nl2br($propre['ant3']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. 3 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
	    }
	    elseif($temp['ant3']['latin']) {
	        $antlat=nl2br($temp['ant3']['latin']);
	    	$antfr=nl2br($temp['ant3']['francais']);
	    	$laudes.="
	    	<tr><td id=\"colgauche\"><font color=red>Ant. 3 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
	    }
	else {

	    $antlat=$var['ant3']['latin'];
	    $antfr=$var['ant3']['francais'];
	    $laudes.="
	    <tr><td id=\"colgauche\"><font color=red>Ant. 3 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
	    //$row++;
		}
	}
	elseif($lat=="#PS3"){
	    if($propre['ps3']['latin']) $psaume=$propre['ps3']['latin'];
	    elseif($temp['ps3']['latin']) $psaume=$temp['ps3']['latin'];
	    elseif($var['ps3']['latin']) $psaume=$var['ps3']['latin'];
	    else $psaume=$reference['ps3'];
	    $laudes.=psaume($psaume);
	    //$row++;
	}
	elseif($lat=="#ANT3"){
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
	    //$row++;
	}
	$laudes.="
	<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	}
	elseif($lat=="#LB"){
	    if ($LB_matin) $lectiobrevis=lectiobrevis($LB_matin);
		else $lectiobrevis =lectiobrevis($var['LB_matin']['latin']);
	    $laudes.=$lectiobrevis;
	}
	elseif($lat=="#RB"){
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
	    	$laudes.="
	    	<tr>
			<td id=\"colgauche\"><font color=red><center><b>Responsorium Breve</b></center></font></td><td id=\"coldroite\"><font color=red><center><b>Répons bref</center></b></font></td></tr>
			<tr>
			<td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>

			";
	    //$row++;
		//$laudes.=respbrevis("resp_breve_Christe_Fili_Dei_vivi");

	}
	elseif($lat=="#ANT_BENE"){
	    if($propre['benedictus']['latin']) {
			$benelat=$propre['benedictus']['latin'];
			$benefr=$propre['benedictus']['francais'];
	    }
	    else {
			if(!$benelat) $benelat=$var['benedictus']['latin'];
	    	if(!$benefr) $benefr=$var['benedictus']['francais'];
	    }

	    $laudes.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$benelat</td><td id=\"coldroite\"><font color=red>Ant. </font> $benefr</td></tr>";
	    //$row++;
	}
	elseif($lat=="#BENEDICTUS"){
	    $laudes.=psaume("benedictus");
	    //$row++;
	}
	elseif($lat=="#PRECES"){
	    if($propre['preces_matin']['latin']) $preces=$propre['preces_matin']['latin'];
	    if($temp['preces_matin']['latin']) $preces=$temp['preces_matin']['latin'];
	    else $preces=$var['preces_matin']['latin'];
	    $laudes.=preces($preces);
	    //$row++;
	}
	elseif($lat=="#PATER"){
	    $laudes.=psaume("pater");
	    //$row++;
	}

	elseif($lat=="#ORATIO"){
	    if (!$oratiolat) {
			$oratiolat=$var['oratio_laudes']['latin'];
	    	$oratiofr=$var['oratio_laudes']['francais'];
	    }
	    
	    if ((substr($oratiolat,-13))==" Per Dóminum.") {
	        $oratiolat=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	$oratiofr.=" Par notre Seigneur Jésus-Christ, ton Fils, qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    }

        if ((substr($oratiolat,-11))==" Qui tecum.") {
	        $oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	$oratiofr.=" Lui qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    }


        if ((substr($oratiolat,-11))==" Qui vivis.") {
	        $oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.",$oratiolat);
	    	$oratiofr.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
	    }
	    
	    
	    
	    $laudes.="
	    <tr>
	<td id=\"colgauche\">$oratiolat</td><td id=\"coldroite\">$oratiofr</td></tr>";
	    //$row++;
	}

	elseif (($lat=="Ite in pace. ")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes"))) {
	    $lat="Ite in pace, allelúia, allelúia.";
	    $fr="Allez en paix, alléluia, alléluia.";
	    $laudes.="<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	elseif (($lat=="R/. Deo grátias.")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes"))) {
	    $lat="R/. Deo grátias, allelúia, allelúia.";
	    $fr="R/. Rendons grâces à Dieu, alléluia, alléluia.";
	    $laudes.="<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}

	else $laudes.="
	<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	$laudes.="</table>";
	$laudes= rougis_verset ($laudes);

	return $laudes;
}

?>
