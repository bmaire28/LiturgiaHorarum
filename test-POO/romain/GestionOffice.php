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
		if($calendarium['hebdomada'][$do]=="Infra octavam paschae") {
			$this->temporal['ps1']['latin']="ps62";
			$this->temporal['ps2']['latin']="AT41";
			$this->temporal['ps3']['latin']="ps149";
			$this->temporal['ps7']['latin']="ps109";
			$this->temporal['ps8']['latin']="ps113A";
			$this->temporal['ps9']['latin']="NT12";
		}
		
		
		
		/*
		 * Initialisation des variables
		 * $anno = année de l'office
		 * $mense = mois de l'office
		 * $die = jour de l'office
		 * $day = timestamp du jour de l'office
		 * $do_l = liste de noms des jours en latin
		 * $do_fr = liste de noms des jours en français
		 * $jrdelasemaine = numéro du jour dans la semaine (0 à 6)
		 * $date_l = nom du jour de l'office en latin
		 * $date_fr = nom du jour de l'office en français
		 *
		 */
		$anno=substr($do,0,4);
		$mense=substr($do,4,2);
		$die=substr($do,6,2);
		$day=mktime(12,0,0,$mense,$die,$anno);
		
		if ($_GET['office']=='vepres') {
			$jour_l = array("Dominica, ad II ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, ad I ");
			$jour_fr=array("Le Dimanche aux IIes ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche aux I&egrave;res ");
		}
		else {
			$jour_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
			$jour_fr=array("Le Dimanche","Le Lundi","Le Mardi","Le Mercredi","Le Jeudi","Le Vendredi","Le Samedi");
		}
		
		$jrdelasemaine=date("w",$day);
		$date_fr=$jour_fr[$jrdelasemaine];
		$date_l=$jour_l[$jrdelasemaine];
		
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
		$spsautier=$calendarium['hebdomada_psalterium'][$do];
		
		/*
		 * Chargement du propre au psautier du jour
		 */
		$fichier="propres_r/commune/psautier_".$spsautier.$jrdelasemaine.".csv";
		if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$id=$data[0];$ref=$data[1];
			$this->ferial[$id]['latin']=$ref;
			$row++;
		}
		fclose($fp);
		
		
		/*
		 * Déterminer le temps liturgique :
		 * $psautier prend la caleur du temps liturgique abrégé
		 *
		 * Ouvrir et charger le propre du jour dans $this->ferial:
		 * $q prend la valeur du nom du fichier en fonction du temps liturgique, du numéro de semaine et du jour :
		 * - temps liturgique via $psautier
		 * - numéro de la semaine soit dans $psautier pour Pascal et Carême, soit 1 à 4
		 * - jour de la semaine de 1 pour Dimanche à 7 pour Samedi
		 *
		*/
		$tem=$calendarium['tempus'][$do];
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
				if ($calendarium['intitule'][$do]=="Feria IV Cinerum") { $q="quadragesima_0";}
				switch ($calendarium['hebdomada'][$do]) {
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
				switch ($calendarium['hebdomada'][$do]) {
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
			$this->ferial[$id]['latin']=$latin;
			$this->ferial[$id]['francais']=$francais;
			$row++;
		}
		fclose($fp);
		
		/*
		 * Vérifier qu'il n'y a pas de saint à célébrer
		 * Chargement du propre du sanctoral dans $this->sanctoral
		 *
		*/
		if (($calendarium['rang'][$do])or($calendarium['priorite'][$do]==12)) {
			$prop=$mense.$die;
			$fichier="propres_r/sanctoral/".$prop.".csv";
			if (!file_exists($fichier)) print_r("<p>Sanctoral : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$this->sanctoral[$id]['latin']=$data[1];
				$this->sanctoral[$id]['francais']=$data[2];
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
				$this->sanctoral[$id]['latin']=$data[1];
				$this->sanctoral[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
				
			// Chargement du fichier du jour de la semaine
			$fichier="propres_r/temporal/".$psautier."/".$q.$jrdelasemaine."post1712.csv";
			if (!file_exists($fichier)) print_r("<p>Propre : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];$latin=$data[1];$francais=$data[2];
				$this->ferial[$id]['latin']=$latin;
				$this->ferial[$id]['francais']=$francais;
				$row++;
			}
			fclose($fp);
			// Transfert de l'intitule
			$this->sanctoral['intitule']['latin']=$this->ferial['intitule']['latin'];
			$this->sanctoral['intitule']['francais']=$this->ferial['intitule']['francais'];
		}
		
		/*
		 * Vérification du temporal - solennités et fetes
		 * Chargement de $this->temporal avec les valeurs du temporal
		 *
		 */
		
		if($calendarium['temporal'][$do]) {
			$tempo=$calendarium['temporal'][$do];
			$fichier="propres_r/temporal/".$tempo.".csv";
			if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$this->temporal[$id]['latin']=$data[1];
				$this->temporal[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
		
			$date_fr=$date_l=null;
			if($_GET['office']=='vepres') {
				// Gestion intitule Ieres ou IIndes vepres en latin
				if (($calendarium['intitule'][$do]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$do]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_l="<br> ad ";
				elseif ($calendarium['1V'][$do]) $date_l="<br> ad II ";
				else $date_l = "<br> ad ";
		
				// Gestion intitule Ieres ou IIndes vepres en francais
				if (($calendarium['intitule'][$do]=="FERIA QUARTA CINERUM")or($calendarium['intitule'][$do]=="DOMINICA RESURRECTIONIS")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($calendarium['intitule'][$do]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $date_fr="<br> aux ";
				elseif ($calendarium['1V'][$do]) $date_fr = "<br> aux IIdes ";
				else $date_fr = "<br> aux ";
			}
		}
		
		/*
		 * Gestion du 4e Dimanche de l'Avent
		 * si c'est le 24/12, prendre toutes les antiennes au 24, rien à modifier
		 * sinon prendre uniquement l'antienne benedictus ==> recopier le temporal dans le sanctoral
		 */
		if ($this->temporal['intitule']['latin']=="Dominica IV Adventus") {
			if ($die!="24") {
				$benelat=$this->sanctoral['benedictus']['latin'];
				$benefr=$this->sanctoral['benedictus']['francais'];
				$magniflat=$this->sanctoral['magnificat']['latin'];
				$magniffr=$this->sanctoral['magnificat']['francais'];
				$this->sanctoral=$this->temporal;
				$this->sanctoral['benedictus']['latin']=$benelat;
				$this->sanctoral['benedictus']['francais']=$benefr;
				$this->sanctoral['magnificat']['latin']=$magniflat;
				$this->sanctoral['magnificat']['francais']=$magniffr;
			}
			else {
				$calendarium['priorite'][$do]++;
			}
		}
		
		/*
		 * Vérification de premieres vepres au temporal - solennités et fetes
		 * Chargement de $this->temporal avec les valeurs du temporal
		 * Affectation des valeurs hymne, LB, RB, ... à partir de $this->temporal
		 */
		$tomorow = $day+60*60*24;
		$demain=date("Ymd",$tomorow);
		
		/*print_r("<p> demain : ".$demain."</p>");
		 print_r("<p> 1V demain : ".$calendarium['1V'][$demain]."</p>");
		 print_r("<p> priorite jour : ".$calendarium['priorite'][$do]."</p>");
		 print_r("<p> priorite demain : ".$calendarium['priorite'][$demain]."</p>");
		print_r("<p> intitule demain : ".$calendarium['intitule'][$demain]."</p>");*/
		if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$do]>$calendarium['priorite'][$demain])&&($_GET['office']=='vepres')) {
			/*print_r("<p> 1V</p>");*/
			$tempo=null;
			$this->temporal=null;
			$tempo=$calendarium['temporal'][$demain];
			$fichier="propres_r/temporal/".$tempo.".csv";
			if (!file_exists($fichier)) print_r("<p>temporal 1V : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				$this->temporal[$id]['latin']=$data[1];
				$this->temporal[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
			$this->sanctoral=null;
			$date_l = "ad I ";
			$date_fr = "aux I&egrave;res ";
			$this->temporal['HYMNUS_vepres']['latin']=$this->temporal['HYMNUS_1V']['latin'];
			$this->temporal['ant7']['latin']=$this->temporal['ant01']['latin'];
			$this->temporal['ant7']['francais']=$this->temporal['ant01']['francais'];
			$this->temporal['ant8']['latin']=$this->temporal['ant02']['latin'];
			$this->temporal['ant8']['francais']=$this->temporal['ant02']['francais'];
			$this->temporal['ant9']['latin']=$this->temporal['ant03']['latin'];
			$this->temporal['ant9']['francais']=$this->temporal['ant03']['francais'];
			$this->temporal['ps7']['latin']=$this->temporal['ps01']['latin'];
			$this->temporal['ps7']['francais']=$this->temporal['ps01']['francais'];
			$this->temporal['ps8']['latin']=$this->temporal['ps02']['latin'];
			$this->temporal['ps8']['francais']=$this->temporal['ps02']['francais'];
			$this->temporal['ps9']['latin']=$this->temporal['ps03']['latin'];
			$this->temporal['ps9']['francais']=$this->temporal['ps03']['francais'];
			$this->temporal['LB_soir']['latin']=$this->temporal['LB_1V']['latin'];
			$this->temporal['RB_soir']['latin']=$this->temporal['RB_1V']['latin'];
			$this->temporal['RB_soir']['francais']=$this->temporal['RB_1V']['francais'];
			$pmagnificat="pmagnificat_".$lettre;
			$magnificat="magnificat_".$lettre;
			if ($this->temporal[$pmagnificat]['latin']) {
				$this->temporal[$magnificat]['latin']=$this->temporal[$pmagnificat]['latin'];
				$this->temporal[$magnificat]['francais']=$this->temporal[$pmagnificat]['francais'];
			}
			else {
				$this->temporal['magnificat']['latin']=$this->temporal['pmagnificat']['latin'];
				$this->temporal['magnificat']['francais']=$this->temporal['pmagnificat']['francais'];
			}
			$this->temporal['preces_soir']['latin']=$this->temporal['preces_1V']['latin'];
			$this->temporal['oratio_soir']['latin']=$this->temporal['oratio_1V']['latin'];
			$this->temporal['oratio_soir']['francais']=$this->temporal['oratio_1V']['francais'];
			if ($this->temporal['intitule']['latin']=="Dominica IV Adventus"){
				$this->sanctoral['LB_soir']['latin']=$this->temporal['LB_1V']['latin'];
				$this->sanctoral['RB_soir']['latin']=$this->temporal['RB_1V']['latin'];
				$this->sanctoral['RB_soir']['francais']=$this->temporal['RB_1V']['francais'];
				$this->sanctoral['oratio']['latin']=$this->temporal['oratio']['latin'];
				$this->sanctoral['oratio']['francais']=$this->temporal['oratio']['francais'];
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