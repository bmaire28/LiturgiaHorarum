<?php

class Office_r {
	var $typeOffice;
	var $ordo;
	var $intitule;
	var $nomOffice;
	var $rangOffice;
	var $invitatoire;
	var $hymne;
	var $ant1;
	var $ps1;
	var $ant2;
	var $ps2;
	var $ant3;
	var $ps3;
	var $lectio;
	var $repons;
	var $antEv;
	var $preces;
	var $oratio;
	var $cantiqueMarial;
	
	/*
	 * getters
	 */
	function typeOffice() { return $this->typeOffice; }
	function ordo($langue) { return $this->ordo[$langue]; }
	function intitule($langue) { return $this->intitule[$langue]; }
	function nomOffice($langue) { return $this->nomOffice[$langue]; }
	function rangOffice($langue) { return $this->rangOffice[$langue]; }
	function invitatoire() { return $this->invitatoire; }
	function hymne() { return $this->hymne; }
	function ant1($langue) { return $this->ant1[$langue]; }
	function ps1(){ return $this->ps1; }
	function ant2($langue) { return $this->ant2[$langue]; }
	function ps2(){ return $this->ps2; }
	function ant3($langue) { return $this->ant3[$langue]; }
	function ps3(){ return $this->ps3; }
	function lectio(){ return $this->lectio; }
	function repons($langue) { return $this->repons[$langue]; }
	function antEv($langue) { return $this->antEv[$langue]; }
	function preces() { return $this->preces; }
	function oratio($langue) { return $this->oratio[$langue]; }
	function cantiqueMarial() { return $this->cantiqueMarial; }
	
	/*
	 * setters
	 */
	function setTypeOffice($typeOffice) { $this->typeOffice = $typeOffice; }
	function setOrdo($ordoLat, $ordoFr) {
		$this->ordo['latin'] = $ordoLat;
		$this->ordo['francais'] = $ordoFr;
	}
	function setIntitule($intituleLat, $intituleFr) {
		$this->intitule['latin'] = $intituleLat;
		$this->intitule['francais'] = $intituleFr;
	}
	function setNomOffice($nomOrdoLat, $nomOrdoFr) {
		$this->nomOffice['latin'] = $nomOrdoLat;
		$this->nomOffice['francais'] = $nomOrdoFr;
	}
	function setRangOffice($rangLat, $rangFr) {
		$this->rangOffice['latin'] = $rangLat;
		$this->rangOffice['francais'] = $rangFr;
	}
	function setInvitatoire($invitatoire){
		if ($invitatoire) $this->invitatoire = $invitatoire;
		else $this->invitatoire = false;
	}
	function setHymne($hymne) { $this->hymne = $hymne; }
	function setAnt1($antLat, $antFr) { 
		$this->ant1['latin'] = $antLat;
		$this->ant1['francais'] = $antFr;
	}
	function setPs1($psaume) { $this->ps1 = $psaume; }
	function setAnt2($antLat, $antFr) { 
		$this->ant2['latin'] = $antLat;
		$this->ant2['francais'] = $antFr;
	}
	function setPs2($psaume) { $this->ps2 = $psaume; }
	function setAnt3($antLat, $antFr) { 
		$this->ant3['latin'] = $antLat;
		$this->ant3['francais'] = $antFr;
	}
	function setPs3($psaume) { $this->ps3 = $psaume; }
	function setLectio($lectio) { $this->lectio = $lectio; }
	function setRepons($reponsLat, $reponsFr) {
		$this->repons['latin'] = $reponsLat;
		$this->repons['francais'] = $reponsFr;
	}
	function setAntEv($antLat, $antFr) { 
		$this->antEv['latin'] = $antLat;
		$this->antEv['francais'] = $antFr;
	}
	function setPreces($preces) { $this->preces = $preces; }
	function setOratio($oratioLat, $oratioFr) { 
		$this->oratio['latin'] = $oratioLat;
		$this->oratio['francais'] = $oratioFr;
	}
	function setCantiqueMarial($cantiqueMarial) { $this->cantiqueMarial=$cantiqueMarial; }
	
	/*
	 * Affichage du menu des offices
	 */
	function affiche_nav($do,$office,$place) {
		$rite=$_GET['rite'];
		if (!$rite) $rite="romain";
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
		$date_defunts=$anno."1102";
	
		// date du jour :
		$tfc=time();
		$date_aujourdhui=date("Ymd",$tfc);
		$annee_aujourdhui=substr($date_aujourdhui,0,4);
		$mois_aujourdhui=substr($date_aujourdhui,4,2);
	
		echo "$('.$place').show();\n";
		// Liste des offices
		echo "$('<ul>').appendTo('.$place');\n";
		// Jour précédent
		echo "$('<li><a href=\"index.php?date=$hier&amp;rite=$rite&amp;office=$office\"><span>&lt;&lt; </span></a></li>').appendTo('.$place ul');\n";
		// Office précédent
		echo "$('<li><a href=\"index.php?date=$date_prec&amp;rite=$rite&amp;office=$precedent\"><span>&lt; </span></a></li>').appendTo('.$place ul').text();\n";
		if ($office=="laudes") echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=laudes&amp;mois_courant=$mense&amp;an=$anno\"><span class=\"selection\">Laudes</span></a></li>').appendTo('.$place ul');\n";
		else echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=laudes&amp;mois_courant=$mense&amp;an=$anno\"><span>Laudes</span></a></li>').appendTo('.$place ul');\n";
		if ($office=="tierce") echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=tierce&amp;mois_courant=$mense&amp;an=$anno\"><span class=\"selection\">Tierce</span></a></li>').appendTo('.$place ul');\n";
		else echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=tierce&amp;mois_courant=$mense&amp;an=$anno\"><span>Tierce</span></a></li>').appendTo('.$place ul');\n";
		if ($office=="sexte") echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=sexte&amp;mois_courant=$mense&amp;an=$anno\"><span class=\"selection\">Sexte</span></a></li>').appendTo('.$place ul');\n";
		else echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=sexte&amp;mois_courant=$mense&amp;an=$anno\"><span>Sexte</span></a></li>').appendTo('.$place ul');\n";
		if ($office=="none") echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=none&amp;mois_courant=$mense&amp;an=$anno\"><span class=\"selection\">None</span></a></li>').appendTo('.$place ul');\n";
		else echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=none&amp;mois_courant=$mense&amp;an=$anno\"><span>None</span></a></li>').appendTo('.$place ul');\n";
		if ($office=="vepres") echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=vepres&amp;mois_courant=$mense&amp;an=$anno\"><span class=\"selection\">V&ecirc;pres</span></a></li>').appendTo('.$place ul');\n";
		else echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=vepres&amp;mois_courant=$mense&amp;an=$anno\"><span>V&ecirc;pres</span></a></li>').appendTo('.$place ul');\n";
		if ($office=="complies") echo "$('<li><a href=\"index.php?date=$do&amp;rite=$rite&amp;office=complies&amp;mois_courant=$mense&amp;an=$anno\"><span class=\"selection\">Complies</span></a></li>').appendTo('.$place ul');\n";
		echo "$('<li><a href=\"index.php?date=$date_suiv&amp;rite=$rite&amp;office=$suivant\"><span>></span></a></li>').appendTo('.$place ul');\n";
		echo "$('<li><a href=\"index.php?date=$demain&amp;rite=$rite&amp;office=$office\"><span>>></span></a></li>').appendTo('.$place ul');\n";
		
		echo "$('<br>').appendTo('.$place');\n";
		echo "$('<ul>').addClass('ligneDeux').appendTo('.$place');\n";
		echo "$('<li><a href=\"index.php?date=$date_defunts&amp;rite=$rite&amp;office=$office&amp;mois_courant=11&amp;an=$anno\"><span class=\"defunts\">Office des d&eacute;funts</span></a></li>').appendTo('.$place .ligneDeux');\n";
		echo "$('<li><a href=\"index.php?date=$date_aujourdhui&amp;rite=$rite&amp;office=$office&amp;mois_courant=$mois_aujourdhui&amp;an=$annee_aujourdhui\"><span>Revenir au jour pr&eacute;sent</span></a></li>').appendTo('.$place .ligneDeux').last();\n";
	}
	
	/*
	 * Affichage de l'hymne
	 */
	function afficheHymne($ref) {
		$row = 0;
		// Initialisation de l'hymne par l'affichage du div correspondant
		$hymne="$('.hymne').show();\n";
		// Creation du chemin relatif vers le fichier de l'hymne de facon brut
		$fichier="hymnaire/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="hymnaire/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("$('<p>').appendTo('.erreurs').text(\".$fichier introuvable !\");\n");
		else {
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$latin=utf8_encode($data[0]);$francais=utf8_encode(str_replace("\x92", "'",$data[1]));
				if($row==0) {
					$hymne.="$('<h2>').appendTo('.hymne .latin').text(\"$latin\");\n";
					$hymne.="$('<h2>').appendTo('.hymne .francais').text(\"$francais\");\n";
				}
				elseif ($latin=="") {
					$hymne.="$('<br>').appendTo('.hymne .latin');\n";
					$hymne.="$('<br>').appendTo('.hymne .francais');\n";
				}
				else {
					$hymne.="$('<p>').appendTo('.hymne .latin').text(\"$latin\");\n";
					$hymne.="$('<p>').appendTo('.hymne .francais').text(\"$francais\");\n";
				}
				$row++;
			}
			fclose ($fp);
			$hymne.="$('<br>').appendTo('.hymne .latin');\n";
			$hymne.="$('<br>').appendTo('.hymne .francais');\n";
			return $hymne;
		}
	}
	
	/*
	 * Affichage d'un psaume
	 */
	function affichePsaume($ref, $emplacement) {
		$row = 0;
		$psaume = "$('$emplacement').show();\n";
		// Creation du chemin relatif vers le fichier du psaume de facon brut
		$fichier="psautier/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="psautier/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("$('<p>').appendTo('.erreurs').text(\".$fichier introuvable !\");\n");
		else {
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$latin="";
				$francais="";
				$latin=utf8_encode($data[0]);
				$francais=str_replace("\x92", "'",$data[1]);
				$francais=str_replace("\x93", "\xAB", $francais);
				$francais=utf8_encode($francais);
				if (($row==0)&&($latin!="")) {
					$psaume.="$('<h2>').appendTo('$emplacement .latin').text(\"$latin\");\n";
					$psaume.="$('<h2>').appendTo('$emplacement .francais').text('$francais');\n";
				}
				elseif (($row==1)&&($latin!="")) {
					$psaume.="$('<h3>').appendTo('$emplacement .latin').text(\"$latin\");\n";
					$psaume.="$('<h3>').appendTo('$emplacement .francais').text(\"$francais\");\n";
				}
				elseif (($row==2)&&($latin!="")) {
					$psaume.="$('<h4>').appendTo('$emplacement .latin').text(\"$latin\");\n";
					$psaume.="$('<h4>').appendTo('$emplacement .francais').text(\"$francais\");\n";
				}
				elseif (($row==3)&&($latin!="")) {
					$psaume.="$('<h2>').appendTo('$emplacement .latin').text(\"$latin\");\n";
					$psaume.="$('<h2>').appendTo('$emplacement .francais').text(\"$francais\");\n";
				}
				else {
					$psaume.="$('<p>').appendTo('$emplacement .latin').text(\"$latin\");\n";
					$psaume.="$('<p>').appendTo('$emplacement .francais').text(\"$francais\");\n";
				}
				$row++;
			}
			fclose ($fp);
			return $psaume;
		}
	}
	
	/*
	 * affiche le gloria patri apres un psaume
	 */
	function gloriaPatri ($emplacement) {
		$gloriaPatri = "$('$emplacement').show();\n";
		$gloriaPatri .= "
				$('<p>').appendTo('$emplacement .latin').text('Gloria Patri, et Fílio, * et Spirítui Sancto.');\n
				$('<p>').appendTo('$emplacement .latin').text('Sicut erat in principio, et nunc et semper * et in sæcula sæculórum. Amen.');\n
				
				$('<p>').appendTo('$emplacement .francais').text('Gloire au Père et au Fils et au Saint-Esprit,');\n
				$('<p>').appendTo('$emplacement .francais').text('Comme il était au commencement, maintenant et toujours,');\n
				$('<p>').appendTo('$emplacement .francais').text('Et dans les siècles des siècles. Amen.');\n	
				";
		return $gloriaPatri;
	}
	
	/*
	 * Affiche la lectio
	 */
	function AfficheLectio($ref) {
		$row = 0;
		$lectio = "$('.lectio').show()\n";
		// Creation du chemin relatif vers le fichier de lectio de facon brut
		$fichier="lectionnaire/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="lectionnaire/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("$('<p>').appendTo('.erreurs').text(\".$fichier introuvable !\");\n");
		else {
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$latin=utf8_encode($data[0]);$francais=utf8_encode($data[1]);


				if($row==0) {
					$lectio.="$('<h2>').appendTo('.lectio .latin').text(\"$latin\");\n";
					$lectio.="$('<h2>').appendTo('.lectio .francais').text(\"$francais\");\n";
				}
				else {
					$lectio.="$('<p>').appendTo('.lectio .latin').text(\"$latin\");\n";
					$lectio.="$('<p>').appendTo('.lectio .francais').text(\"$francais\");\n";
				}
				$row++;
			}
			fclose ($fp);
			$lectio.="$('<brp>').appendTo('.lectio .latin');\n";
			$lectio.="$('<br>').appendTo('.lectio .francais');\n";
			return $lectio;
		}
	}
	
	/*
	 * Affiche les preces
	 */
	function affichePreces($ref){
		$row = 0;
		$preces="$('.preces').show();\n";
		// Creation du chemin relatif vers le fichier de preces de facon brut
		$fichier="romain/preces/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="preces/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("$('<p>').appendTo('.erreurs').text(\"$fichier introuvable !\");\n");
		else {
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$latin=utf8_encode($data[0]);$francais=utf8_encode($data[1]);
				if($row==0) {
					$preces.="$('<h2>').appendTo('.preces .latin').text(\"$latin\");\n";
					$preces.="$('<h2>').appendTo('.preces .francais').text(\"$francais\");\n";
				}
				else {
					//$latin=str_replace("V/. ", "", $latin);
					$preces.="$('<p>').appendTo('.preces .latin').text(\"$latin\");\n";
					$preces.="$('<p>').appendTo('.preces .francais').text(\"$francais\");\n";
				}
				$row++;
			}
			fclose ($fp);
			return $preces;
		}
	}
	
	/*
	 * Fonction d'affichage d'un office
	 */
	function affiche() {
		
		$ant1Lat = utf8_encode($this->ant1('latin'));
		$ant1Fr = str_replace("’", "'", utf8_encode($this->ant1('francais')));
		$ant2Lat = utf8_encode($this->ant2('latin'));
		$ant2Fr = str_replace("’", "'", utf8_encode($this->ant2('francais')));
		$ant3Lat = utf8_encode($this->ant3('latin'));
		$ant3Fr = str_replace("’", "'", utf8_encode($this->ant3('francais')));
		
		// Creation du chemin relatif vers le fichier du squelette de l'office de facon brut
		$fichier="romain/offices_r/".$this->typeOffice.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="offices_r/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("$('<p>').appendTo('.erreurs').text(\"$fichier introuvable !\");\n");
		$row = 0;
		$fp = fopen ($fichier,"r");
		$jrdelasemaine--;
		
		// Lecture du squelette de l'office dans $office
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$latin=$data[0];$francais=$data[1];
			$office[$row]['latin']=$latin;
			$office[$row]['francais']=$francais;
			$row++;
		}
		fclose($fp);
		$max=$row;
		
		// Préparation de l'affichage de l'office
		for($row=0;$row<$max;$row++){
			$lat=$office[$row]['latin'];
			$fr=$office[$row]['francais'];
			
			//Actions en fonction de l'élément du squelette
			switch ($lat) {
				
				// Entête de l'office
				case "#JOUR" :
					$nomCourt = false;
					// Nom du jour et ou intitulé pour le temporal et le sanctoral
					if ($this->ordo['latin']) {
						$ordoLatin = $this->ordo('latin');
						$ordoFrancais = $this->ordo('francais');
						$nomCourt = true;
						print "
								$('.ordo .latin').show()\n
								$('<p>').appendTo('.ordo .latin').text('$ordoLatin');\n

								$('.ordo .francais').show()\n
								$('<p>').appendTo('.ordo .francais').text('$ordoFrancais');\n
							";
					}
					if ($this->intitule['latin']) {
						$intituleLatin = $this->intitule('latin');
						$intituleFrancais = $this->intitule('francais');
						$nomCourt = true;
						print "
								$('.ordo .latin').show()\n
								$('<p>').appendTo('.ordo .latin').text('$intituleLatin');\n
					
								$('.ordo .francais').show()\n
								$('<p>').appendTo('.ordo .francais').text('$intituleLatin');\n
							";
					}
					
					// Rang liturgique du jour au sanctoral
					if ($this->rangOffice['latin']) {
						$rangLatin = $this->rangOffice('latin');
						$rangFrancais = $this->rangOffice('francais');
						$nomCourt = true;
						print "
								$('.ordo .latin').show()\n
								$('<h3>').appendTo('.ordo .latin').text('$rangLatin');\n
					
								$('.ordo .francais').show()\n
								$('<h3>').appendTo('.ordo .francais').text('$rangFrancais');\n
							";
					}
					
					//Nom de l'office
					$nomLatin = $this->nomOffice('latin');
					$nomFrancais = $this->nomOffice('francais');
					if ($nomCourt) {
						print "
								$('<h2>').appendTo('.ordo .latin').text('$nomLatin');\n
		
								$('<h2>').appendTo('.ordo .francais').text('$nomFrancais');\n
							";
					}
					else {
						print "
								$('.ordo .latin').show()\n
								$('<h2>').appendTo('.ordo .latin').text('$nomLatin');\n
		
								$('.ordo .francais').show()\n
								$('<h2>').appendTo('.ordo .francais').text('$nomFrancais');\n
							";
					}
					break; // Fin Entête de l'office
					
				// Verset d'introduction sauf si invitatoire aux Laudes et vigiles
				case "#INTRODUCTION" :
					// Pas d'invitatoire en dehors des laudes et vigiles
					if (($this->typeOffice=="tierce")
							or($this->typeOffice=="sexe")
							or($this->typeOffice=="none")
							or($this->typeOffice=="vepres")
							or($this->typeOffice=="complies")) {
								$this->setInvitatoire(false);
							}
							
					$invitatoire = $this->invitatoire();
					if (!$invitatoire) {
						print "
								$('.verset-intro .latin').show()\n
								$('<p>').appendTo('.verset-intro .latin').text('Deus, in adiutórium meum inténde.');\n
								var premierP = $('.verset-intro .latin p:first');\n
								$('<span>').addClass('red').prependTo(premierP).text('R/. ');\n
								$('<p>').appendTo('.verset-intro .latin').text('Dómine, ad adiuvándum me festína.');\n
								var secondP = premierP.next();\n
								$('<span>').addClass('red').prependTo(secondP).text('V/. ');\n
								$('<p>').appendTo('.verset-intro .latin').text('Gloria Patri, et Fílio, * et Spirítui Sancto.');\n
								$('<p>').appendTo('.verset-intro .latin').text('Sicut erat in principio, et nunc et semper * et in sæcula sæculórum. Amen.');\n
								$('.verset-intro .francais').show();\n
								$('<p>').appendTo('.verset-intro .francais').text('O Dieu, hâte-toi de me délivrer !');\n
								var premierP = $('.verset-intro .francais p:first');\n
								$('<span>').addClass('red').prependTo(premierP).text('R/. ');\n
								$('<p>').appendTo('.verset-intro .francais').text('Seigneur, hâte-toi de me secourir !');\n
								var secondP = premierP.next();\n
								$('<span>').addClass('red').prependTo(secondP).text('V/. ');\n
								$('<p>').appendTo('.verset-intro .francais').text('Gloire au Père et au Fils et au Saint-Esprit,');\n
								$('<p>').appendTo('.verset-intro .francais').text('Comme il était au commencement, maintenant et toujours,');\n
								$('<p>').appendTo('.verset-intro .francais').text('Et dans les siècles des siècles. Amen.');\n
								$('.verset-intro').show()\n
							";
					}
					else {
						echo "$('.invitatoire .latin ').addClass('red').show().text('Ad Invitatorium.');\n";
						echo "$('.invitatoire .francais').addClass('red').show().text('Invitatoire.');\n";
						echo "$('.verset-intro').hide()\n";
						echo "$('.invitatoire').show()\n";
					}
					break; // fin de Verset d'introduction sauf si invitatoire aux Laudes et vigiles
				
				// Examen de conscience aux Complies
				case "#EXAMEN" :
					print "
							$('.examen-conscience .latin').show();
							$('<h2>').appendTo('.examen-conscience .latin').text('Conscientiæ discussio');\n
							$('<p>').appendTo('.examen-conscience .latin').text('Confíteor Deo omnipoténti et vobis, fratres, quia peccávi nimis cogitatióne, verbo, ópere et omissióne:');\n
							$('<h5>').appendTo('.examen-conscience .latin').text('et, percutientes sibi pectus, dicunt :');\n
							$('<p>').appendTo('.examen-conscience .latin').text('mea culpa, mea culpa, mea máxima culpa.');\n
							$('<h5>').appendTo('.examen-conscience .latin').text('Deinde prosequuntur:');\n
							$('<p>').appendTo('.examen-conscience .latin').text('Ideo precor beátam Maríam semper Vírginem, omnes Angelos et Sanctos, et vos, fratres, oráre pro me ad Dóminum Deum nostrum.');\n
							$('<p>').appendTo('.examen-conscience .latin').text('Misereátur nostri omnípotens Deus et, dimissís peccátis nostris, perdúcat nos ad vitam aetérnam.');\n
							var dernierP = $('.examen-conscience .latin p').last();\n
							$('<span>').addClass('red').prependTo(dernierP).text('V/. ');\n
							$('<p>').appendTo('.examen-conscience .latin').text('Amen.');\n
							dernierP = $('.examen-conscience .latin p').last();\n
							$('<span>').addClass('red').prependTo(dernierP).text('R/. ');\n
							$('.examen-conscience .francais').show();\n
							$('<h2>').appendTo('.examen-conscience .francais').text('Examen de conscience');\n
							$('<p>').appendTo('.examen-conscience .francais').text(\"Je confesse à Dieu tout puissant et à vous, mes frères, car j'ai péché par la pensée, la parole, les actes et par omission :\");\n
							$('<h5>').appendTo('.examen-conscience .francais').text('et, en se frappant la poitrine, on dit :');\n
							$('<p>').appendTo('.examen-conscience .francais').text('je suis coupable, je suis coupable, je suis grandement coupable.');\n
							$('<h5>').appendTo('.examen-conscience .francais').text('ensuite, on continue :');\n
							$('<p>').appendTo('.examen-conscience .francais').text(\"C'est pourquoi je supplie la bienheureuse Marie toujours Vierge, tous les Anges et les Saints, et vous, frères, de prier pour moi le Seigneur notre Dieu.\");\n
							$('<p>').appendTo('.examen-conscience .francais').text('Aie pitié de nous Dieu tout puissant et, nos péchés ayant été renvoyés, conduis-nous à la vie éternelle.');\n
							var dernierP = $('.examen-conscience .francais p').last();\n
							$('<span>').addClass('red').prependTo(dernierP).text('V/. ');\n
							$('<p>').appendTo('.examen-conscience .francais').text('Amen.');\n
							dernierP = $('.examen-conscience .francais p').last();\n
							$('<span>').addClass('red').prependTo(dernierP).text('R/. ');\n
						";
					break; // Fin de Examen de conscience aux Complies
				
				// HYMNE
				case "#HYMNUS" :
					/*
					 * Hymne
					 * appelle la methode afficheHymne($ref) avec la reference de l'hymne en argument
					 */
					print $this->afficheHymne($this->hymne());
					break; // Fin de Hymne
				
				/*
				 * Psalmodie
				 * en fonction du type d'office
				 * appelle la methode affichePsaume($ref, $emplacement) 
				 * avec la reference du psaume et l'emplacement dans la page :
				 * .psaume1
				 * .psaume2
				 * .psaume3
				 * Pas besoin de definir les antiennes et psaumes en fonction de l'office :
				 * il n'y a qu'un seul jeu d'antiennes/psaumes defini dans l'objet
				 * autrement dit l'objet est pour un office unique 
				 */
				// #ANT1*
				case "#ANT1*" :
					//Antienne 1 avant le psaume position 11
					print "$('.ant11').show();\n";
					print "$('<h2>').appendTo('.ant11 .latin').text('Psalmodia');\n";
					print "$('<h2>').appendTo('.ant11 .francais').text('Psalmodie');\n";
					print "$('<p>').appendTo('.ant11 .latin').text(\"$ant1Lat\");\n";
					print "$('<p>').appendTo('.ant11 .francais').text(\"$ant1Fr\");\n";
					print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. 1 : ');\n";
					break; // Fin de #ANT1*
					
				// #PS1
				case "#PS1" :
					//psaume 1
					print $this->affichePsaume($this->ps1(), ".psaume1");
					// gloria patri1
					print $this->gloriaPatri('.gloriapatri1');
					break; // Fin de #PS1
				
				// #ANT1
				case "#ANT1" :
					//Antienne 1 apres le psaume position 12
					print "$('.ant12').show();\n";
					print "$('<p>').appendTo('.ant12 .latin').text(\"$ant1Lat\");\n";
					print "$('<p>').appendTo('.ant12 .francais').text(\"$ant1Fr\");\n";
					print "$('<span>').addClass('red').prependTo('.ant12 p').text('Ant. : ');\n";
					print "$('<br>').appendTo('.ant12 .latin');\n";
					print "$('<br>').appendTo('.ant12 .francais');\n";
					break; // Fin de #ANT1
				
				// #ANT2*
				case "#ANT2*" :
					//Antienne 2 avant le psaume position 21
					print "$('.ant21').show();\n";
					print "$('<p>').appendTo('.ant21 .latin').text(\"$ant2Lat\");\n";
					print "$('<p>').appendTo('.ant21 .francais').text(\"$ant2Fr\");\n";
					print "$('<span>').addClass('red').prependTo('.ant21 p').text('Ant. 2 : ');\n";
					break; // Fin de #ANT2*

				// #PS2
				case "#PS2" :
					//psaume 2
					print $this->affichePsaume($this->ps2(), ".psaume2");
					// gloria patri2
					print $this->gloriaPatri('.gloriapatri2');
					break; // Fin de #PS2
				
				// #ANT2
				case "#ANT2" :
					//Antienne 2 apres le psaume position 22
					print "$('.ant22').show();\n";
					print "$('<p>').appendTo('.ant22 .latin').text(\"$ant2Lat\");\n";
					print "$('<p>').appendTo('.ant22 .francais').text(\"$ant2Fr\");\n";
					print "$('<span>').addClass('red').prependTo('.ant22 p').text('Ant. : ');\n";
					print "$('<br>').appendTo('.ant22 .latin');\n";
					print "$('<br>').appendTo('.ant22 .francais');\n";
					break; // Fin de #ANT2
					
				// #ANT3*
				case "#ANT3*" :
					//Antienne 3 avant le psaume position 31
					print "$('.ant31').show();\n";
					print "$('<p>').appendTo('.ant31 .latin').text(\"$ant3Lat\");\n";
					print "$('<p>').appendTo('.ant31 .francais').text(\"$ant3Fr\");\n";
					print "$('<span>').addClass('red').prependTo('.ant31 p').text('Ant. 3 : ');\n";
					break; // Fin de #ANT3*
				
				// #PS3
				case "#PS3" :
					//psaume 3
					print $this->affichePsaume($this->ps3(), ".psaume3");
					// gloria patri3
					print $this->gloriaPatri('.gloriapatri3');
					break; // Fin de #PS3
				
				// #ANT3
				case "#ANT3" :
					//Antienne 3 apres le psaume position 32
					print "$('.ant32').show();\n";
					print "$('<p>').appendTo('.ant32 .latin').text(\"$ant3Lat\");\n";
					print "$('<p>').appendTo('.ant32 .francais').text(\"$ant3Fr\");\n";
					print "$('<span>').addClass('red').prependTo('.ant32 p').text('Ant. : ');\n";
					print "$('<br>').appendTo('.ant32 .latin');\n";
					print "$('<br>').appendTo('.ant32 .francais');\n";
					break; // Fin de #ANT3
				
				// Lectio
				case "#LB" :
					print $this->AfficheLectio($this->lectio());
					break; // Fin de #LB
				
				/*
				 * répons grandes heures et complies / verset petites heures
				 */
				case "#RB" :
					$reponsLat = utf8_encode($this->repons('latin'));
					$reponsFr = utf8_encode($this->repons('francais'));
					
					$posLat = strpos($reponsLat, "<br />");
					$reponsLat1 = substr($reponsLat, 4, $posLat-4);
					$posLat+=10;
					$reponsLat2 = trim(substr($reponsLat, $posLat));
					
					$posFr = strpos($reponsFr, "<br />");
					$reponsFr1 = str_replace("’", "'", substr($reponsFr, 4, $posFr-4));
					$posFr+=10;
					$reponsFr2 = str_replace("’", "'", trim(substr($reponsFr, $posFr)));
					
					print "$('.repons').show();\n
							$('<p>').appendTo('.repons .latin').text(\"$reponsLat1\");\n
							$('<p>').appendTo('.repons .francais').text(\"$reponsFr1\");\n
							$('<span>').addClass('red').prependTo('.repons p').text('R/. ');\n
					
							$('<p>').appendTo('.repons .latin').text(\"$reponsLat2\");\n
							var dernierP = $('.repons .latin p').last()
							$('<span>').addClass('red').prependTo(dernierP).text('V/. ');\n
							$('<p>').appendTo('.repons .francais').text(\"$reponsFr2\");\n
							var dernierP = $('.repons .francais p').last()
							$('<span>').addClass('red').prependTo(dernierP).text('V/. ');\n
					
							$('<br>').appendTo('.repons .latin');\n
							$('<br>').appendTo('.repons .francais');\n
						";
					break; // Fin de Répons Bref
				
				/*
				 * Cantique Evangélique aux grandes heures et complies
				 */
				case "#CANT_EV" :
					$antEvLat = utf8_encode($this->antEv('latin'));
					$antEvFr = str_replace("’", "'", utf8_encode($this->antEv('francais')));
					switch ($this->typeOffice()) {
						case "laudes":
							// Antienne avant et apres cantique
							print "$('.antEv').show();\n";
							print "$('<p>').appendTo('.antEv .latin').text(\"$antEvLat\");\n";
							print "$('<p>').appendTo('.antEv .francais').text(\"$antEvFr\");\n";
							print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');\n";
							// Benedictus
							print $this->affichePsaume('benedictus', '.cantiqueEv');
							//Gloria Patri
							print $this->gloriaPatri('.gloriapatriEv');
							break;
						case "vepres":
							// Antienne avant et apres cantique
							print "$('.antEv').show();\n";
							print "$('<p>').appendTo('.antEv .latin').text(\"$antEvLat\");\n";
							print "$('<p>').appendTo('.antEv .francais').text(\"$antEvFr\");\n";
							print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');\n";
							// Benedictus
							print $this->affichePsaume('magnificat', '.cantiqueEv');
							//Gloria Patri
							print $this->gloriaPatri('.gloriapatriEv');
							break;
						case "complies":
							// Antienne avant et apres cantique
							print "$('.antEv').show();\n";
							print "$('<p>').appendTo('.antEv .latin').text(\"$antEvLat\");\n";
							print "$('<p>').appendTo('.antEv .francais').text(\"$antEvFr\");\n";
							print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');\n";
							// Benedictus
							print $this->affichePsaume('nuncdimittis', '.cantiqueEv');
							//Gloria Patri
							print $this->gloriaPatri('.gloriapatriEv');
							break;
					}
					break; // Fin de cantique Evangélique
				
				/*
				 * Preces aux grandes heures
				 */
				case "#PRECES" :
					print $this->affichePreces($this->preces());
					break; // Fin de #PRECES
				
				// Pater
				case "#PATER" :
					print "$('.pater').show();";
					print "$('<h2>').appendTo('.pater .latin').text('Pater Noster');\n";
					print "$('<h2>').appendTo('.pater .francais').text('Notre Père');\n";
					print "$('<p>').appendTo('.pater .latin').text('Pater noster, qui es in cælis:');\n";
					print "$('<p>').appendTo('.pater .latin').text('sanctificétur nomen tuum;');\n";
					print "$('<p>').appendTo('.pater .latin').text('advéniat regnum tuum;');\n";
					print "$('<p>').appendTo('.pater .latin').text('fiat volúntas tua, sicut in cælo et in terra.');\n";
					print "$('<p>').appendTo('.pater .latin').text('Panem nostrum cotidiánum da nobis hódie;');\n";
					print "$('<p>').appendTo('.pater .latin').text('et dimítte nobis débita nostra,');\n";
					print "$('<p>').appendTo('.pater .latin').text('sicut et nos dimíttimus debitóribus nostris;');\n";
					print "$('<p>').appendTo('.pater .latin').text('et ne nos indúcas in tentatiónem;');\n";
					print "$('<p>').appendTo('.pater .latin').text('sed líbera nos a malo.');\n";
						
					print "$('<p>').appendTo('.pater .francais').text('Notre Père, qui es aux Cieux,');\n";
					print "$('<p>').appendTo('.pater .francais').text('que ton nom soit sanctifié;');\n";
					print "$('<p>').appendTo('.pater .francais').text('que ton règne arrive;');\n";
					print "$('<p>').appendTo('.pater .francais').text('que ta volonté soit faite au Ciel comme sur la terre.');\n";
					print "$('<p>').appendTo('.pater .francais').text(\"Donne-nous aujourd'hui notre pain quotidien,\");\n";
					print "$('<p>').appendTo('.pater .francais').text('et remets-nous nos dettes,');\n";
					print "$('<p>').appendTo('.pater .francais').text('comme nous les remettons nous-mêmes à nos débiteurs ;');\n";
					print "$('<p>').appendTo('.pater .francais').text(\"et ne nous abandonne pas dans l'épreuve,\");\n";
					print "$('<p>').appendTo('.pater .francais').text('mais délivre-nous du malin.');\n";
					break; // Fin de #PATER
				
				// Oratio
				case "#ORATIO" :
					print "$('.oratio').show();\n";
					print "$('<h2>').appendTo('.oratio .latin').text('Oratio');\n";
					print "$('<h2>').appendTo('.oratio .francais').text('Oraison');\n";
					if (!$oratiolat) $oratiolat=utf8_encode($this->oratio('latin'));
					if (!$oratiofr) $oratiofr=utf8_encode(str_replace("\x92", "'", $this->oratio('francais')));
					
					switch ($this->typeOffice()) {
						case "laudes":
						case "vepres":
							if ((substr($oratiolat,-6))=="minum.") {
								$oratiolat=str_replace(substr($oratiolat,-13), " Per Dóminum nostrum Iesum Christum, Fílium tuum, qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sǽcula sæculórum.",$oratiolat);
								$oratiofr.=" Par notre Seigneur Jésus-Christ, ton Fils, qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
							}
							if ((substr($oratiolat,-11))==" Qui tecum.") {
								$oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unitáte Spíritus Sancti, Deus, per ómnia sǽcula sæculórum.",$oratiolat);
								$oratiofr.=" Lui qui vit et règne avec toi dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
							}
							if ((substr($oratiolat,-11))==" Qui vivis.") {
								$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unitáte Spíritus Sancti, Deus, per ómnia sǽcula sæculórum.",$oratiolat);
								$oratiofr.=" Toi qui vis et règnes avec Dieu le Père dans l'unité du Saint-Esprit, Dieu, pour tous les siècles des siècles.";
							}
							break;
						case "tierce":
						case "sexte":
						case "none":
						case "complies":
							print "$('<p>').appendTo('.oratio .latin').text('Orémus.');\n";
							print "$('<p>').appendTo('.oratio .francais').text('Prions.');\n";
							switch (substr($oratiolat,-6)){
								case "istum." :
									$oratiolat=str_replace(" Per Christum.", " Per Christum Dóminum nostrum.",$oratiolat);
									$oratiofr.=" Par le Christ notre Seigneur.";
									break;
								case "minum." :
									$oratiolat=str_replace(substr($oratiolat,-13), " Per Christum Dóminum nostrum.",$oratiolat);
									$oratiofr.=" Par le Christ notre Seigneur.";
									break;
								case "tecum." :
									$oratiolat=str_replace(" Qui tecum.", " Qui vivit et regnat in sǽcula sæculórum.",$oratiolat);
									$oratiofr.=" Lui qui vit et règne pour tous les siècles des siècles.";
									break;
								case "vivit.":
									$oratiolat=str_replace(" Qui vivit.", " Qui vivit et regnat in sǽcula sæculórum.",$oratiolat);
									$oratiofr.=" Lui qui vit et règne pour tous les siècles des siècles.";
									break;
								case "vivis." :
									$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas in sǽcula sæculórum.",$oratiolat);
									$oratiofr.=" Toi qui vis et règnes pour tous les siècles des siècles.";
									break;
							}
							break;
					}
					print "$('<p>').appendTo('.oratio .latin').text(\"$oratiolat\");\n";
					print "$('<p>').appendTo('.oratio .francais').text(\"$oratiofr\");\n";
					print "$('<p>').appendTo('.oratio .latin').text('Amen.');\n";
					print "$('<p>').appendTo('.oratio .francais').text('Amen.');\n";
					$dernierP = "$('.oratio .latin p').last()";
					print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					$dernierP = "$('.oratio .francais p').last()";
					print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					break; // Fin de #ORATIO
				
				// #BENEDICTIO
				case "#BENEDICTIO" :
					switch ($this->typeOffice()) {
						case "laudes":
						case "vepres":
							print "$('.benediction').show();\n";
							print "$('<h2>').appendTo('.benediction .latin').text('Benedictio');\n";
							print "$('<h2>').appendTo('.benediction .francais').text('Bénédiction');\n";
							print "$('<h5>').appendTo('.benediction .latin').text('Deinde, si præest sacerdos vel diaconus, populum dimittit, dicens:');\n";
							print "$('<h5>').appendTo('.benediction .francais').text(\"Ensuite, si l'office est présidé par un prêtre ou un diacre, il renvoie le peuple, en disant :\");\n";
							print "$('<p>').appendTo('.benediction .latin').text('Dóminus vobíscum.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Le Seigneur soit avec vous.');\n";
							print "$('<p>').appendTo('.benediction .latin').text('Et cum spíritu tuo.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Et avec votre Esprit.');\n";
							$dernierP = "$('.benediction .latin p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							$dernierP = "$('.benediction .francais p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					
							print "$('<p>').appendTo('.benediction .latin').text('Benedícat vos omnípotens Deus, Pater, et Fílius, et Spíritus Sanctus.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Que le Dieu tout puissant vous bénisse, le Père, le Fils, et le Saint Esprit.');\n";
							print "$('<p>').appendTo('.benediction .latin').text('Amen.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Amen.');\n";
							$dernierP = "$('.benediction .latin p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							$dernierP = "$('.benediction .francais p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					
							print "$('<h5>').appendTo('.benediction .latin').text('Vel alia formula benedictionis, sicut in Missa.');\n";
							print "$('<h5>').appendTo('.benediction .francais').text(\"Ou une autre formule de bénédiction, comme à la Messe.\");\n";
							print "$('<h5>').appendTo('.benediction .latin').text('Et, si fit dimissio, sequitur invitatio:');\n";
							print "$('<h5>').appendTo('.benediction .francais').text(\"Et, si on fait un envoi, on poursuit par l'invitation :\");\n";
							print "$('<p>').appendTo('.benediction .latin').text('Ite in pace.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Allez en Paix.');\n";
							print "$('<p>').appendTo('.benediction .latin').text('Deo grátias.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Rendons grâces à Dieu.');\n";
							$dernierP = "$('.benediction .latin p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							$dernierP = "$('.benediction .francais p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					
							print "$('<h5>').appendTo('.benediction .latin').text('Absente sacerdote vel diacono, et in recitatione a solo, sic concluditur:');\n";
							print "$('<h5>').appendTo('.benediction .francais').text(\"En l'absence d'un prêtre ou d'un diacre, et dans la récitation seul, on conclut ainsi :\");\n";
							print "$('<p>').appendTo('.benediction .latin').text('Dóminus nos benedícat, et ab omni malo deféndat, et ad vitam perdúcat ætérnam.');\n";
							print "$('<p>').appendTo('.benediction .francais').text(\"Que le Seigneur nous bénisse, et qu'il nous défende de tout mal, et nous conduise à la vie éternelle.\");\n";
							print "$('<p>').appendTo('.benediction .latin').text('Amen.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Amen.');\n";
							$dernierP = "$('.benediction .latin p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							$dernierP = "$('.benediction .francais p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							break;
						case "complies":
							print "$('<h5>').appendTo('.benediction .latin').text('Deinde dicitur, etiam a solo, benedictio:');\n";
							print "$('<h5>').appendTo('.benediction .francais').text(\"Ensuite on dit, même seul, la bénédiction :\");\n";
							print "$('<p>').appendTo('.benediction .latin').text('Noctem quiétam et finem perféctum concédat nobis Dóminus omnípotens.');\n";
							print "$('<p>').appendTo('.benediction .francais').text(\"Que le Dieu tout-puissant nous accorde une nuit tranquille et une fin parfaite.\");\n";
							$dernierP = "$('.benediction .latin p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('V/. ');\n";
							$dernierP = "$('.benediction .francais p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('V/. ');\n";
					
							print "$('<p>').appendTo('.benediction .latin').text('Amen.');\n";
							print "$('<p>').appendTo('.benediction .francais').text('Amen.');\n";
							$dernierP = "$('.benediction .latin p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							$dernierP = "$('.benediction .francais p').last()";
							print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
							break;
					}
					break; // Fin de #BENEDICTIO
				
				// #ACCLAMATIO
				case "#ACCLAMATIO" :
					print "$('.acclamation').show();\n";
					print "$('<h2>').appendTo('.acclamation .latin').text('Acclamatio');\n";
					print "$('<p>').appendTo('.acclamation .latin').text('Benedicámus Dómino.');\n";
					$dernierP = "$('.acclamation p').last()";
					print "$('<span>').addClass('red').prependTo($dernierP).text('V/. ');\n";
					print "$('<p>').appendTo('.acclamation .latin').text('Deo grátias.');\n";
					$dernierP = "$('.acclamation p').last()";
					print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					print "$('<h2>').appendTo('.acclamation .francais').text('Acclamation');\n";
					print "$('<p>').appendTo('.acclamation .francais').text('Bénissons le Seigneur.');\n";
					$dernierP = "$('.acclamation p').last()";
					print "$('<span>').addClass('red').prependTo($dernierP).text('V/. ');\n";
					print "$('<p>').appendTo('.acclamation .francais').text('Nous rendons grâces à Dieu.');\n";
					$dernierP = "$('.acclamation p').last()";
					print "$('<span>').addClass('red').prependTo($dernierP).text('R/. ');\n";
					break; // Fin de #ACCLAMATIO
				
				//Cantique mariale aux complies
				case "#ANT_MARIALE" :
					print $this->affichePsaume($this->cantiqueMarial(), 'antMariale');
					break; // Fin de #ANT_MARIALE
			}
		}
	}
}

?>