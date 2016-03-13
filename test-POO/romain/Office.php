<?php

class Office {
	var $typeOffice;
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
	function setInvitatoire($invitatoire){
		if ($invitatoire) $this->invitatoire = false;
		else $this->invitatoire = true;
	}
	function setHymne($hymne) { $this->hymne = $hymne; }
	function setAnt1($antLat, $antFr) { 
		$this->ant1[latin] = $antLat;
		$this->ant1[francais] = $antFr;
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
		$this->repons['latin'] = $reponsFr;
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
				$latin=$data[0];$francais=$data[1];
				if($row==0) {
					$hymne.="$('<h2>').appendTo('.hymne .latin').text('$latin');\n";
					$hymne.="$('<h2>').appendTo('.hymne .francais').text('$francais');\n";
				}
				elseif ($latin=="") {
					$hymne.="$('<p>').appendTo('.hymne .latin');\n";
					$hymne.="$('<p>').appendTo('.hymne .francais');\n";
				}
				else {
					$hymne.="$('<p>').appendTo('.hymne .latin').text('$latin');\n";
					$hymne.="$('<p>').appendTo('.hymne .francais').text('$francais');\n";
				}
				$row++;
			}
			fclose ($fp);
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
				if (($row==0)&&($data[0]!="")) {
					$psaume.="$('<h2>').appendTo('$emplacement .latin').text('$data[0]');\n";
					$psaume.="$('<h2>').appendTo('$emplacement .francais').text('$data[1]');\n";
				}
				elseif (($row==1)&&($data[0]!="")) {
					$psaume.="$('<h3>').appendTo('$emplacement .latin').text('$data[0]');\n";
					$psaume.="$('<h3>').appendTo('$emplacement .francais').text('$data[1]');\n";
				}
				elseif (($row==2)&&($data[0]!="")) {
					$psaume.="$('<h4>').appendTo('$emplacement .latin').text('$data[0]');\n";
					$psaume.="$('<h4>').appendTo('$emplacement .francais').text('$data[1]');\n";
				}
				elseif (($row==3)&&($data[0]!="")) {
					$psaume.="$('<h2>').appendTo('$emplacement .latin').text('$data[0]');\n";
					$psaume.="$('<h2>').appendTo('$emplacement .francais').text('$data[1]');\n";
				}
				else {
					$psaume.="$('<p>').appendTo('$emplacement .latin').text('$data[0]');\n";
					$psaume.="$('<p>').appendTo('$emplacement .francais').text('$data[1]');\n";
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
				$latin=$data[0];$francais=$data[1];
				if($row==0) {
					$lectio.="$('<h2>').appendTo('.lectio .latin').text('$latin');\n";
					$lectio.="$('<h2>').appendTo('.lectio .francais').text('$francais');\n";
				}
				else {
					$lectio.="$('<p>').appendTo('.lectio .latin').text('$latin');\n";
					$lectio.="$('<p>').appendTo('.lectio .latin').text('$francais');\n";
				}
				$row++;
			}
			fclose ($fp);
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
		$fichier="preces/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="preces/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("$('<p>').appendTo('.erreurs').text(\".$fichier introuvable !\");\n");
		else {
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$latin=$data[0];$francais=$data[1];
				if($row==0) {
					$preces.="$('<h2>').appendTo('.preces .latin').text('$latin');\n";
					$preces.="$('<h2>').appendTo('.preces .francais').text('$francais');\n";
				}
				else {
					$preces.="$('<p>').appendTo('.preces .latin').text('$latin');\n";
					$preces.="$('<p>').appendTo('.preces .francais').text('$francais');\n";
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
		
		// Verset d'introduction sauf si invitatoire aux Laudes et vigiles
		$invitatoire = $this->invitatoire();
		if ($invitatoire) {
			print "
					$('.verset-intro .latin').show()\n
					$('<p>').appendTo('.verset-intro .latin').text('Deus, in adiutórium meum inténde.');\n
					var premierP = $('.verset-intro .latin p:first');\n
					$('<span>').addClass('red').prependTo(premierP).text('R. ');\n
                	$('<p>').appendTo('.verset-intro .latin').text('Dómine, ad adiuvándum me festína.');\n
					var secondP = premierP.next();\n
					$('<span>').addClass('red').prependTo(secondP).text('V. ');\n
            		$('<p>').appendTo('.verset-intro .latin').text('Gloria Patri, et Fílio, * et Spirítui Sancto.');\n
					$('<p>').appendTo('.verset-intro .latin').text('Sicut erat in principio, et nunc et semper * et in sæcula sæculórum. Amen.');\n
					
					$('.verset-intro .francais').show();\n
                    $('<p>').appendTo('.verset-intro .francais').text('O Dieu, hâte-toi de me délivrer !');\n
					var premierP = $('.verset-intro .francais p:first');\n
					$('<span>').addClass('red').prependTo(premierP).text('R. ');\n
                	$('<p>').appendTo('.verset-intro .francais').text('Seigneur, hâte-toi de me secourir !');\n
					var secondP = premierP.next();\n
					$('<span>').addClass('red').prependTo(secondP).text('V. ');\n
            		$('<p>').appendTo('.verset-intro .francais').text('Gloire au Père et au Fils et au Saint-Esprit,');\n
					$('<p>').appendTo('.verset-intro .francais').text('Comme il était au commencement, maintenant et toujours,');\n
					$('<p>').appendTo('.verset-intro .francais').text('Et dans les siècles des siècles. Amen.');\n
					";
		}
		
		// Examen de conscience aux Complies
		if ($this->typeOffice() == 'Complies') {
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
					$('<span>').addClass('red').prependTo(dernierP).text('V. ');\n
					$('<p>').appendTo('.examen-conscience .latin').text('Amen.');\n
					dernierP = $('.examen-conscience .latin p').last();\n
					$('<span>').addClass('red').prependTo(dernierP).text('R. ');\n
							
					$('.examen-conscience .francais').show();\n
					$('<h2>').appendTo('.examen-conscience .francais').text('Examen de conscience');\n
					$('<p>').appendTo('.examen-conscience .francais').text(\"Je confesse à Dieu tout puissant et à vous, mes frères, car j'ai péché par la pensée, la parole, les actes et par omission :\");\n
					$('<h5>').appendTo('.examen-conscience .francais').text('et, en se frappant la poitrine, on dit :');\n
					$('<p>').appendTo('.examen-conscience .francais').text('je suis coupable, je suis coupable, je suis grandement coupable.');\n
					$('<h5>').appendTo('.examen-conscience .francais').text('ensuite, on continue :');\n
					$('<p>').appendTo('.examen-conscience .francais').text(\"C'est pourquoi je supplie la bienheureuse Marie toujours Vierge, tous les Anges et les Saints, et vous, frères, de prier pour moi le Seigneur notre Dieu.\");\n
					$('<p>').appendTo('.examen-conscience .francais').text('Aie pitié de nous Dieu tout puissant et, nos péchés ayant été renvoyés, conduis-nous à la vie éternelle.');\n
					var dernierP = $('.examen-conscience .francais p').last();\n
					$('<span>').addClass('red').prependTo(dernierP).text('V. ');\n
					$('<p>').appendTo('.examen-conscience .francais').text('Amen.');\n
					dernierP = $('.examen-conscience .francais p').last();\n
					$('<span>').addClass('red').prependTo(dernierP).text('R. ');\n
					";
		}
		
		/*
		 * Hymne
		 * appelle la methode afficheHymne($ref) avec la reference de l'hymne en argument
		 */
		print $this->afficheHymne($this->hymne());
		
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
		$ant1Lat = $this->ant1('latin');
		$ant1Fr = $this->ant1('francais');
		$ant2Lat = $this->ant2('latin');
		$ant2Fr = $this->ant2('francais');
		$ant3Lat = $this->ant3('latin');
		$ant3Fr = $this->ant3('francais');
		switch ($this->typeOffice()) {
			case "laudes":
			case "vepres":
				//Antienne 1 avant le psaume position 11
				print "$('.ant11').show();\n";
				print "$('<p>').appendTo('.ant11 .latin').text('$ant1Lat');\n";
				print "$('<p>').appendTo('.ant11 .francais').text('$ant1Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. 1 : ');\n";
				//psaume 1
				print $this->affichePsaume($this->ps1(), ".psaume1");
				// gloria patri1
				print $this->gloriaPatri('.gloriapatri1');
				//Antienne 1 apres le psaume position 12
				print "$('.ant12').show();\n";
				print "$('<p>').appendTo('.ant12 .latin').text('$ant1Lat');\n";
				print "$('<p>').appendTo('.ant12 .francais').text('$ant1Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant12 p').text('Ant. : ');\n";
				//Antienne 2 avant le psaume position 21
				print "$('.ant21').show();\n";
				print "$('<p>').appendTo('.ant21 .latin').text('$ant2Lat');\n";
				print "$('<p>').appendTo('.ant21 .francais').text('$ant2Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant21 p').text('Ant. 2 : ');\n";
				//psaume 2
				print $this->affichePsaume($this->ps2(), ".psaume2");
				// gloria patri2
				print $this->gloriaPatri('.gloriapatri2');
				//Antienne 2 apres le psaume position 22
				print "$('.ant11').show();\n";
				print "$('<p>').appendTo('.ant22 .latin').text('$ant2Lat');\n";
				print "$('<p>').appendTo('.ant22 .francais').text('$ant2Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant22 p').text('Ant. : ');\n";
				//Antienne 3 avant le psaume position 31
				print "$('.ant11').show();\n";
				print "$('<p>').appendTo('.ant31 .latin').text('$ant3Lat');\n";
				print "$('<p>').appendTo('.ant31 .francais').text('$ant3Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant31 p').text('Ant. 3 : ');\n";
				//psaume 3
				print $this->affichePsaume($this->ps3(), ".psaume3");
				// gloria patri3
				print $this->gloriaPatri('.gloriapatri3');
				//Antienne 3 apres le psaume position 32
				print "$('.ant11').show();\n";
				print "$('<p>').appendTo('.ant32 .latin').text('$ant3Lat');\n";
				print "$('<p>').appendTo('.ant32 .francais').text('$ant3Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant32 p').text('Ant. : ');\n";
				break;
			case "tierce":
			case "sexte":
			case "none":
				//Antienne avant le psaume position 11
				print "$('.ant11').show();\n";
				print "$('<p>').appendTo('.ant11 .latin').text('$ant1Lat');\n";
				print "$('<p>').appendTo('.ant11 .francais').text('$ant1Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. : ');\n";
				//psaume 1
				print $this->affichePsaume($this->ps1(), ".psaume1");
				// gloria patri1
				print $this->gloriaPatri('.gloriapatri1');
				//psaume 2
				print $this->affichePsaume($this->ps2(), ".psaume2");
				// gloria patri2
				print $this->gloriaPatri('.gloriapatri2');
				//psaume 3
				// gloria patri3
				print $this->gloriaPatri('.gloriapatri3');
				//antienne apres le psaume position 32
				print "$('.ant32').show();\n";
				print "$('<p>').appendTo('.ant32 .latin').text('$ant1Lat');\n";
				print "$('<p>').appendTo('.ant32 .francais').text('$ant1Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant32 p').text('Ant. : ');\n";
				break;
			case "complies":
				//Antienne 1 avant le psaume position 11
				print "$('.ant11').show();\n";
				print "$('<p>').appendTo('.ant11 .latin').text('$ant1Lat');\n";
				print "$('<p>').appendTo('.ant11 .francais').text('$ant1Fr'));\n";
				print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. : ');\n";
				//psaume 1
				print $this->affichePsaume($this->ps1(), ".psaume1");
				// gloria patri1
				print $this->gloriaPatri('.gloriapatri1');
				//antienne 1 apres le psaume position 12
				print "$('.ant12').show();\n";
				print "$('<p>').appendTo('.ant12 .latin').text('$ant1Lat');\n";
				print "$('<p>').appendTo('.ant12 .francais').text('$ant1Fr');\n";
				print "$('<span>').addClass('red').prependTo('.ant12 p').text('Ant. : ');\n";
				if ($this->ps2()) {
					//Si psaume2 Antienne 2 avant le psaume position 21
					print "$('.ant21').show();\n";
					print "$('<p>').appendTo('.ant21 .latin').text('$ant2Lat');\n";
					print "$('<p>').appendTo('.ant21 .francais').text('$ant2Fr');\n";
					print "$('<span>').addClass('red').prependTo('.ant21 p').text('Ant. 2 : ');\n";
					//psaume 2
					print $this->affichePsaume($this->ps2(), ".psaume2");
					// gloria patri2
					print $this->gloriaPatri('.gloriapatri2');
					//Antienne 2 apres le psaume position 22
					print "$('.ant22').show();\n";
					print "$('<p>').appendTo('.ant22 .latin').text('$ant2Lat');\n";
					print "$('<p>').appendTo('.ant22 .francais').text('$ant2Fr');\n";
					print "$('<span>').addClass('red').prependTo('.ant22 p').text('Ant. : ');\n";
				}
				break;
		}
		
		/*
		 * lectio
		 */
		print $this->AfficheLectio($this->lectio());
		
		/*
		 * répons grandes heures et complies / verset petites heures
		 */
		$reponsLat = $this->repons('latin');
		$reponsFr = $this->repons('francais');
		print "$('.repons').show();\n";
		print "$('<p>').appendTo('.repons .latin').text('$reponsLat');\n";
		print "$('<p>').appendTo('.repons .francais').text('$reponsFr');\n";
		
		/*
		 * Cantique Evangélique aux grandes heures et complies
		 */
		$antEvLat = $this->antEv('latin');
		$antEvFr = $this->antEv('francais');
		switch ($this->typeOffice()) {
			case "laudes":
				// Antienne avant et apres cantique
				print "$('.antEv').show();\n";
				print "$('<p>').appendTo('.antEv .latin').text('$antEvLat');\n";
				print "$('<p>').appendTo('.antEv .francais').text('$antEvFr');\n";
				print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');\n";
				// Benedictus
				print $this->affichePsaume('benedictus', '.cantiqueEv');
				//Gloria Patri
				print $this->gloriaPatri('.gloriapatriEv');
				break;
			case "vepres":
				// Antienne avant et apres cantique
				print "$('.antEv').show();\n";
				print "$('<p>').appendTo('.antEv .latin').text('$antEvLat');\n";
				print "$('<p>').appendTo('.antEv .francais').text('$antEvFr');\n";
				print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');\n";
				// Benedictus
				print $this->affichePsaume('magnificat', '.cantiqueEv');
				//Gloria Patri
				print $this->gloriaPatri('.gloriapatriEv');
				break;
			case "complies":
				// Antienne avant et apres cantique
				print "$('.antEv').show();\n";
				print "$('<p>').appendTo('.antEv .latin').text''$antEvLat');\n";
				print "$('<p>').appendTo('.antEv .francais').text('$antEvFr');\n";
				print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');\n";
				// Benedictus
				print $this->affichePsaume('nuncdimittis', '.cantiqueEv');
				//Gloria Patri
				print $this->gloriaPatri('.gloriapatriEv');
				break;
		}
		
		/*
		 * Preces aux grandes heures
		 */
		if (($this->typeOffice() == "laudes")||($this->typeOffice() == "vepres")) {
			print $this->affichePreces($this->preces());
		}
		
		/*
		 * Pater aux grandes heures
		 */
		if (($this->typeOffice() == "laudes")||($this->typeOffice() == "vepres")) {
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
		}
		
		/*
		 * Oratio
		 */
		print "$('.oratio').show();\n";
		print "$('<h2>').appendTo('.oratio .latin').text('Oratio');\n";
		print "$('<h2>').appendTo('.oratio .francais').text('Oraison');\n";
		$oratiolat=$this->oratio('latin');
		$oratiofr=$this->oratio('francais');
		
		switch ($this->typeOffice()) {
			case "laudes":
			case "vepres":
				if ((substr($oratiolat,-6))=="minum.") {
					$oratiolat=str_replace(substr($oratiolat,-13), " Per D&oacute;minum nostrum Iesum Christum, F&iacute;lium tuum, qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
					$oratiofr.=" Par notre Seigneur J&eacute;sus-Christ, ton Fils, qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
				}
				if ((substr($oratiolat,-11))==" Qui tecum.") {
					$oratiolat=str_replace(" Qui tecum.", " Qui tecum vivit et regnat in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
					$oratiofr.=" Lui qui vit et r&egrave;gne avec toi dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
				}
				if ((substr($oratiolat,-11))==" Qui vivis.") {
					$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas cum Deo Patre in unit&aacute;te Sp&iacute;ritus Sancti, Deus, per &oacute;mnia s&aelig;cula s&aelig;cul&oacute;rum.",$oratiolat);
					$oratiofr.=" Toi qui vis et r&egrave;gnes avec Dieu le P&egrave;re dans l'unit&eacute; du Saint-Esprit, Dieu, pour tous les si&egrave;cles des si&egrave;cles.";
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
						$oratiolat=str_replace(" Per Christum.", " Per Christum D&oacute;minum nostrum.",$oratio3lat);
						$oratiofr.=" Par le Christ notre Seigneur.";
						break;
					case "minum." :
						$oratiolat=str_replace(substr($oratio3lat,-13), " Per Christum D&oacute;minum nostrum.",$oratio3lat);
						$oratiofr.=" Par le Christ notre Seigneur.";
						break;
					case "tecum." :
						$oratiolat=str_replace(" Qui tecum.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio3lat);
						$oratiofr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
						break;
					case "vivit.":
						$oratiolat=str_replace(" Qui vivit.", " Qui vivit et regnat in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio3lat);
						$oratiofr.=" Lui qui vit et r&egrave;gne pour tous les si&egrave;cles des si&egrave;cles.";
						break;
					case "vivis." :
						$oratiolat=str_replace(" Qui vivis.", " Qui vivis et regnas in s&aelig;cula s&aelig;cul&oacute;rum.",$oratio3lat);
						$oratiofr.=" Toi qui vis et r&egrave;gnes pour tous les si&egrave;cles des si&egrave;cles.";
						break;
				}
				break;
		}
		print "$('<p>').appendTo('.oratio .latin').text('$oratiolat');\n";
		print "$('<p>').appendTo('.oratio .francais').text('$oratiofr');\n";
		print "$('<p>').appendTo('.oratio .latin').text('Amen.');\n";
		print "$('<p>').appendTo('.oratio .francais').text('Amen.');\n";
		$dernierP = "$('.oratio .latin p').last()";
		print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
		$dernierP = "$('.oratio .francais p').last()";
		print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
		
		/*
		 * Benedictio aux grandes heures et complies
		 */
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
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				$dernierP = "$('.benediction .francais p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				
				print "$('<p>').appendTo('.benediction .latin').text('Benedícat vos omnípotens Deus, Pater, et Fílius, et Spíritus Sanctus.');\n";
				print "$('<p>').appendTo('.benediction .francais').text('Que le Dieu tout puissant vous bénisse, le Père, le Fils, et le Saint Esprit.');\n";
				print "$('<p>').appendTo('.benediction .latin').text('Amen.');\n";
				print "$('<p>').appendTo('.benediction .francais').text('Amen.');\n";
				$dernierP = "$('.benediction .latin p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				$dernierP = "$('.benediction .francais p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				
				print "$('<h5>').appendTo('.benediction .latin').text('Vel alia formula benedictionis, sicut in Missa.');\n";
				print "$('<h5>').appendTo('.benediction .francais').text(\"Ou une autre formule de bénédiction, comme à la Messe.\");\n";
				print "$('<h5>').appendTo('.benediction .latin').text('Et, si fit dimissio, sequitur invitatio:');\n";
				print "$('<h5>').appendTo('.benediction .francais').text(\"Et, si on fait un envoi, on poursuit par l'invitation :\");\n";
				print "$('<p>').appendTo('.benediction .latin').text('Ite in pace.');\n";
				print "$('<p>').appendTo('.benediction .francais').text('Allez en Paix.');\n";
				print "$('<p>').appendTo('.benediction .latin').text('Deo grátias.');\n";
				print "$('<p>').appendTo('.benediction .francais').text('Rendons grâces à Dieu.');\n";
				$dernierP = "$('.benediction .latin p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				$dernierP = "$('.benediction .francais p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				
				print "$('<h5>').appendTo('.benediction .latin').text('Absente sacerdote vel diacono, et in recitatione a solo, sic concluditur:');\n";
				print "$('<h5>').appendTo('.benediction .francais').text(\"En l'absence d'un prêtre ou d'un diacre, et dans la récitation seul, on conclut ainsi :\");\n";
				print "$('<p>').appendTo('.benediction .latin').text('Dóminus nos benedícat, et ab omni malo deféndat, et ad vitam perdúcat ætérnam.');\n";
				print "$('<p>').appendTo('.benediction .francais').text(\"Que le Seigneur nous bénisse, et qu'il nous défende de tout mal, et nous conduise à la vie éternelle.\");\n";
				print "$('<p>').appendTo('.benediction .latin').text('Amen.');\n";
				print "$('<p>').appendTo('.benediction .francais').text('Amen.');\n";
				$dernierP = "$('.benediction .latin p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				$dernierP = "$('.benediction .francais p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				break;
			case "complies":
				print "$('<h5>').appendTo('.benediction .latin').text('Deinde dicitur, etiam a solo, benedictio:');\n";
				print "$('<h5>').appendTo('.benediction .francais').text(\"Ensuite on dit, même seul, la bénédiction :\");\n";
				print "$('<p>').appendTo('.benediction .latin').text('Noctem quiétam et finem perféctum concédat nobis Dóminus omnípotens.');\n";
				print "$('<p>').appendTo('.benediction .francais').text(\"Que le Dieu tout-puissant nous accorde une nuit tranquille et une fin parfaite.\");\n";
				$dernierP = "$('.benediction .latin p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('V. ');\n";
				$dernierP = "$('.benediction .francais p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('V. ');\n";
				
				print "$('<p>').appendTo('.benediction .latin').text('Amen.');\n";
				print "$('<p>').appendTo('.benediction .francais').text('Amen.');\n";
				$dernierP = "$('.benediction .latin p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				$dernierP = "$('.benediction .francais p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				break;
		}
		
		/*
		 * Acclamatio aux petites heures
		 */
		switch ($this->typeOffice()) {
			case "tierce":
			case "sexte":
			case "none":
				print "$('.acclamation').show();\n";
				print "$('<h2>').appendTo('.acclamation .latin').text('Acclamtio');\n";
				print "$('<h2>').appendTo('.acclamation .francais').text('Acclamtion');\n";
				print "$('<p>').appendTo('.acclamation .latin').text('Benedicámus Dómino.');\n";
				print "$('<p>').appendTo('.acclamation .francais').text('Bénissons le Seigneur.');\n";
				print "$('<p>').appendTo('.acclamation .latin').text('Deo grátias.');\n";
				print "$('<p>').appendTo('.acclamation .francais').text('Nous rendons grâces à Dieu.');\n";
				$dernierP = "$('.acclamation p').last()";
				print "$('<span>').addClass('red').prependTo($dernierP).text('R. ');\n";
				break;
		}
		
		/*
		 * Cantique mariale aux complies
		 */
		if (($this->typeOffice() == 'complies')) print $this->affichePsaume($this->cantiqueMarial(), 'antMariale');
	}
}

?>