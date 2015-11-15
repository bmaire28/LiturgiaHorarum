<?php

function laudes($jour,$calendarium,$my) {

if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
	$temp['ps1']['latin']="ps62";
	$temp['ps2']['latin']="AT41";
	$temp['ps3']['latin']="ps149";
}

$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");
	
$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
$jrdelasemaine=date("w",$day);
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];
	
$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];

/*
 * Calcul de la lettre de l'année
 * récupérer l'année du 27 novembre précédent
 * diviser l'année par 3 et regarder le reste
 * 0 = A, 1 = B, 2 = C
 */
$num_mois_cour=intval($mense);
$num_annee_cour=intval($anno);
$num_jour_cour=intval($die);
//print_r("année : ".$num_annee_cour."<br>mois : ".$num_mois_cour."<br>jour : ".$num_jour_cour);
//print_r("<br>reste :".fmod($num_annee_cour, 3)."<br>");

// si nous sommes avant novembre ou en novembre avant le 27, nous sommes dans l'année liturgique précédente
if ($num_mois_cour < 11) $num_annee_cour=$num_annee_cour-1;
if (($num_mois_cour == 11)&&($num_jour_cour < 27)) $num_annee_cour=$num_annee_cour-1;

switch (fmod($num_annee_cour, 3)) {
case 0 :
$lettre="A";
break;
		case 1:
		$lettre="B";
		break;
		case 2:
		$lettre="C";
		break;
}
//print_r($lettre."<br>");
	
/*
 * Déterminer le temps liturgique :
 * $psautier prend la caleur du temps liturgique abrégé
 * 
 * Ouvrir et charger le propre du jour dans $var:
 * $q prend la valeur du nom du fichier en fonction du temps liturgique, du numéro de semaine et du jour :
 * - temps liturgique via $psautier
 * - numéro de la semaine soit dans $psautier pour Pascal et Carême, soit 1 à 4
 * - jour de la semaine de 1 pour Dimanche à 7 pour Samedi
 * 
 */
$tem=$calendarium['tempus'][$jour];
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
$fp = fopen ("propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$latin=$data[1];$francais=$data[2];
	$var[$id]['latin']=$latin;
	$var[$id]['francais']=$francais;
	$row++;
}
fclose($fp);

/*
 * Chargement du psautier du jour
 */

$fp=fopen("propres_r/commune/psautier_".$spsautier.$jrdelasemaine.".csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$id=$data[0];$ref=$data[1];
	$reference[$id]=$ref;
	$row++;
}
fclose($fp);

/*
 * Vérifier qu'il n'y a pas de saint à célébrer
 * Chargement du propre du sanctoral dans $propre
 * 
 */

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
	if($propre['HYMNUS_laudes']['latin']) $hymne = $propre['HYMNUS_laudes']['latin'];
	if($propre['LB_matin']['latin']) $LB_matin=$propre['LB_matin']['latin'];
	if($propre['RB_matin']['latin']) $RB_matin=$propre['RB_matin']['latin'];
}


/*
 * Vérifier qu'il n'y a pas une solennité
 * Chargement du propre du temporal spécifique dans $temp
 *
 */

if($calendarium['temporal'][$jour]) {
	$tempo=$calendarium['temporal'][$jour];
	$fp = fopen ("propres_r/temporal/".$tempo.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
	    $temp[$id]['latin']=$data[1];
	    $temp[$id]['francais']=$data[2];
	    $row++;
	}
	$LB_matin=$temp['LB_matin']['latin'];
	$oratiolat=$temp['oratio']['latin'];
	$oratiofr=$temp['oratio']['francais'];
	$hymne=$temp['HYMNUS_laudes']['latin'];
	$benedictus="benedictus_".$lettre;
	$benelat=$temp[$benedictus]['latin'];
	if(!$benelat) $benelat=$temp['benedictus']['latin'];
	$benefr=$temp[$benedictus]['francais'];
	if(!$benefr) $benefr=$temp['benedictus']['francais'];
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
}



/*
 * Chargement du squelette des Laudes dans $lau
 * remplissage de $laudes pour l'affichage de l'office
 *
 */

$row = 0;
$fp = fopen ("offices_r/laudes.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
	$lau[$row]['latin']=$latin;
	$lau[$row]['francais']=$francais;
	$row++;
}
$max=$row;
$laudes="<table bgcolor=#FEFEFE>";
for($row=0;$row<$max;$row++){
	$lat=$lau[$row]['latin'];
	$fr=$lau[$row]['francais'];
	
	// Suppression de l'Alléluia en Carême et semaine Sainte
	if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")) {
		$lat="";
		$fr="";
	}
	
	switch ($lat) {
		case "#JOUR" :
			$pr_lat=$propre['jour']['latin'];
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
			break;
		
		case "#HYMNUS" :
			if(!$hymne) $laudes.=hymne($var['HYMNUS_laudes']['latin']);
			else $laudes.= hymne($hymne);
			break;
		
		case "#ANT1*":
			if($propre['ant1']['latin']) {
				$antlat=nl2br($propre['ant1']['latin']);
				$antfr=nl2br($propre['ant1']['francais']);
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 1 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 1</font> $antfr</td></tr>";
			}
			elseif ($temp['ant1']['latin']) {
				$antlat=nl2br($temp['ant1']['latin']);
				$antfr=nl2br($temp['ant1']['francais']);
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 1 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 1</font> $antfr</td></tr>";
			}
			else {
				$antlat=$var['ant1']['latin'];
				$antfr=$var['ant1']['francais'];
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 1 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 1</font> $antfr</td></tr>";
			}
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
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			}
			elseif($temp['ant1']['latin']) {
				$antlat=nl2br($temp['ant1']['latin']);
				$antfr=nl2br($temp['ant1']['francais']);
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			}
			else {
				$antlat=$var['ant1']['latin'];
				$antfr=$var['ant1']['francais'];
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			}
			break;
		
		case "#ANT2*":
			if($propre['ant2']['latin']) {
				$antlat=nl2br($propre['ant2']['latin']);
				$antfr=nl2br($propre['ant2']['francais']);
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 2</font> $antfr</td></tr>";
			}
			elseif($temp['ant2']['latin']) {
				$antlat=nl2br($temp['ant2']['latin']);
				$antfr=nl2br($temp['ant2']['francais']);
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 2</font> $antfr</td></tr>";
			}
			else {
				$antlat=$var['ant2']['latin'];
				$antfr=$var['ant2']['francais'];
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 2 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 2</font> $antfr</td></tr>";
			}
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
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			}
			elseif($temp['ant2']['latin']) {
				$antlat=nl2br($temp['ant2']['latin']);
				$antfr=nl2br($temp['ant2']['francais']);
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			}
			else {
				$antlat=$var['ant2']['latin'];
				$antfr=$var['ant2']['francais'];
				$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			}
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
			$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. 3 </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. 3</font> $antfr</td></tr>";
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
			$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$antlat</td><td id=\"coldroite\"><font color=red>Ant. </font> $antfr</td></tr>";
			break;
		
		case "#LB":
			if ($LB_matin) $lectiobrevis=lectiobrevis($LB_matin);
			else $lectiobrevis =lectiobrevis($var['LB_matin']['latin']);
			$laudes.=$lectiobrevis;
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
			$laudes.="<tr><td id=\"colgauche\"><font color=red><center><b>Responsorium Breve</b></center></font></td><td id=\"coldroite\"><font color=red><center><b>R�pons bref</center></b></font></td></tr>
	    		<tr><td id=\"colgauche\">$rblat</td><td id=\"coldroite\">$rbfr</td></tr>";
			break;
		
		case "#ANT_BENE":
			if($propre['benedictus']['latin']) {
				$benelat=$propre['benedictus']['latin'];
				$benefr=$propre['benedictus']['francais'];
			}
			else {
				if(!$benelat) $benelat=$var['benedictus']['latin'];
				if(!$benefr) $benefr=$var['benedictus']['francais'];
			}
			$laudes.="<tr><td id=\"colgauche\"><font color=red>Ant. </font>$benelat</td><td id=\"coldroite\"><font color=red>Ant. </font> $benefr</td></tr>";
			break;
		
		case "#BENEDICTUS":
			$laudes.=psaume("benedictus");
			break;
		
		case "#PRECES":
			if($propre['preces_matin']['latin']) $preces=$propre['preces_matin']['latin'];
			if($temp['preces_matin']['latin']) $preces=$temp['preces_matin']['latin'];
			else $preces=$var['preces_matin']['latin'];
			$laudes.=preces($preces);
			break;
		
		case "#PATER":
			$laudes.=psaume("pater");
			break;
		
		case "#ORATIO":
			if (!$oratiolat) {
				$oratiolat=$var['oratio_laudes']['latin'];
				$oratiofr=$var['oratio_laudes']['francais'];
			}
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
			$laudes.="<tr><td id=\"colgauche\">$oratiolat</td><td id=\"coldroite\">$oratiofr</td></tr>";
			break;
		
		case "Ite in pace. ":
			if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")) {
				$lat="Ite in pace, allel&uacute;ia, allel&uacute;ia.";
				$fr="Allez en paix, all&eacute;luia, all&eacute;luia.";
				$laudes.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
			}
			else $laudes.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
			break;
		
		case "R/. Deo gr�tias.":
			if (($calendarium['hebdomada'][$jour]=="Infra octavam paschae")or($calendarium['temporal'][$jour]=="Dominica Pentecostes")) {
				$lat="R/. Deo gr&aacute;tias, allel&uacute;ia, allel&uacute;ia.";
				$fr="R/. Rendons gr&acirc;ces &agrave; Dieu, all&eacute;luia, all&eacute;luia.";
				$laudes.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
			}
			else $laudes.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
			break;
		
		default:
			$laudes.="<tr><td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
			break;
	}
}
$laudes.="</table>";
$laudes= rougis_verset ($laudes);

return $laudes;
}

?>
