<?php

function rougis_verset($string) {
$string1=str_replace("V/.", "<span style=\"color:red\">V/. </span>",$string);
$string2= str_replace("R/.", "<span style=\"color:red\">R/. </span>",$string1);
return $string2;
}

function epuration($string) {
	$string1=str_replace(chr(146),"'",$string);
	return utf8_encode($string1);
}


function respbrevis($ref) {
	$row = 0;
	// Cr�ation du chemin relatif vers le fichier de r�pons de fa�on brut
	$fichier="calendrier/liturgia/".$ref.".csv";
	// V�rification du chemin brut, sinon cr�ation du chemin relatif utf8
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
	$row = 0;
	// Initialisation de l'hymne � blanc
	$hymne="";
	// Cr�ation du chemin relatif vers le fichier de l'hymne de fa�on brut
	$fichier="hymnaire/".$ref.".csv";
	// V�rification du chemin brut, sinon cr�ation du chemin relatif utf8
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
	// Cr�ation du chemin relatif vers le fichier du psaume de fa�on brut
	$fichier="psautier/".$ref.".csv";
	// V�rification du chemin brut, sinon cr�ation du chemin relatif utf8
	if (!file_exists($fichier)) $fichier="psautier/".utf8_encode($ref).".csv";
	if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
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


$do = $_GET['date'];

if(!$do) {
	$tfc=time();
	$do=date("Ymd",$tfc);
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
	$offices=array("p","laudes","tierce","sexte","none","vepres","complies","s");
	for($o=0;$offices[$o];$o++) {
		if ($office==$offices[$o]) {
			$officeactuel=$o;
			break;
		}
	}
	$suivant = $offices[$officeactuel+1];
	$precedent = $offices[$officeactuel-1];

	$anno=substr($do,0,4);
	$mense=substr($do,4,2);
	$die=substr($do,6,2);
	$day=mktime(12,0,0,$mense,$die,$anno);
	//$dts=mktime(12,0,0,$mense,$die,$anno);
	$dtsmoinsun=$day-60*60*24;
	$dtsplusun=$day+60*60*24;
	$hier=date("Ymd",$dtsmoinsun);
	$demain=date("Ymd",$dtsplusun);

	$dsuiv=$day+60*60*24;
	$dprec=$day-60*60*24;

	$date_suiv=$do;
	$date_prec= $do;
	if ($suivant=="s") {
		$suivant = "laudes";
		$date_suiv=date("Ymd",$dsuiv);
	}
	if ($precedent=="p") {
		$precedent = "complies";
		$date_prec= date("Ymd",$dprec);
	}
	//print_r($do);
	// Date pour l'office des défunts :
	$date_defunts=$anno."1102";
	
	// date du jour :
	$tfc=time();
	$date_aujourdhui=date("Ymd",$tfc);
	$annee_aujourdhui=substr($date_aujourdhui,0,4);
	$mois_aujourdhui=substr($date_aujourdhui,4,2);
	
	
	print"
		<div id=\"$place\">
			<ul>
				<li><a href=\"index.php?date=$hier&amp;office=$office\">&lt;&lt; </a></li>
				<li><a href=\"index.php?date=$date_prec&amp;office=$precedent\">&lt; </a></li>";
	if ($office=="laudes") print "<li class=\"selection\"><a href=\"index.php?date=$do&amp;office=laudes&amp;mois_courant=$mense&amp;an=$anno\">Laudes</a></li>";
	else print "<li><a href=\"index.php?date=$do&amp;office=laudes&amp;mois_courant=$mense&amp;an=$anno\">Laudes</a></li>";
	if ($office=="tierce") print "<li class=\"selection\"><a href=\"index.php?date=$do&amp;office=tierce&amp;mois_courant=$mense&amp;an=$anno\">Tierce</a></li>";
	else print "<li><a href=\"index.php?date=$do&amp;office=tierce&amp;mois_courant=$mense&amp;an=$anno\">Tierce</a></li>";
	if ($office=="sexte") print "<li class=\"selection\"><a href=\"index.php?date=$do&amp;office=sexte&amp;mois_courant=$mense&amp;an=$anno\">Sexte</a></li>";
	else print "<li><a href=\"index.php?date=$do&amp;office=sexte&amp;mois_courant=$mense&amp;an=$anno\">Sexte</a></li>";
	if ($office=="none") print "<li class=\"selection\"><a href=\"index.php?date=$do&amp;office=none&amp;mois_courant=$mense&amp;an=$anno\">None</a></li>";
	else print "<li><a href=\"index.php?date=$do&amp;office=none&amp;mois_courant=$mense&amp;an=$anno\">None</a></li>";
	if ($office=="vepres") print "<li class=\"selection\"><a href=\"index.php?date=$do&amp;office=vepres&amp;mois_courant=$mense&amp;an=$anno\">V&ecirc;pres</a></li>";
	else print "<li><a href=\"index.php?date=$do&amp;office=vepres&amp;mois_courant=$mense&amp;an=$anno\">V&ecirc;pres</a></li>";
	if ($office=="complies") print "<li class=\"selection\"><a href=\"index.php?date=$do&amp;office=complies&amp;mois_courant=$mense&amp;an=$anno\">Complies</a></li>";
	else print "<li><a href=\"index.php?date=$do&amp;office=complies&amp;mois_courant=$mense&amp;an=$anno\">Complies</a></li>";
	
	print"
				<li><a href=\"index.php?date=$date_suiv&amp;office=$suivant\">></a></li>
				<li><a href=\"index.php?date=$demain&amp;office=$office\"> >></a></li>
			</ul>
			<ul>
				<li id=\"defunts\"><a href=\"index.php?date=$date_defunts&amp;office=$office&amp;mois_courant=11&amp;an=$anno\">Office des d&eacute;funts</a></li>
				<li><a href=\"index.php?date=$date_aujourdhui&amp;office=$office&amp;mois_courant=$mois_aujourdhui&amp;an=$annee_aujourdhui\">Revenir au jour pr&eacute;sent</a></li>
			</ul>
		</div>";//div navigation
//<a href=\"index.php?date=$do&amp;office=messe&amp;mois_courant=$mense&amp;an=$anno\">Messe</a>
		
}



?>
