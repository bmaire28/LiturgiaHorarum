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
	var $psEv;
	var $preces;
	var $oratio;
	var $cantiqueMarial;
	
	/*
	 * getters
	 */
	function typeOffice() { return $this->typeOffice; }
	function invitatoire() { return $this->invitatoire; }
	function hymne() { return $this->hymne; }
	function ant1($langue) { 
		if ($langue == 'latin') { return $this->ant1['latin'];}
		elseif ($langue == 'francais') { return $this->ant1['francais'];}
	}
	function ps1(){ return $this->ps1; }
	function ant2($langue) {
		if ($langue == 'latin') { return $this->ant1['latin'];}
		elseif ($langue == 'francais') { return $this->ant1['francais'];}
	}
	function ps2(){ return $this->ps2; }
	function ant3($langue) {
		if ($langue == 'latin') { return $this->ant1['latin'];}
		elseif ($langue == 'francais') { return $this->ant1['francais'];}
	}
	function ps3(){ return $this->ps3; }
	function lectio(){ return $this->lectio; }
	function repons($langue) {
		if ($langue == 'latin') { return $this->ant1['latin'];}
		elseif ($langue == 'francais') { return $this->ant1['francais'];}
	}
	function antEv($langue) {
		if ($langue == 'latin') { return $this->ant1['latin'];}
		elseif ($langue == 'francais') { return $this->ant1['francais'];}
	}
	function psEv() { return $this->psEv; }
	function preces() { return $this->preces; }
	function oratio($langue) {
		if ($langue == 'latin') { return $this->ant1['latin'];}
		elseif ($langue == 'francais') { return $this->ant1['francais'];}
	}
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
		$this->repons['latin'] = $reponsFr;
		$this->repons['francais'] = $reponsFr;
	}
	function setAntEv($antLat, $antFr) { 
		$this->antEv['latin'] = $antLat;
		$this->antEv['francais'] = $antFr;
	}
	function setPsEv($psaume) { $this->psEv = $psaume; }
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
		$hymne="$('.hymne').show();";
		// Creation du chemin relatif vers le fichier de l'hymne de facon brut
		$fichier="hymnaire/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="hymnaire/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$latin=$data[0];$francais=$data[1];
			if($row==0) {
				$hymne.="$('<h2>').appendTo('.latin .hymne').text('$latin');";
				$hymne.="$('<h2>').appendTo('.francais .hymne').text('$francais');";
			}
			elseif ($latin=="") {
				$hymne.="$('<p>').appendTo('.latin .hymne');";
				$hymne.="$('<p>').appendTo('.francais .hymne');";
			}
			else {
				$hymne.="$('<p>').appendTo('.latin .hymne').text('$latin');";
				$hymne.="$('<p>').appendTo('.francais .hymne').text('$francais');";
			}
			$row++;
		}
		fclose ($fp);
		$hymne.="$('<p>').appendTo('.latin .hymne');";
		$hymne.="$('<p>').appendTo('.francais .hymne');";
		return $hymne;
	}
	
	/*
	 * Affichage d'un psaume
	 */
	function affichePsaume($ref, $emplacement) {
		$row = 0;
		$psaume = "$('$emplacement').show();";
		// Creation du chemin relatif vers le fichier du psaume de facon brut
		$fichier="psautier/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="psautier/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$latin="";
			$francais="";
			if (($row==0)&&($data[0]!="")) {
				$psaume.="$('<h2>').appendTo('.latin $emplacement').text('$data[0]')";
				$psaume.="$('<h2>').appendTo('.francais $emplacement').text('$data[1]')";
			}
			elseif (($row==1)&&($data[0]!="")) {
				$psaume.="$('<h3>').appendTo('.latin $emplacement').text('$data[0]')";
				$psaume.="$('<h3>').appendTo('.francais $emplacement').text('$data[1]')";
			}
			elseif (($row==2)&&($data[0]!="")) {
				$psaume.="$('<h4>').appendTo('.latin $emplacement').text('$data[0]')";
				$psaume.="$('<h4>').appendTo('.francais $emplacement').text('$data[1]')";
			}
			elseif (($row==3)&&($data[0]!="")) {
				$psaume.="$('<h2>').appendTo('.latin $emplacement').text('$data[0]')";
				$psaume.="$('<h2>').appendTo('.francais $emplacement').text('$data[1]')";
			}
			else {
				$psaume.="$('<p>').appendTo('.latin $emplacement').text('$data[0]')";
				$psaume.="$('<p>').appendTo('.francais $emplacement').text('$data[1]')";
			}
			$row++;
		}
		fclose ($fp);
		return $psaume;
	}
	
	/*
	 * affiche le gloria patri apres un psaume
	 */
	function gloriaPatri ($emplacement) {
		$gloriaPatri = "$('$emplacement').show();";
		$gloriaPatri .= "
				$('<p>').appendTo('.latin $emplacement').text('Gloria Patri, et Fílio, * et Spirítui Sancto.');
				$('<p>').appendTo('.latin $emplacement').text('Sicut erat in principio, et nunc et semper * et in sæcula sæculórum. Amen.');
				
				$('<p>').appendTo('.francais $emplacement').text('Gloire au Père et au Fils et au Saint-Esprit,');
				$('<p>').appendTo('.francais $emplacement').text('Comme il était au commencement, maintenant et toujours,');
				$('<p>').appendTo('.francais $emplacement').text('Et dans les siècles des siècles. Amen.');
					
				";
	}
	
	/*
	 * Affiche la lectio
	 */
	function AfficheLectio($ref) {
		$row = 0;
		$lectio = "$('.lectio').show()";
		// Creation du chemin relatif vers le fichier de lectio de facon brut
		$fichier="lectionnaire/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="lectionnaire/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$latin=$data[0];$francais=$data[1];
			if($row==0) {
				$lectio.="$('<h2>').appendTo('.latin .lectio').text('$latin');";
				$lectio.="$('<h2>').appendTo('.francais .lectio').text('$francais');";
			}
			else {
				$lectio.="$('<p>').appendTo('.lectio .latin').text('$latin');";
				$lectio.="$('<p>').appendTo('.lectio .latin').text('$francais');";
			}
			$row++;
		}
		fclose ($fp);
		return $lectio;
	}
	
	/*
	 * Affiche les preces
	 */
	function affichePreces($ref){
		$row = 0;
		$preces="$('.preces').show();";
		// Creation du chemin relatif vers le fichier de preces de facon brut
		$fichier="preces/".$ref.".csv";
		// Verification du chemin brut, sinon creation du chemin relatif utf8
		if (!file_exists($fichier)) $fichier="preces/".utf8_encode($ref).".csv";
		if (!file_exists($fichier)) print_r("<p>".$fichier." introuvable !</p>");
		$fp = fopen ($fichier,"r");
		while ($data = fgetcsv ($fp, 1000, ";")) {
			$latin=$data[0];$francais=$data[1];
			if($row==0) {
				$preces.="$('<h2>').appendTo('.latin .preces').text('$latin');";
				$preces.="$('<h2>').appendTo('.francais .preces').text('$francais');";
			}
			else {
				$preces.="$('<p>').appendTo('.latin .preces').text('$latin');";
				$preces.="$('<p>').appendTo('.francais .preces').text('$francais');";
			}
			$row++;
		}
		fclose ($fp);
		return $preces;
	}
	
	/*
	 * Fonction d'affichage d'un office
	 */
	function affiche() {
		print "<script>";
		
		// Verset d'introduction sauf si invitatoire aux Laudes et vigiles
		if (!$this->invitatoire) {
			print "
					$('.latin .verset-intro').show()
					$('<p>').appendTo('.latin .verset-intro').text('Deus, in adiutórium meum inténde.');
					var premierP = $('.latin .verset-intro p:first');
					$('<span>').addClass('red').prependTo(premierP).text('R. ');
                	$('<p>').appendTo('.latin .verset-intro').text('Dómine, ad adiuvándum me festína.');
					var secondP = premierP.next();
					$('<span>').addClass('red').prependTo(secondP).text('V. ');
            		$('<p>').appendTo('.latin .verset-intro').text('Gloria Patri, et Fílio, * et Spirítui Sancto.');
					$('<p>').appendTo('.latin .verset-intro').text('Sicut erat in principio, et nunc et semper * et in sæcula sæculórum. Amen.');
					
					$('.francais .verset-intro').show();
                    $('<p>').appendTo('.francais .verset-intro').text('O Dieu, hâte-toi de me délivrer !');
					var premierP = $('.francais .verset-intro p:first');
					$('<span>').addClass('red').prependTo(premierP).text('R. ');
                	$('<p>').appendTo('.francais .verset-intro').text('Seigneur, hâte-toi de me secourir !');
					var secondP = premierP.next();
					$('<span>').addClass('red').prependTo(secondP).text('V. ');
            		$('<p>').appendTo('.francais .verset-intro').text('Gloire au Père et au Fils et au Saint-Esprit,');
					$('<p>').appendTo('.francais .verset-intro').text('Comme il était au commencement, maintenant et toujours,');
					$('<p>').appendTo('.francais .verset-intro').text('Et dans les siècles des siècles. Amen.');
					";
		}
		
		// Examen de conscience aux Complies
		if ($this->typeOffice() == 'Complies') {
			print "
					$('.latin .examen-conscience').show();
					$('<h2>').appendTo('.latin .examen-conscience').text('Conscientiæ discussio');
					$('<p>').appendTo('.latin .examen-conscience').text('Confíteor Deo omnipoténti et vobis, fratres, quia peccávi nimis cogitatióne, verbo, ópere et omissióne:');
					$('<h5>').appendTo('.latin .examen-conscience').text('et, percutientes sibi pectus, dicunt :');
					$('<p>').appendTo('.latin .examen-conscience').text('mea culpa, mea culpa, mea máxima culpa.');
					$('<h5>').appendTo('.latin .examen-conscience').text('Deinde prosequuntur:');
					$('<p>').appendTo('.latin .examen-conscience').text('Ideo precor beátam Maríam semper Vírginem, omnes Angelos et Sanctos, et vos, fratres, oráre pro me ad Dóminum Deum nostrum.');
					$('<p>').appendTo('.latin .examen-conscience').text('Misereátur nostri omnípotens Deus et, dimissís peccátis nostris, perdúcat nos ad vitam aetérnam.');
					var dernierP = $('.latin .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('V. ');
					$('<p>').appendTo('.latin .examen-conscience').text('Amen.');
					dernierP = $('.latin .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('R. ');
							
					$('.francais .examen-conscience').show();
					$('.francais .examen-conscience').show();
					$('<h2>').appendTo('.francais .examen-conscience').text('Examen de conscience');
					$('<p>').appendTo('.francais .examen-conscience').text(\"Je confesse à Dieu tout puissant et à vous, mes frères, car j'ai péché par la pensée, la parole, les actes et par omission :\");
					$('<h5>').appendTo('.francais .examen-conscience').text('et, en se frappant la poitrine, on dit :');
					$('<p>').appendTo('.francais .examen-conscience').text('je suis coupable, je suis coupable, je suis grandement coupable.');
					$('<h5>').appendTo('.francais .examen-conscience').text('ensuite, on continue :');
					$('<p>').appendTo('.francais .examen-conscience').text(\"C'est pourquoi je supplie la bienheureuse Marie toujours Vierge, tous les Anges et les Saints, et vous, frères, de prier pour moi le Seigneur notre Dieu.\");
					$('<p>').appendTo('.francais .examen-conscience').text('Aie pitié de nous Dieu tout puissant et, nos péchés ayant été renvoyés, conduis-nous à la vie éternelle.');
					var dernierP = $('.francais .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('V. ');
					$('<p>').appendTo('.francais .examen-conscience').text('Amen.');
					dernierP = $('.francais .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('R. ');
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
		switch ($this->typeOffice()) {
			case "laudes":
			case "vepres":
				//Antienne 1 avant le psaume position 11
				print "$('.ant11').show();";
				print "$('<p>').appendTo('.latin .ant11').text(\"$this->ant1('latin')\");";
				print "$('<p>').appendTo('.francais .ant11').text(\"$this->ant1('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. 1 : ');";
				//psaume 1
				print $this->affichePsaume($this->ps1(), ".psaume1");
				// gloria patri1
				print $this->gloriaPatri('.gloriapatri1');
				//Antienne 1 apres le psaume position 12
				print "$('.ant12').show();";
				print "$('<p>').appendTo('.latin .ant12').text(\"$this->ant1('latin')\");";
				print "$('<p>').appendTo('.francais .ant12').text(\"$this->ant1('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant12 p').text('Ant. : ');";
				//Antienne 2 avant le psaume position 21
				print "$('.ant21').show();";
				print "$('<p>').appendTo('.latin .ant21').text(\"$this->ant2('latin')\");";
				print "$('<p>').appendTo('.francais .ant21').text(\"$this->ant2('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant21 p').text('Ant. 2 : ');";
				//psaume 2
				print $this->affichePsaume($this->ps2(), ".psaume2");
				// gloria patri2
				print $this->gloriaPatri('.gloriapatri2');
				//Antienne 2 apres le psaume position 22
				print "$('.ant11').show();";
				print "$('<p>').appendTo('.latin .ant22').text(\"$this->ant2('latin')\");";
				print "$('<p>').appendTo('.francais .ant22').text(\"$this->ant2('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant22 p').text('Ant. : ');";
				//Antienne 3 avant le psaume position 31
				print "$('.ant11').show();";
				print "$('<p>').appendTo('.latin .ant31').text(\"$this->ant3('latin')\");";
				print "$('<p>').appendTo('.francais .ant31').text(\"$this->ant3('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant31 p').text('Ant. 3 : ');";
				//psaume 3
				print $this->affichePsaume($this->ps3(), ".psaume3");
				// gloria patri3
				print $this->gloriaPatri('.gloriapatri3');
				//Antienne 3 apres le psaume position 32
				print "$('.ant11').show();";
				print "$('<p>').appendTo('.latin .ant32').text(\"$this->ant3('latin'(\");";
				print "$('<p>').appendTo('.francais .ant32').text(\"$this->ant3('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant32 p').text('Ant. : ');";
				break;
			case "tierce":
			case "sexte":
			case "none":
				//Antienne avant le psaume position 11
				print "$('.ant11').show();";
				print "$('<p>').appendTo('.latin .ant11').text(\"$this->ant1('latin')\");";
				print "$('<p>').appendTo('.francais .ant11').text(\"$this->ant1('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. : ');";
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
				print "$('.ant32').show();";
				print "$('<p>').appendTo('.latin .ant32').text(\"$this->ant1('latin')\");";
				print "$('<p>').appendTo('.francais .ant32').text(\"$this->ant1('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant32 p').text('Ant. : ');";
				break;
			case "complies":
				//Antienne 1 avant le psaume position 11
				print "$('.ant11').show();";
				print "$('<p>').appendTo('.latin .ant11').text(\"$this->ant1('latin')\");";
				print "$('<p>').appendTo('.francais .ant11').text(\"$this->ant1('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. : ');";
				//psaume 1
				print $this->affichePsaume($this->ps1(), ".psaume1");
				// gloria patri1
				print $this->gloriaPatri('.gloriapatri1');
				//antienne 1 apres le psaume position 12
				print "$('.ant12').show();";
				print "$('<p>').appendTo('.latin .ant12').text(\"$this->ant1('latin')\");";
				print "$('<p>').appendTo('.francais .ant12').text(\"$this->ant1('francais')\");";
				print "$('<span>').addClass('red').prependTo('.ant12 p').text('Ant. : ');";
				if ($this->ps2()) {
					//Si psaume2 Antienne 2 avant le psaume position 21
					print "$('.ant21').show();";
					print "$('<p>').appendTo('.latin .ant21').text(\"$this->ant2('latin')\");";
					print "$('<p>').appendTo('.francais .ant21').text(\"$this->ant2('francais')\");";
					print "$('<span>').addClass('red').prependTo('.ant21 p').text('Ant. 2 : ');";
					//psaume 2
					print $this->affichePsaume($this->ps2(), ".psaume2");
					// gloria patri2
					print $this->gloriaPatri('.gloriapatri2');
					//Antienne 2 apres le psaume position 22
					print "$('.ant22').show();";
					print "$('<p>').appendTo('.latin .ant22').text(\"$this->ant2('latin')\");";
					print "$('<p>').appendTo('.francais .ant22').text(\"$this->ant2('francais')\");";
					print "$('<span>').addClass('red').prependTo('.ant22 p').text('Ant. : ');";
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
		print "$('.repons').show();";
		print "$('<p>').appendTo('.latin . repons').text(\"$this->repons('latin')\");";
		print "$('<p>').appendTo('.francais . repons').text(\"$this->repons('francais')\");";
		
		/*
		 * Cantique Evangélique aux grandes heures et complies
		 */
		switch ($this->typeOffice()) {
			case "laudes":
				// Antienne avant et apres cantique
				print "$('.antEv').show();";
				print "$('<p>').appendTo('.latin .antEv').text(\"$this->antEv('latin')\");";
				print "$('<p>').appendTo('.francais .antEv').text(\"$this->antEv('francais')\");";
				print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');";
				// Benedictus
				print $this->affichePsaume('benedictus', '.cantiqueEv');
				//Gloria Patri
				print $this->gloriaPatri('.cantiqueEv');
				break;
			case "vepres":
				// Antienne avant et apres cantique
				print "$('.antEv').show();";
				print "$('<p>').appendTo('.latin .antEv').text(\"$this->antEv('latin')\");";
				print "$('<p>').appendTo('.francais .antEv').text(\"$this->antEv('francais')\");";
				print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');";
				// Benedictus
				print $this->affichePsaume('magnificat', '.cantiqueEv');
				//Gloria Patri
				print $this->gloriaPatri('.cantiqueEv');
				break;
			case "complies":
				// Antienne avant et apres cantique
				print "$('.antEv').show();";
				print "$('<p>').appendTo('.latin .antEv').text(\"$this->antEv('latin')\");";
				print "$('<p>').appendTo('.francais .antEv').text(\"$this->antEv('francais')\");";
				print "$('<span>').addClass('red').prependTo('.antEv p').text('Ant. : ');";
				// Benedictus
				print $this->affichePsaume('nuncdimittis', '.cantiqueEv');
				//Gloria Patri
				print $this->gloriaPatri('.cantiqueEv');
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
			print "$('.pater').show()";
			print "$('<h2>').appendTo('.latin .pater').text('Pater Noster');";
			print "$('<h2>').appendTo('.francais . pater').text('Notre Père');";
			print "$('<p>').appendTo('.latin .pater').text('Pater noster, qui es in cælis:');";
			print "$('<p>').appendTo('.latin .pater').text('sanctificétur nomen tuum;');";
			print "$('<p>').appendTo('.latin .pater').text('advéniat regnum tuum;');";
			print "$('<p>').appendTo('.latin .pater').text('fiat volúntas tua, sicut in cælo et in terra.');";
			print "$('<p>').appendTo('.latin .pater').text('Panem nostrum cotidiánum da nobis hódie;');";
			print "$('<p>').appendTo('.latin .pater').text('et dimítte nobis débita nostra,');";
			print "$('<p>').appendTo('.latin .pater').text('sicut et nos dimíttimus debitóribus nostris;');";
			print "$('<p>').appendTo('.latin .pater').text('et ne nos indúcas in tentatiónem;');";
			print "$('<p>').appendTo('.latin .pater').text('sed líbera nos a malo.');";
			
			print "$('<p>').appendTo('.francais .pater').text('Notre Père, qui es aux Cieux,');";
			print "$('<p>').appendTo('.francais .pater').text('que ton nom soit sanctifié;');";
			print "$('<p>').appendTo('.francais .pater').text('que ton règne arrive;');";
			print "$('<p>').appendTo('.francais .pater').text('que ta volonté soit faite au Ciel comme sur la terre.');";
			print "$('<p>').appendTo('.francais .pater').text(\"Donne-nous aujourd'hui notre pain quotidien,\");";
			print "$('<p>').appendTo('.francais .pater').text('et remets-nous nos dettes,');";
			print "$('<p>').appendTo('.francais .pater').text('comme nous les remettons nous-mêmes à nos débiteurs ;');";
			print "$('<p>').appendTo('.francais .pater').text(\"et ne nous abandonne pas dans l'épreuve,\");";
			print "$('<p>').appendTo('.francais .pater').text('mais délivre-nous du malin.');";
		}
		
		/*
		 * Oratio
		 */
		print "$('.oratio').show();";
		print "$('<h2>').appendTo('.latin .oratio').text('Oratio');";
		print "$('<h2>').appendTo('.francais . oratio').text('Oraison');";
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
				print "$('<p>').appendTo('.latin .oratio').text('Orémus.');";
				print "$('<p>').appendTo('.francais . oratio').text('Prions.');";
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
		print "$('<p>').appendTo('.latin .oratio').text('$oratiolat');";
		print "$('<p>').appendTo('.francais . oratio').text('$oratiofr');";
		print "$('<p>').appendTo('.latin .oratio').text('Amen.');";
		print "$('<p>').appendTo('.francais . oratio').text('Amen.');";
		$dernierP = "$('.oratio p').last()";
		print "$('<span>').addClass('red').prependTo('$dernierP').text('R. ');";
		
		/*
		 * Benedictio aux grandes heures et complies
		 */
		
		/*
		 * Acclamatio aux petites heures
		 */
		
		/*
		 * Cantique mariale aux complies
		 */
		print $this->affichePsaume($this->cantiqueMarial(), 'antMariale');
		
		print "</script>";
	}
}

?>