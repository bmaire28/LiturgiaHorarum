<?php

function preface ($agenda,$today,$journee) {

switch ($agenda['tempus'][$today]){
	case "Tempus Quadragesimae":
		switch ($journee){
			case "Dominica":
				$preface=$agenda['temporal'][$today];
			break;
			case "Feria secunda":
				$preface=1;
			break;
			case "Feria tertia":
				$preface=2;
			break;
			case "Feria quarta":
				if($agenda['temporal'][$today]=="Feria IV Cinerum") $preface=4;
				else $preface=3;
			break;
			case "Feria quinta":
				$preface=5;
			break;
			case "Feria sexta":
				$preface=4;
			break;
			case "Sabato":
				$preface=1;
			break;
			default: $preface=1;
		}
		if(($journee!="Dominica")&&($agenda['hebdomada'][$today]=="Hebdomada V Quadragesimae"))$preface=5;
	break; //Fin cas Quadragesimae

	case "Tempus passionis":
		switch ($journee){
			case "Dominica":
				$preface="DOMINICA IN PALMIS DE PASSIONE DOMINI";
			break;
			default: $preface=1;
		}
	break; //fin cas Hebdomada sancta

	case "Tempus per annum":
		switch ($journee){
			case "Dominica":
				$preface=1;
			break;
			case "Feria secunda":
				$preface=2;
			break;
			case "Feria tertia":
				$preface=3;
			break;
			case "Feria quarta":
				$preface=4;
			break;
			case "Feria quinta":
				$preface=5;
			break;
			case "Feria sexta":
				$preface=6;
			break;
			case "Sabato":
				$preface=7;
			break;
			default: $preface=8;
		}
		if(($journee!="Dominica")&&($agenda['hebdomada'][$today]=="Hebdomada V Quadragesimae"))$preface=5;
	break; //Fin cas Quadragesimae

}

//en fonction du temps liturgique
// au temps ordianire : au choix
// au temps pascal, au choix entre 3 et 4 pour les féries, 1 et 2 pour les dimanches, sinon celle du temporal, sauf 5e semaine
// semaine sainte : temporal le dimanche, n°2 les féries
//temps pascal : temporal à Pâques et octave + in albis, au choix le reste ud temps
//  
//en fonction du jour de la semaine
//inclue dans le propre ou dans le temporal

return $preface;
}

function rougis($string) {
$string1=str_replace("V/.", "<font color=red>V/.</font>",$string);
$string2= str_replace("R/.", "<font color=red>R/.</font>",$string1);
$string3= str_replace("Diaconus", "<font color=red>Diaconus</font>",$string2);
$string4= str_replace("le Diacre", "<font color=red>le Diacre</font>",$string3);
$string5= str_replace("Ant.", "<font color=red>Ant.</font>",$string4);
$string6= str_replace("Ps.", "<font color=red>Ps.</font>",$string5);
$string7= str_replace("Sacerdos", "<font color=red>Sacerdos</font>",$string6);
$string8= str_replace("le Prêtre", "<font color=red>le Prêtre</font>",$string7);
return $string8;
}

function lecture($ref) {
	$row = 0;
	$fp = fopen ("calendrier/liturgia/messe/lectio/$ref.csv","r");
	while ($data = fgetcsv ($fp, 10000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    switch ($row) {
	    	case 0 :
	    		$latin="<center><font color=red>$latin</font></center>";
				$francais="<center><font color=red>$francais</font></center>";
			break;
			
			default :
				$latin=$latin;
				$francais=$francais;
			break;
	    }
		$row++;
	    $lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$francais</td></tr>";
	}
	fclose ($fp);
	return $lectio;
}

function lecture_1($ref) {
	$row = 0;
	$fp = fopen ("calendrier/liturgia/messe/lectio/$ref.csv","r");
	while ($data = fgetcsv ($fp, 10000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    switch ($row){
	    	case 0 :
	    		$latin="<center><font color=red>$latin</font></center>";
				$francais="<center><font color=red>$francais</font></center>";
	    	break; //fin de la row0
	    	
	    	case 1 :
				$latin="In illo tempore, ".$latin;
				$francais="En ce temps-là, ".$francais;
			break; //fin de la row 1
	    	
			default :
				$latin=$latin;
				$francais=$francais;
			break; //fin de la row default
	    }
	    $row++;
	    $lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$francais</td></tr>";
	}
	fclose ($fp);
	return $lectio;
}

function lecture_2($ref) {
	$row = 0;
	$fp = fopen ("calendrier/liturgia/messe/lectio/$ref.csv","r");
	while ($data = fgetcsv ($fp, 10000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    switch ($row){
	    	case 0 :
	    		$latin="<center><font color=red>$latin</font></center>";
				$francais="<center><font color=red>$francais</font></center>";
	    	break; //fin de la row0
	    	
	    	case 1 :
				$latin="Fratres , ".$latin;
				$francais="Frères, ".$francais;
			break; //fin de la row 1
	    	
			default :
				$latin=$latin;
				$francais=$francais;
			break; //fin de la row default
	    }
	    $row++;
	    $lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$francais</td></tr>";
	}
	fclose ($fp);
	return $lectio;
}

function evangile($ref) {
	$row = 0;
	$fp = fopen ("calendrier/liturgia/messe/lectio/$ref.csv","r");
	while ($data = fgetcsv ($fp, 10000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    switch ($row){
	    	case 0 :
	    		$latin="<center><font color=red>$latin</font></center>";
				$francais="<center><font color=red>$francais</font></center>";
	    	break; //fin de la row0
	    	
	    	case 1 :
				$latin="Dixit Dominus : ".$latin;
				$francais="Ainsi parle le Seigneur : ".$francais;
			break; //fin de la row 1
	    	
			default :
				$latin=$latin;
				$francais=$francais;
			break; //fin de la row default
	    }
	    $row++;
	    $lectio.="
		<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$francais</td></tr>";
	}
	fclose ($fp);
	return $lectio;
}

function propre($ref) {
	$gloria=false;
	$row = 0;
	$fp = fopen ("calendrier/liturgia/messe/chants/$ref.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    if($row==0) {
	    	if ($latin=="Hymnus") $gloria=true;
			$latin="<center><font color=red>$latin</font></center>";
			$francais="<center><font color=red>$francais</font></center>";
		}
		elseif ($latin=="") {
			$latin="&nbsp; ";
			$francais="&nbsp; ";
			}
	    $row++;
	    if ($gloria) $hymne.="<tr><td id=\"colgauche\"><center>$latin</center></td><td id=\"coldroite\"><center>$francais</center></td></tr>";
	    else $hymne.="<tr><td id=\"colgauche\">$latin</td><td id=\"coldroite\">$francais</td></tr>";
	}
	fclose ($fp);
	return $hymne;
}

function bene_sol($string) {
	$string1=str_replace("R. Amen.", "</b><font color=red><br>R/.</font> Amen.<br><b>",$string);
	return $string1;
}


function oraison($text_lat,$text_fr) {
	$text_lat="<b>".$text_lat;
	$text_fr="<b>".$text_fr;
switch (substr($text_lat,-11)){
	case "er Dóminum.":
		$text_lat=str_replace(" Per Dóminum.", " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.</b>",$text_lat);
		$text_fr.=" Par notre Seigneur Jésus-Christ, ton Fils, qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.</b>";
	break;
	case " Qui tecum.":
		$text_lat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.</b>",$text_lat);
		$text_fr.=" Lui qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.</b>";
	break;
	case " Qui vivis.":
		$text_lat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sæcula sæculórum.</b>",$text_lat);
		$text_fr.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.</b>";
	break;
	case " Qui vivit.":
		$text_lat=str_replace(" Qui vivit.", " Qui vivit et regnat in saecula saeculórum.</b>",$text_lat);
		$text_fr.=" Lui qui vit et règne pour les siècles des siècles.</b>";
	break;
	case "r Christum.":
		$text_lat=str_replace(" Per Christum.", "  Per Christum Dóminum nostrum.</b>",$text_lat);
		$text_fr.=" Par le Christ notre Seigneur.</b>";
	break;
}
$oraison="<tr><td id=\"colgauche\">$text_lat</td><td id=\"coldroite\">$text_fr</td></tr>";
return $oraison;
}



?>
