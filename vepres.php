<?php

function vepres($jour,$calendarium,$my) {
	//print_r($calendarium);
	//print_r($calendarium['hebdomada'][$jour]);
	if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
	    $temp['ps7']['latin']="ps109";
		$temp['ps8']['latin']="ps113A";
		$temp['ps9']['latin']="NT12";
	}
/*if(!$my->email) {
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
        print"<br><i>Cet office n'est pas encore compl&egrave;tement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider &agrve; compl&eacute;ter ce travail.</a></i>";
        return;
        break;

}

$jours_l = array("Dominica, ad II ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, ad I ");
$jours_fr=array("Le Dimanche aux IIes ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche aux I�res ");

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

//print_r($calendarium['rang'][$jour]);
if($calendarium['rang'][$jour]) {
	    $prop=$mense.$die;
	    //print_r($prop);
	    $fp = fopen ("propres_r/sanctoral/".$prop.".csv","r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
	    	$id=$data[0];
	    	$propre[$id]['latin']=$data[1];
	    	$propre[$id]['francais']=$data[2];
	    	$row++;
		}
		fclose($fp);
		if($propre['HYMNUS_vepres']['latin']) $hymne=$propre['HYMNUS_vepres']['latin'];
	    //print"<br>['HYMNUS_laudes']['latin'] : ".$propre['HYMNUS_laudes']['latin'];
		if($propre['LB_soir']['latin']) $LB_soir=$propre['LB_soir']['latin'];
		if($propre['RB_soir']['latin']) $RB_soir=$propre['RB_soir']['latin'];
		if($propre['jour']['latin']) $pr_lat=$propre['jour']['latin'];
		if($propre['jour']['francais'])	$pr_fr=$propre['jour']['francais'];
		if($propre['intitule']['latin']) $intitule_lat=$propre['intitule']['latin'];
    	if($propre['intitule']['francais']) $intitule_fr=$propre['intitule']['francais'];
    	if($propre['rang']['latin']) $rang_lat=$propre['rang']['latin'];
    	if($propre['rang']['francais']) $rang_fr=$propre['rang']['francais'];
    	if($propre['preces_soir']['latin']) $preces=$propre['preces_soir']['latin'];
	}

	$fp = fopen ("calendrier/liturgia/jours.csv","r");
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
	//print"<br>".$calendarium['temporal'][$jour];
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
		$yy=$temp['magnificat']['francais'];
		print"<br>$yy";
		$oratiolat=$temp['oratio']['latin'];
		$oratiofr=$temp['oratio']['francais'];
		$LB_soir=$temp['LB_soir']['latin'];
		$magniflat=$temp['magnificat']['latin'];
		$magniffr=$temp['magnificat']['francais'];
		if (!$magniflat)$magniflat=$temp['2magnificat_C']['latin'];
		if (!$magniffr) $magniffr=$temp['2magnificat_C']['francais'];
		//$magniffr=$temp['2magnificat_C']['francais'];

		$intitule_lat=$temp['intitule']['latin'];
		$rang_lat=$temp['rang']['latin'];
		if($rang_lat)$intitule_lat .="</b><br>".$rang_lat."<b>";
		
		$intitule_fr=$temp['intitule']['francais'];
		
		$rang_fr=$temp['rang']['francais'];
		if($rang_fr)$intitule_fr .="</b><br></b>".$rang_fr."<b>";
		
		if (($intitule_lat == "FERIA QUARTA CINERUM")||($intitule_lat == "DOMINICA RESURRECTIONIS")||($intitule_fr == "TRIDUUM PASCAL<br>VENDREDI SAINT")||($intitule_fr == "TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l=$intitule_lat."<br> ad ";
		else $date_l = $intitule_lat."<br> ad II ";
		//if ($intitule_fr != "JEUDI SAINT")$date_l = $intitule_lat."<br> ad II ";
		//else

		if (($intitule_lat == "FERIA QUARTA CINERUM")||($intitule_lat == "DOMINICA RESURRECTIONIS")||($intitule_fr == "TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr=$intitule_fr."<br> aux ";
		else $date_fr = $intitule_fr."<br> aux IIes ";
		//if ($intitule_fr != "JEUDI SAINT")$date_fr = $intitule_fr."<br> aux IIes ";
		//else
		
		
		$hymne=$temp['HYMNUS_vepres']['latin'];
  		$preces=$temp['preces_soir']['latin'];
  		//print"<br>".$oratiolat;
		//print_r($tempo);
	}

	$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);
if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])) {
	///////////////////////////////////
	/// il y a des 1�res v�pres  //////
	///////////////////////////////////
	//print"<br>1�res v�pres demain. Aujourd'hui : $jour ; Demain :  $demain <br>";
	//print_r($calendarium['priorite']);
	//if  print "propre";
	$propre=null;
	$tempo=$calendarium['temporal'][$demain];
	    $fp = fopen ("propres_r/temporal/".$tempo.".csv","r");
	    //$fp = fopen ("propres_r/temporal/".$prop.".csv","r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
	    $id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
		}
		//print_r($temp);
		$intitule_lat=$temp['intitule']['latin'];
		$rang_lat=$temp['rang']['latin'];
		if($rang_lat)$intitule_lat .="</b><br>".$rang_lat."<b>";
		
		$date_l = $intitule_lat."<br> ad I ";
		$intitule_fr=$temp['intitule']['francais'];
		$rang_fr=$temp['rang']['francais'];
		if($rang_fr)$intitule_fr .="</b><br></b>".$rang_fr."<b>";
		$date_fr = $intitule_fr."<br> aux I�res ";
		$oratiolat=$temp['oratio']['latin'];
		$oratiofr=$temp['oratio']['francais'];
		$magniflat=$temp['pmagnificat_C']['latin'];
		$magniffr=$temp['pmagnificat_C']['francais'];
	$hymne=$temp['HYMNUS_1V']['latin'];
	$temp['ant7']['latin']=$temp['ant01']['latin'];
	$temp['ant7']['francais']=$temp['ant01']['francais'];
	$temp['ant8']['latin']=$temp['ant02']['latin'];
	$temp['ant8']['francais']=$temp['ant02']['francais'];
	$temp['ant9']['latin']=$temp['ant03']['latin'];
	$temp['ant9']['francais']=$temp['ant03']['francais'];
	$temp['ps7']['latin']=$temp['ps01']['latin'];
	$temp['ps7']['francais']=$temp['ps01']['francais'];
	$temp['ps8']['latin']=$temp['ps02']['latin'];
	$temp['ps8']['francais']=$temp['ps02']['francais'];
	$temp['ps9']['latin']=$temp['ps03']['latin'];
	$temp['ps9']['francais']=$temp['ps03']['francais'];
	$LB_soir=$temp['LB_1V']['latin'];
	$temp['RB_soir']['latin']=$temp['RB_1V']['latin'];
	$temp['RB_soir']['francais']=$temp['RB_1V']['francais'];
	$pr_lat=null;
	$pr_fr=null;
	$intitule_lat=null;
    $intitule_fr=null;
    $preces=null;
}



	// format $jour=AAAAMMJJ
	$row = 0;
	$fp = fopen ("offices_r/vepres.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    $vesp[$row]['latin']=$latin;
	    $vesp[$row]['francais']=$francais;
	    $row++;
	}
	$max=$row;
	$vepres="
	<table bgcolor=#FEFEFE>";
	for($row=0;$row<$max;$row++){
	    $lat=$vesp[$row]['latin'];
	    $fr=$vesp[$row]['francais'];
	    if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
			$lat="";
			$fr="";
			}
        if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")) {
			$lat="";
			$fr="";
			}
	if($lat=="#JOUR") {

	    if($pr_lat){
            $vepres.="<tr><td width=49%><center><b>$pr_lat</b></center></td>";
            $vepres.="<td width=49%><center><b>$pr_fr</b></center></td></tr>";
        	$vepres.="<tr><td width=49%><center><b> $intitule_lat</b></center></td><td width=49%><center><b>$intitule_fr</b></center></td></tr>";
        	$vepres.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";
        	$vepres.="<tr><td width=49%><center><font color=red><b>Ad Vesperas</b></font></center></td>";
			$vepres.="<td width=49%><b><center><font color=red><b>Aux V�pres</b></font></center></td></tr>";
			$oratiolat=$propre['oratio']['latin'];
			$oratiofr=$propre['oratio']['francais'];
	    }
	else {
		//$l=$jo[2]['latin'];
	    //$f=$jo[2]['francais'];
	    //$date_l=$intitule_lat;
	    //$date_fr=$intitule_fr;
		$vepres.="<tr><td width=49%><center><font color=red><b>$date_l Vesperas</b></font></center></td>";
		$vepres.="<td width=49%><b><center><font color=red><b>$date_fr V�pres</b></font></center></td></tr>";
		}
	}

	elseif($lat=="#HYMNUS") {
		//print_r($hymne);
	    if(!$hymne) $hymne=$var['HYMNUS_vesperas']['latin'];
	    //else $hymne=$propre
	    $vepres.=hymne($hymne);
	    //$row++;
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. 1</font> $antlat</td><td id=\"coldroite\"><font color=red>Ant.1</font> $antfr</td></tr>";
	    //$row++;
	}

	elseif($lat=="#PS1"){
	    if($propre['ps7']['latin']) $psaume=$propre['ps7']['latin'];
	    elseif($temp['ps7']['latin']) $psaume=$temp['ps7']['latin'];
	    elseif($var['ps7']['latin']) $psaume=$var['ps7']['latin'];
	    else $psaume=$reference['ps7'];
	    $vepres.=psaume($psaume);
	    //$row++;
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant.2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant.2 </font> $antfr</td></tr>";
	    //$row++;
	}

	elseif($lat=="#PS2"){
	    if($propre['ps8']['latin']) $psaume=$propre['ps8']['latin'];
	    elseif($temp['ps8']['latin']) $psaume=$temp['ps8']['latin'];
	    elseif($var['ps8']['latin']) $psaume=$var['ps8']['latin'];
	    else $psaume=$reference['ps8'];
	    $vepres.=psaume($psaume);
	    	    //$row++;
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant.3 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant.3 </font> $antfr</td></tr>";
	    //$row++;
	}
	elseif($lat=="#PS3"){
	    if($propre['ps9']['latin']) $psaume=$propre['ps9']['latin'];
	    elseif($temp['ps9']['latin']) $psaume=$temp['ps9']['latin'];
	    elseif($var['ps9']['latin']) $psaume=$var['ps9']['latin'];
	    elseif($var['ps9']['latin']) $psaume=$var['ps9']['latin'];
	    else $psaume=$reference['ps9'];
	    $vepres.=psaume($psaume);
	    //$row++;
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
	    //$row++;
	}
	elseif($lat=="#LB"){
	    if($LB_soir) $lectiobrevis=$LB_soir;
		else $lectiobrevis=$var['LB_soir']['latin'];
	    $vepres.=lectiobrevis($lectiobrevis);
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
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red><center><b>Responsorium Breve</b></center></font></td><td id=\"coldroite\"><font color=red><center><b>R�pons bref</center></b></font></td></tr>
<tr>
	<td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>

	";

	    //$row++;
		//$laudes.=respbrevis("resp_breve_Christe_Fili_Dei_vivi");
	}
	elseif($lat=="#ANT_MAGN"){
	    if($propre['magnificat']['latin']) {
			$magniflat=$propre['magnificat']['latin'];
			$magniffr=$propre['magnificat']['francais'];
	    }
	    if($temp['magnificat']['latin']) {
			$magniflat=$temp['magnificat']['latin'];
			$magniffr=$temp['magnificat']['francais'];
	    }
	    else {
		if(!$magniflat) $magniflat=$var['magnificat']['latin'];
	    if(!$magniffr) $magniffr=$var['magnificat']['francais'];
	    }
	    $vepres.="
	    <tr>
	<td id=\"colgauche\"><font color=red>Ant. </font>$magniflat</td><td id=\"coldroite\"><font color=red>Ant. </font> $magniffr</td></tr>";
	    //$row++;
	}



	elseif($lat=="#MAGNIFICAT"){
	    $vepres.=psaume("magnificat");
	    //$row++;
	}
	elseif($lat=="#PRECES"){
	 	if (!$preces) $preces=$var['preces_soir']['latin'];
	    $vepres.=preces($preces);

	    //$vepres.=preces("preces_III");
	    //$row++;
	}
	elseif($lat=="#PATER"){
	    $vepres.=psaume("pater");
	    //$row++;
	}

	elseif($lat=="#ORATIO"){
	    if (!$oratiolat) {
			$oratiolat=$var['oratio_vesperas']['latin'];
	    	$oratiofr=$var['oratio_vesperas']['francais'];
	    }
	//print"<br> test";
		    if ((substr($oratiolat,-6))=="minum.") {
	        $oratiolat=str_replace(substr($oratiolat,-13), " Per D&oacute;minum nostrum Iesum Christum, F&iacute;lium tuum, qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Par notre Seigneur J&eacute;sus-Christ, ton Fils, qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }

        if ((substr($oratiolat,-11))==" Qui tecum.") {
	        $oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aeling;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Lui qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }


        if ((substr($oratiolat,-11))==" Qui vivis.") {
	        $oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aeling;cul&oacute;rum.",$oratiolat);
	    	$oratiofr.=" Toi qui vis et r&egrave;gnes avec Dieu le P&egrave;re dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
	    }


		// $rest = substr("abcdef", -2);    // returns "ef"

	    //$oratiolat=str_replace(" Per D�minum.", " Per D�minum nostrum Iesum Christum, F�lium tuum, qui tecum vivit et regnat in unit�te Sp�ritus Sancti, Deus, per �mnia s�cula s�cul�rum.",$oratiolat);
	    	//$oratiolat=$oratiolat2;
	    $vepres.="
	    <tr>
	<td id=\"colgauche\">$oratiolat</td><td id=\"coldroite\">$oratiofr</td></tr>";
	    //$row++;
	}
	//print $calendarium['hebdomada'][$do];
	//&&($calendarium['hebdomada'][$do]=="Infra octavam paschae")
 	elseif (($lat=="Ite in pace. ")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
	    $lat="Ite in pace, allel�ia, allel�ia.";
	    $fr="Allez en paix, all�luia, all�luia.";
	    $vepres.="<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	elseif (($lat=="R/. Deo gr�tias.")&&(($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")or($calendarium['temporal'][$demain]=="Dominica Pentecostes"))) {
	    $lat="R/. Deo gr�tias, allel�ia, allel�ia.";
	    $fr="R/. Rendons gr�ces � Dieu, all�luia, all�luia.";
	    $vepres.="<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}

	else $vepres.="
	<tr>
	<td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
	}
	$vepres.="</table>";
	$vepres= rougis_verset ($vepres);

	return $vepres;
}


?>
