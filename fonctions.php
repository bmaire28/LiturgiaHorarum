<?php

function rougis_verset($string) {
	$string1=str_replace("V/.", "<span style=\"color:red\">V/. </span>",$string);
	$string2= str_replace("R/.", "<span style=\"color:red\">R/. </span>",$string1);
	$string3= str_replace("+", "<span style=\"color:red\">&dagger;</span>",$string2);
	$string4= str_replace("*", "<span style=\"color:red\">*</span>",$string3);
	return $string4;
}

function epuration($string) {
	$string1=str_replace(chr(146),"'",$string);
	$string2=str_replace(chr(156), "&oelig;", $string1);
	return utf8_encode($string2);
}


function respbrevis($ref) {
	$row = 0;
	// Creation du chemin relatif vers le fichier de repons de facon brut
	$fichier="calendrier/liturgia/".$ref.".csv";
	// Vérification du chemin brut, sinon création du chemin relatif utf8
	if (!file_exists($fichier)) $fichier="calendrier/liturgia/".utf8_encode($ref).".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=epuration($data[0]);$francais=epuration($data[1]);
	    if($row==0) {
			$latin="<h2>$latin</h2>";
			$francais="<h2>$francais</h2>";
		}
		else {
			$latin="$latin";
			$francais="$francais";
		}
	    $row++;
	    $resp.="
		<tr><td>$latin</td><td>$francais</td></tr>";
	}
	fclose ($fp);
	return $resp;
}


function lectiobrevis($ref) {
	$row = 0;
	// Cr�ation du chemin relatif vers le fichier de lectio de fa�on brut
	$fichier="lectionnaire/".$ref.".csv";
	// V�rification du chemin brut, sinon cr�ation du chemin relatif utf8
	if (!file_exists($fichier)) $fichier="lectionnaire/".utf8_encode($ref).".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    if($row==0) {
			$latin="<h2>$latin</h2>";
			$francais="<h2>$francais</h2>";
		}
		else {
			$latin="$latin";
			$francais="$francais";
		}
	    $row++;
	    $lectio.="
		<tr><td>$latin</td><td>$francais</td></tr>";
	}
	fclose ($fp);
	return $lectio;
}


function preces($ref){
	$row = 0;
	// Cr�ation du chemin relatif vers le fichier de preces de fa�on brut
	$fichier="preces/".$ref.".csv";
	// V�rification du chemin brut, sinon cr�ation du chemin relatif utf8
	if (!file_exists($fichier)) $fichier="preces/".utf8_encode($ref).".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
	    $latin=$data[0];$francais=$data[1];
	    if($row==0) {
			$latin="<h2>$latin</h2>";
			$francais="<h2>$francais</h2>";
		}
		else {
			$latin="$latin";
			$francais="$francais";
		}
	    $row++;
	    $preces.="
		<tr><td>$latin</td><td>$francais</td></tr>";
	}
	fclose ($fp);
	return $preces;
}


function hymne($ref) {
	//print_r("<p>".$ref."</p>");
	$row = 0;

	// Initialisation de l'hymne a blanc
	$hymne="";

	// Creation du chemin relatif vers le fichier de l'hymne de facon brut
	$fichier="hymnaire/".$ref.".csv";

	// Verification du chemin brut, sinon creation du chemin relatif utf8
	if (!file_exists($fichier)) $fichier="hymnaire/".utf8_encode($ref).".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");

	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
    	$latin=$data[0];$francais=$data[1];
    	if($row==0) {
			$latin="<h2>$latin</h2>";
			$francais="<h2>$francais</h2>";
			}
		elseif ($latin=="") {
			$latin="&nbsp; ";
			$francais="&nbsp; ";
			}
		$row++;
    	$hymne.="<tr><td  style=\"text-align: center;\">$latin</td><td  style=\"text-align: center;\">$francais</td></tr>";
		}
	fclose ($fp);
	$hymne.="<tr><td  style=\"text-align: center;\">&nbsp;</td><td  style=\"text-align: center;\">&nbsp;</td></tr>";
	return $hymne;
}


function psaume($ref) {
	$row = 0;
	// Création du chemin relatif vers le fichier du psaume de façon brut
	$fichier="psautier/".$ref.".csv";
	// Vérification du chemin brut, sinon création du chemin relatif utf8
	if (!file_exists($fichier)) $fichier="psautier/".utf8_encode($ref).".csv";
	if (!file_exists($fichier)) print_r("<p> reference : ".$ref." fichier :".$fichier." introuvable !</p>");
	$fp = fopen ($fichier,"r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$latin="";
	    if (($row==0)&&($data[0]!="")) {
			$latin="<h2>$data[0]</h2>";
			$francais="<h2>$data[1]</h2>";
	    }
	    elseif (($row==1)&&($data[0]!="")) {
			$latin="<h3>$data[0]</h3>";
	        $francais="<h3>$data[1]</h3>";
	    }
	    elseif (($row==2)&&($data[0]!="")) {
			$lat=$data[0];
	    	$fr=$data[1];
	    	$latin="<h4>$lat</h4>";
	        $francais="<h4>$fr</h4>";
	    }
	    elseif (($row==3)&&($data[0]!="")) {
			$latin="<h2>$data[0]</h2>";
	        $francais="<h2>$data[1]</h2>";
	    }
	    else {
	    	$latin=$data[0];
	    	$francais=$data[1];
	    }
	    $psaume .="
	    			<tr>
	    				<td>$latin</td>
	    				<td>$francais</td>
	    			</tr>";
	    $row++;
	}
	fclose ($fp);
	return $psaume;
}

function maj($filename) {

    $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
 	$allowedTags.='<li><ol><ul><span><div><br><ins><del><font><table><tr><td><align>';
    $filename=$_GET['filename'];
        //unlink($filename);
    $fd=fopen($filename,"w");
        //ecriture du fichier mis � jour
    $sContent = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
    fwrite($fd, $sContent);
    fclose($fd);
}


function edit($filename) {
$fd = @fopen ($filename, "r");
$sContent = @fread ($fd, filesize ($filename));
$sContent = nl2br($sContent);
@fclose ($fd);
$date=$_GET['date'];
$task=$_GET['task'];


print"
<script language=\"javascript\" type=\"text/javascript\" src=\"mambots/editors/tinymce/jscripts/tiny_mce/tiny_mce.js\"></script>
<script language=\"javascript\" type=\"text/javascript\">
  tinyMCE.init({
mode : \"textareas\",
	theme : \"advanced\",
	plugins : \"table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu\",
	theme_advanced_buttons1_add_before : \"save,separator\",
	theme_advanced_buttons1_add : \"fontselect,fontsizeselect\",
	theme_advanced_buttons2_add : \"separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor\",
	theme_advanced_buttons2_add_before: \"cut,copy,paste,separator,search,replace,separator\",
	theme_advanced_buttons3_add_before : \"tablecontrols,separator\",
	theme_advanced_buttons3_add : \"emotions,iespell,flash,advhr,separator,print\",
	theme_advanced_toolbar_location : \"top\",
	theme_advanced_toolbar_align : \"left\",
	theme_advanced_path_location : \"bottom\",
	plugin_insertdate_dateFormat : \"%Y-%m-%d\",
	plugin_insertdate_timeFormat : \"%H:%M:%S\",
	extended_valid_elements : \"a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]\",
	external_link_list_url : \"example_data/example_link_list.js\",
	external_image_list_url : \"example_data/example_image_list.js\",
	flash_external_list_url : \"example_data/example_flash_list.js\"
  });

  function myFileBrowser (field_name, url, type, win) {
    var fileBrowserWindow = new Array();
    fileBrowserWindow['title'] = 'File Browser';
    fileBrowserWindow['file'] = \"my_cms_script.php\" + \"?type=\" + type;
    fileBrowserWindow['width'] = '420';
    fileBrowserWindow['height'] = '400';
    tinyMCE.openWindow(fileBrowserWindow, { window : win, resizable : 'yes', inline : 'yes' });
    return false;
  }
</script>
 <form method=\"post\" action=\"index.php?date=$date&task=$task&maj=1&filename=$filename\">
  <textarea id=\"elm1\" name=\"elm1\" rows=\"80\" cols=\"60\">$sContent</textarea>
<br />
<input type=\"submit\" name=\"save\" value=\"Submit\" />
<input type=\"reset\" name=\"reset\" value=\"Reset\" />
</form>
";
}


function affiche_nav($do,$office,$place) {

	/*
	 * Affichage $_GET
	 *
	foreach ($_GET as $param)
	{
		print_r("<p>".$param."</p>");
	}
	*/

	// Initialisation des variables de date
	//par defaut $do est la date du jour
	$anno=substr($do,0,4);
	$mense=substr($do,4,2);
	$die=substr($do,6,2);
	$day=mktime(12,0,0,$mense,$die,$anno);
	//$dts=mktime(12,0,0,$mense,$die,$anno);
	$dtsmoinsun=$day-60*60*24;
	$dtsplusun=$day+60*60*24;
	$hier=date("Ymd",$dtsmoinsun);
	$demain=date("Ymd",$dtsplusun);

	$dsuiv=$day+(60*60*24); // date jour suivant
	$dprec=$day-(60*60*24); // date jour precedent

	// Tableau de la liste des offices par ordre chronologique
	$offices=array("p","laudes","tierce","sexte","none","vepres","complies","s");

	// Recuperation du numero d'ordre de l'office actuel par rapport au tableau
	for($o=0;$offices[$o];$o++) {
		if ($office==$offices[$o]) {
			$officeactuel=$o;
			break;
		}
	}
	// definition des offices suivant et precedent de l'actuel
	$suivant = $offices[$officeactuel+1];
	$precedent = $offices[$officeactuel-1];

	// par defaut, la date de l'office suivant est la meme que la date de l'office actuel $do
	// idem pour la date de l'office precedent
	// $date_suiv=$do;
	// $date_prec=$do;

	// si l'office suivant est s, alors il faut changer la date de l'office suivant
	// idem pour l'office precedent
	// if ($suivant=="s") {
	// 	$suivant = "laudes";
	// 	$date_suiv=date("Ymd",$dsuiv);
	// }
	// if ($precedent=="p") {
	// 	$precedent = "complies";
	// 	$date_prec= date("Ymd",$dprec);
	// }

	// Date pour l'office des défunts :
	$date_defunts=$anno."1102";

	// date du jour :
	$tfc=time();
	$date_aujourdhui=date("Ymd",$tfc);
	$annee_aujourdhui=substr($date_aujourdhui,0,4);
	$mois_aujourdhui=substr($date_aujourdhui,4,2);

	//rite
	if (!$_GET['rite']) $rite="romain";
	else $rite=$_GET['rite'];

	// reinit de $_GET
    if ($place == "pied") {
        unset($_GET['rite']);
        unset($_GET['date']);
        unset($_GET['office']);
    }


	print"<div id=\"$place\">\n";
	print "<form method=\"get\">\n";

	//conservation des valeurs de départ
	print "<input type=\"hidden\" name=\"date\" value=\"$do\">\n";
	//print "<input type=\"hidden\" name=\"office\" value=\"$office\">";

	//choix du rit
	if ($rite=="romain") {
		print "<input type=\"radio\" name=\"rite\" value=\"romain\" checked>Romain\n";
		print "<input type=\"radio\" name=\"rite\" value=\"monastique\"> Monastique<br />\n";
	}
	else {
		print "<input type=\"radio\" name=\"rite\" value=\"romain\">Romain\n";
		print "<input type=\"radio\" name=\"rite\" value=\"monastique\" checked> Monastique<br />\n";
	}

	// choix de l'office
	switch ($office) {
		case "laudes" :
			print "<input type=\"radio\" name=\"office\" value=\"laudes\" checked>Laudes\n";
			print "<input type=\"radio\" name=\"office\" value=\"tierce\"> Tierce\n";
			print "<input type=\"radio\" name=\"office\" value=\"sexte\"> Sexte\n";
			print "<input type=\"radio\" name=\"office\" value=\"none\"> None\n";
			print "<input type=\"radio\" name=\"office\" value=\"vepres\"> V&ecirc;pres\n";
			print "<input type=\"radio\" name=\"office\" value=\"complies\"> Complies<br />\n";
			break;
		case "tierce" :
			print "<input type=\"radio\" name=\"office\" value=\"laudes\">Laudes\n";
			print "<input type=\"radio\" name=\"office\" value=\"tierce\" checked> Tierce\n";
			print "<input type=\"radio\" name=\"office\" value=\"sexte\"> Sexte\n";
			print "<input type=\"radio\" name=\"office\" value=\"none\"> None\n";
			print "<input type=\"radio\" name=\"office\" value=\"vepres\"> V&ecirc;pres\n";
			print "<input type=\"radio\" name=\"office\" value=\"complies\"> Complies<br />\n";
			break;
		case "sexte" :
			print "<input type=\"radio\" name=\"office\" value=\"laudes\">Laudes\n";
			print "<input type=\"radio\" name=\"office\" value=\"tierce\"> Tierce\n";
			print "<input type=\"radio\" name=\"office\" value=\"sexte\" checked> Sexte\n";
			print "<input type=\"radio\" name=\"office\" value=\"none\"> None\n";
			print "<input type=\"radio\" name=\"office\" value=\"vepres\"> V&ecirc;pres\n";
			print "<input type=\"radio\" name=\"office\" value=\"complies\"> Complies<br />\n";
			break;
		case "none" :
			print "<input type=\"radio\" name=\"office\" value=\"laudes\">Laudes\n";
			print "<input type=\"radio\" name=\"office\" value=\"tierce\"> Tierce\n";
			print "<input type=\"radio\" name=\"office\" value=\"sexte\"> Sexte\n";
			print "<input type=\"radio\" name=\"office\" value=\"none\" checked> None\n";
			print "<input type=\"radio\" name=\"office\" value=\"vepres\"> V&ecirc;pres\n";
			print "<input type=\"radio\" name=\"office\" value=\"complies\"> Complies<br />\n";
			break;
		case "vepres" :
			print "<input type=\"radio\" name=\"office\" value=\"laudes\">Laudes\n";
			print "<input type=\"radio\" name=\"office\" value=\"tierce\"> Tierce\n";
			print "<input type=\"radio\" name=\"office\" value=\"sexte\"> Sexte\n";
			print "<input type=\"radio\" name=\"office\" value=\"none\"> None\n";
			print "<input type=\"radio\" name=\"office\" value=\"vepres\" checked> V&ecirc;pres\n";
			print "<input type=\"radio\" name=\"office\" value=\"complies\"> Complies<br />\n";
			break;
		case "complies" :
		case "" :
			print "<input type=\"radio\" name=\"office\" value=\"laudes\">Laudes\n";
			print "<input type=\"radio\" name=\"office\" value=\"tierce\"> Tierce\n";
			print "<input type=\"radio\" name=\"office\" value=\"sexte\"> Sexte\n";
			print "<input type=\"radio\" name=\"office\" value=\"none\"> None\n";
			print "<input type=\"radio\" name=\"office\" value=\"vepres\"> V&ecirc;pres\n";
			print "<input type=\"radio\" name=\"office\" value=\"complies\" checked> Complies<br />\n";
			break;
	}
	print "\n<button type=\"submit\" name=\"office\" value=\"$precedent\">Prec.</button>\n";
	print "<button type=\"submit\">Charger</button>\n";
	print "<button type=\"submit\" name=\"date\" value=\"$date_defunts\">Office des defunts</button>\n";
	print "<button type=\"submit\" name=\"date\" value=\"$date_aujourdhui\">Aujourd'hui</button>\n";
	print "<button type=\"submit\" name=\"office\" value=\"$suivant\">Suiv.</button>\n";
	print "</form></br>\n";
}



?>
