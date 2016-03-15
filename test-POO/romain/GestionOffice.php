<?php
/*
 * Classe GestionOffice pour remplir définir les valeurs des antiennes et autres variables à partir du calendrier liturgique
 */

class GestionOffice {
	/*
	 * variables locales
	 */
	var $sanctoral;
	var $temporal;
	var $ferial;
	
	/*
	 * getters
	 */
	function sanctoral() {
		return $this->sanctoral;
	}
	function temporal() {
		return $this->temporal;
	}
	function ferial() {
		return $this->ferial;
	}
	
	/*
	 * setters
	 */
	function setSanctoral($id,$langue,$valeur) {
		$this->sanctoral[$id][$langue]=$valeur;
	}
	function setTemporal($id,$langue,$valeur) {
		$this->temporal[$id][$langue]=$valeur;
	}
	function setFerial($id,$langue,$valeur) {
		$this->ferial[$id][$langue]=$valeur;
	}
	
	/*
	 * méthodes
	 */
	
	/*
	 * méthode d'initialisation des tableaux $sanctoral, $temporal, $ferial en fonction du calendrier liturgique
	 * Cette méthode n'est appelé que par les méthodes internes de la classe
	 * Entrées : $jour = date du jour, $calendarium = calendrier calcuelr pour la date donnée
	 * Sortie : $sanctoral, $temporal et $ferial sont remplis
	 */
	function initialisationSources($jour,$calendarium) {
		if($calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
			$this->setTemporal('ps1', 'latin', 'ps62');
			$this->setTemporal('ps2', 'latin', 'AT41');
			$this->setTemporal('ps3', 'latin', 'ps149');
			$this->setTemporal('ps7', 'latin', 'ps109');
			$this->setTemporal('ps8', 'latin', 'ps113A');
			$this->setTemporal('ps9', 'latin', 'NT12');			
		}
		
		/*
		 * Initialisation des variables
		 * $anno = année de l'office
		 * $mense = mois de l'office
		 * $die = jour de l'office
		 * $day = timestamp du jour de l'office
		 * $jour_l = liste de noms des jours en latin
		 * $jour_fr = liste de noms des jours en français
		 * $jrdelasemaine = numéro du jour dans la semaine (0 à 6)
		 * $date_l = nom du jour de l'office en latin
		 * $date_fr = nom du jour de l'office en français
		 *
		 */
		$anno=substr($jour,0,4);
		$mense=substr($jour,4,2);
		$die=substr($jour,6,2);
		$day=mktime(12,0,0,$mense,$die,$anno);
		
		if ($_GET['office']=='vepres') {
			$jours_l = array("Dominica, ad II ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, ad I ");
			$jours_fr=array("Le Dimanche aux IIes ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche aux I&egrave;res ");
		}
		else {
			$jours_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
			$jours_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");
		}
		
		$jrdelasemaine=date("w",$day);
		$date_fr=$jours_fr[$jrdelasemaine];
		$date_l=$jours_l[$jrdelasemaine];
		
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
		
		$jrdelasemaine++; // pour avoir dimanche=1 etc...
		$spsautier=$calendarium['hebdomada_psalterium'][$jour];
		
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
		$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
		if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];$latin=$data[1];$francais=$data[2];
			$ferial[$id]['latin']=$latin;
			$ferial[$id]['francais']=$francais;
			$row++;
		}
		fclose($fp);
		
		/*
		 * Chargement du propre au psautier du jour
		*/
		$fichier="propres_r/commune/psautier_".$spsautier.$jrdelasemaine.".csv";
		if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
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
		if (($calendarium['rang'][$jour])or($calendarium['priorite'][$jour]==12)) {
			$prop=$mense.$die;
			$fichier="propres_r/sanctoral/".$prop.".csv";
			if (!file_exists($fichier)) print_r("<p>Sanctoral : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$sanctoral[$id]['latin']=$data[1];
				$sanctoral[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
		}
		
		/*
		 * octave glissante précédent noel
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
				$sanctoral[$id]['latin']=$data[1];
				$sanctoral[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
				
			// Chargement du fichier du jour de la semaine
			$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine."post1712.csv";
			if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];$latin=$data[1];$francais=$data[2];
				$ferial[$id]['latin']=$latin;
				$ferial[$id]['francais']=$francais;
				$row++;
			}
			fclose($fp);
			// Transfert de l'intitule
			$sanctoral['intitule']['latin']=$ferial['intitule']['latin'];
			$sanctoral['intitule']['francais']=$ferial['intitule']['francais'];
		}
		
		/*
		 * Vérification du temporal - solennités et fetes
		 * Chargement de $temp avec les valeurs du temporal
		 *
		 */
		
		if($calendarium['temporal'][$jour]) {
			$tempo=$calendarium['temporal'][$jour];
			$fichier="propres_r/temporal/".$tempo.".csv";
			if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$temporal[$id]['latin']=$data[1];
				$temporal[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
		
			$date_fr=$date_l=null;
			if($_GET['office']=='vepres') {
				// Gestion intitule Ieres ou IIndes vepres en latin
				if (($calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l="<br> ad ";
				elseif ($calendarium['1V'][$jour]) $date_l="<br> ad II ";
				else $date_l = "<br> ad ";
		
				// Gestion intitule Ieres ou IIndes vepres en francais
				if (($calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr="<br> aux ";
				elseif ($calendarium['1V'][$jour]) $date_fr = "<br> aux IIdes ";
				else $date_fr = "<br> aux ";
			}
		}
		
		/*
		 * Gestion du 4e Dimanche de l'Avent
		 * si c'est le 24/12, prendre toutes les antiennes au 24, rien à modifier
		 * sinon prendre uniquement l'antienne benedictus ==> recopier le temporal dans le sanctoral
		 */
		if ($temporal['intitule']['latin']=="Dominica IV Adventus") {
			if ($die!="24") {
				$benelat=$sanctoral['benedictus']['latin'];
				$benefr=$sanctoral['benedictus']['francais'];
				$magniflat=$sanctoral['magnificat']['latin'];
				$magniffr=$sanctoral['magnificat']['francais'];
				$sanctoral=$temporal;
				$sanctoral['benedictus']['latin']=$benelat;
				$sanctoral['benedictus']['francais']=$benefr;
				$sanctoral['magnificat']['latin']=$magniflat;
				$sanctoral['magnificat']['francais']=$magniffr;
			}
			else {
				$calendarium['priorite'][$jour]++;
			}
		}
		
		/*
		 * Vérification de premieres vepres au temporal - solennités et fetes
		 * Chargement de $temp avec les valeurs du temporal
		 * Affectation des valeurs hymne, LB, RB, ... à partir de $temp
		 */
		$tomorow = $day+60*60*24;
		$demain=date("Ymd",$tomorow);
		
		/*print_r("<p> demain : ".$demain."</p>");
		 print_r("<p> 1V demain : ".$calendarium['1V'][$demain]."</p>");
		 print_r("<p> priorite jour : ".$calendarium['priorite'][$jour]."</p>");
		 print_r("<p> priorite demain : ".$calendarium['priorite'][$demain]."</p>");
		print_r("<p> intitule demain : ".$calendarium['intitule'][$demain]."</p>");*/
		if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($_GET['office']=='vepres')) {
			/*print_r("<p> 1V</p>");*/
			$tempo=null;
			$tempo=$calendarium['temporal'][$demain];
			$fichier="propres_r/temporal/".$tempo.".csv";
			if (!file_exists($fichier)) print_r("<p>temporal 1V : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$temporal[$id]['latin']=$data[1];
				$temporal[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
			$propre=null;
			$date_l = "ad I ";
			$date_fr = "aux I&egrave;res ";
			$temporal['HYMNUS_vepres']['latin']=$temporal['HYMNUS_1V']['latin'];
			$temporal['ant7']['latin']=$temporal['ant01']['latin'];
			$temporal['ant7']['francais']=$temporal['ant01']['francais'];
			$temporal['ant8']['latin']=$temporal['ant02']['latin'];
			$temporal['ant8']['francais']=$temporal['ant02']['francais'];
			$temporal['ant9']['latin']=$temporal['ant03']['latin'];
			$temporal['ant9']['francais']=$temporal['ant03']['francais'];
			$temporal['ps7']['latin']=$temporal['ps01']['latin'];
			$temporal['ps7']['francais']=$temporal['ps01']['francais'];
			$temporal['ps8']['latin']=$temporal['ps02']['latin'];
			$temporal['ps8']['francais']=$temporal['ps02']['francais'];
			$temporal['ps9']['latin']=$temporal['ps03']['latin'];
			$temporal['ps9']['francais']=$temporal['ps03']['francais'];
			$temporal['LB_soir']['latin']=$temporal['LB_1V']['latin'];
			$temporal['RB_soir']['latin']=$temporal['RB_1V']['latin'];
			$temporal['RB_soir']['francais']=$temporal['RB_1V']['francais'];
			$pmagnificat="pmagnificat_".$lettre;
			$magnificat="magnificat_".$lettre;
			if ($temporal[$pmagnificat]['latin']) {
				$temporal[$magnificat]['latin']=$temporal[$pmagnificat]['latin'];
				$temporal[$magnificat]['francais']=$temporal[$pmagnificat]['francais'];
			}
			else {
				$temporal['magnificat']['latin']=$temporal['pmagnificat']['latin'];
				$temporal['magnificat']['francais']=$temporal['pmagnificat']['francais'];
			}
			$temporal['preces_soir']['latin']=$temporal['preces_1V']['latin'];
			$temporal['oratio_soir']['latin']=$temporal['oratio_1V']['latin'];
			$temporal['oratio_soir']['francais']=$temporal['oratio_1V']['francais'];
			if ($temporal['intitule']['latin']=="Dominica IV Adventus"){
				$sanctoral['LB_soir']['latin']=$temporal['LB_1V']['latin'];
				$sanctoral['RB_soir']['latin']=$temporal['RB_1V']['latin'];
				$sanctoral['RB_soir']['francais']=$temporal['RB_1V']['francais'];
				$sanctoral['oratio']['latin']=$temporal['oratio']['latin'];
				$sanctoral['oratio']['francais']=$temporal['oratio']['francais'];
			}
		}
	}
	
	function initialisationLaudes($office,$jour,$calendarium) {
		
	} 
	
	function initialisationVepres($office,$jour,$calendarium) {
	
	}
	
	function initialisationTierce($office,$jour,$calendarium) {
	
	}
	
	function initialisationSexte($office,$jour,$calendarium) {
		
	}
	
	function initialisationNone($office,$jour,$calendarium) {
		
	}
	
	function initialisationComplies($office,$jour,$calendarium) {
		
	}
}