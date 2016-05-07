<?php
/*
 * Classe GestionOffice pour remplir définir les valeurs des antiennes et autres variables à partir du calendrier liturgique
 */

class GestionOffice_r {
	/*
	 * variables locales
	 */
	var $sanctoral;
	var $temporal;
	var $ferial;
	var $calendarium;
	var $date_l;
	var $date_fr;
	var $lettre;
	
	/*
	 * getters
	 */
	function sanctoral() { return $this->sanctoral; }
	function temporal($id, $langue) { return $this->temporal[$id][$langue]; }
	function ferial() { return $this->ferial; }
	function date_l() { return $this->date_l; }
	function date_fr() { return $this->date_fr; }
	function lettre() { return $this->lettre; }

	/*
	 * setters
	 */
	function setSanctoral($id,$langue,$valeur) { $this->sanctoral[$id][$langue]=$valeur; }
	function setTemporal($id,$langue,$valeur) { $this->temporal[$id][$langue]=$valeur; }
	function setFerial($id,$langue,$valeur) { $this->ferial[$id][$langue]=$valeur; }
	function setLettre($valeur) { $this->lettre=$valeur; }
	
	/*
	 * méthodes
	 */

	/*
	 * date_latin($j) : renvoie la date en latin pour $j
	 * $j : date au format informatique
	 * 
	 */
	function date_latin($j)
	{
		if($j==null) $j=time();
		$mois= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
		$jours = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
		$date= $jours[@date("w",$j)]." ".@date("j",$j)." ".$mois[@date("n",$j)-1]." ".@date("Y",$j);
		return $date;
	}
	
	/*
	 * Calcul du calendrier liturgique pour l'année à partir d'une date $date donnée
	 * $date = aaaaammjj
	 */
	function setCalendarium($date) {
		
		$feriae=array("Dominica","Feria II","Feria III","Feria IV","Feria V","Feria VI","Sabbato");
		$romains=array("","I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII","XIII","XIV","XV","XVI","XVII","XVIII","XIX","XX","XXI","XXII","XXIII","XXIV","XXV","XXVI","XXVII","XXVIII","XXIX","XXX","XXXI","XXXII","XXXIII","XXXIV");
		$menses=array("","Ianuarii","Februarii","Martii","Aprilii","Maii","Iunii","Iulii","Augusti","Septembri","Octobri","Novembri","Decembri");
		$hexa['Violet']="6c075f";
		$hexa['Violet-avent']="#C800FE";
		$hexa['Violet-careme']="#9200AC";
		$hexa['Vert']="076c11";
		$hexa['Rose']="ef9de4";
		$hexa['Noir']="000000";
		$hexa['Blanc']="f3f1bc";
		$hexa['Rouge']="c50520";
	
		$anno=substr($date,0,4); // année de la date demandée
		$mense=substr($date,4,2); // mois de la date demandée
		$die=substr($date,6,2); // jour de la date demandée
		$day=mktime(12,0,0,$mense,$die,$anno); // date de mandée au format informatique
		
	
		//// Forme de la variable date : AAAAMMJJ
		/*
	
		Le mathématicien Gauss avait trouvé un algorithme (une formule) pour calculer
		cette date. Un autre mathématicien, T. H. OéBeirne, a trouvé deux erreurs dans
		la formule de Gauss. Il a alors formulé un autre algorithme :
	
		Soit m léannée, on fait les calculs suivants :
	
		1. On soustrait 1900 de m : céest la valeur de n.
		2. On divise n par 19 : le reste est la valeur de a.
		3. On divise (7a + 1) par 19 : la partie entiére du quotient est b.
		4. On divise (11a - b + 4) par 29 : le reste est c.
		5. On divise n par 4 : la partie entiére du quotient est d.
		6. On divise (n - c + d + 31) par 7 : le reste est e.
	
		La date de Péques est le (25 - c - e) avril si le résultat est positif.
		Séil est négatif, le mois est mars. Le quantiéme est la somme de 31 et
		du résultat.
		Par exemple, si le résultat est -7, le quantiéme est 31 + -7 = 24.
	
		*/
	
	
		$m=@date("Y",$day); // extraction de l'année demandée au format informatique
		$n=$m-1900; // opération 1
		$a=$n%19; // opération 2
		$b=intval((7*$a+1)/19); // opération 3
		$c=(11*$a-$b+4)%29; // opération 4
		$d=intval($n/4); // opération 5
		$e=($n-$c+$d+31)%7; // opération 6
	
		// Si e est positif, Péques est en avril
		if($e>=0) {
			$p=25-$c-$e;
			$paques=mktime(12, 0, 0, 4, $p, $m);
		}
		// Si e est négatif, Péques est en mars
		if($e<0) {
			$p=31+$e;
			$paques=mktime(12, 0, 0, 3, $p, $m);
		}
	
		setlocale (LC_ALL, 'FR');
		$res = date("Ymd", $paques);
	
		//print"<br>PAQUES $res : $paques";
		$jour=60*60*24;
		$semaine=60*60*24*7;
	
		/*
		 * Cycle de Noël
		 */
	
		// Date de noél au format informatique
		$noel=mktime(12,0,0,12,25,$m);
		$noe=date("d-M-Y", $noel);
		$no=date("Ymd", $noel);
		$jour_noel=date("w", $noel);
	
		// Noel
		$temporal['intitule'][$no]="IN NATIVITATE DOMINI";
		$temporal['couleur'][$no]="Blanc";
		$temporal['tempus'][$no]="Tempus Nativitatis";
		$temporal['hebdomada'][$no]="Infra octavam Nativitatis";
		$temporal['priorite'][$no]="2";
		$temporal['hp'][$no]=1;
		$temporal['1V'][$no]=1;
	
		// temsp de l'Avent
		$journoel=date("w",$noel);
		if ($journoel==0) $journoel=7;
	
		$quatre_dim_avent=$noel-$journoel*$jour; // 4e dim
		$dd=date("Ymd", $quatre_dim_avent);
		$temporal['intitule'][$dd]="Dominica IV Adventus";
		$temporal['temporal'][$dd]="Dominica IV Adventus";
		$temporal['hp'][$dd]=4;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada IV Adventus";
		$temporal['couleur'][$dd]="Violet-avent";
	
		$trois_dim_avent=$quatre_dim_avent-$semaine; // 3e dim
		$dd=date("Ymd", $trois_dim_avent);
		$temporal['intitule'][$dd]="Dominica III Adventus";
		$temporal['temporal'][$dd]="Dominica III Adventus";
		$temporal['hp'][$dd]=3;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['couleur'][$dd]="Rose";
		$temporal['hebdomada'][$dd]="Hebdomada III Adventus";
		$coul_adventus=$trois_dim_avent+$jour;
		$dd=date("Ymd", $coul_adventus);
		$temporal['couleur'][$dd]="Violet-avent";
	
	
		$deux_dim_avent=$trois_dim_avent-$semaine; // 2e dim
		$dd=date("Ymd", $deux_dim_avent);
		$temporal['intitule'][$dd]="Dominica II Adventus";
		$temporal['temporal'][$dd]="Dominica II Adventus";
		$temporal['hp'][$dd]=2;
		$temporal['1V'][$dd]=1;
		$temporal['priorite'][$dd]="2";
		$temporal['hebdomada'][$dd]="Hebdomada II Adventus";
	
		$un_dim_avent=$deux_dim_avent-$semaine; // 1er dim
		$dd=date("Ymd", $un_dim_avent);
		$temporal['intitule'][$dd]="Dominica I Adventus";
		$temporal['temporal'][$dd]="Dominica I Adventus";
		$temporal['hp'][$dd]=1;
		$temporal['1V'][$dd]=1;
		$temporal['priorite'][$dd]="2";
		$temporal['hebdomada'][$dd]="Hebdomada I Adventus";
		$temporal['tempus'][$dd]="Tempus Adventus";
		$temporal['couleur'][$dd]="Violet-avent";
		$dnisuchrisitiunivregis=$un_dim_avent-$semaine; // Christ-Roi
	
		// Temsp de Noel
		/*
		 *  Ste Famille
		 *  Celebrer comme un dimanche du temps de noel, priorite 6 et 1V, si noel ne tombe pas dimanche
		 *  Celebrer comme une fete du calendrier general si noel est un dimanche
		 */
		if ($jour_noel!=0) {
			$sanctae_familiae2=$noel+(7-$jour_noel)*$jour; //Si Noel n'est pas un dimanche, la Ste Famille est le dimanche suivant noel
			$jj=date("w", $sanctae_familiae2);
			$dd=date("Ymd", $sanctae_familiae2);
		}
		else {
			$sanctae_familiae2=mktime(12,0,0,12,30,$m); // Sinon, c'est le 30 decembre
			$jj=date("w", $sanctae_familiae2);
			$dd=date("Ymd", $sanctae_familiae2);
		}
		$temporal['intitule'][$dd]="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
		$temporal['temporal'][$dd]="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
		$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['couleur'][$dd]="Blanc";
		if ($jj==0) {
			$temporal['1V'][$dd]=1;
			$temporal['priorite'][$dd]="6";
		}
		else $temporal['priorite'][$dd]="6";
	
	
		// Noel de l'année précédente
		$noel_annee_precedente=mktime(12,0,0,12,25,$m-1);
		$dd=date("Ymd", $noel_annee_precedente);
		$temporal['intitule'][$dd]="IN NATIVITATE DOMINI";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['priorite'][$dd]="2";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		$temporal['1V'][$dd]=1;
		$temporal['hp'][$dd]=1;
		$jour_noel_precedent=date("w", $noel_annee_precedente);
	
		// Ste famille de l'année précédente
		if ($jour_noel_precedent!=0)$sanctae_familiae=$noel_annee_precedente+(7-$jour_noel_precedent)*$jour; //Noel n'etait pas un dimanche
		else  $sanctae_familiae=mktime(12,0,0,12,30,$m-1); // Noel etait un dimanche et la Ste Famille le 30 decembre
		$jj=date("w", $sanctae_familiae);
		$dd=date("Ymd", $sanctae_familiae);
		$temporal['intitule'][$dd]="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
		$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['couleur'][$dd]="Blanc";
		if ($jj==0) {
			$temporal['1V'][$dd]=1;
			$temporal['priorite'][$dd]="6";
		}
		else $temporal['priorite'][$dd]="7";
	
		// 5e jour dans l'octave - 29 Decembre
		$jour5=mktime(12,0,0,12,29,$m);
		$jj=date("w", $jour5);
		if ($jj!=0) {
			$dd=date("Ymd", $jour5);
			$temporal['temporal'][$dd]="DE DIE V INFRA OCTAVAM NATIVITATIS";
			$temporal['intitule'][$dd]="DE DIE V INFRA OCTAVAM NATIVITATIS";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="9";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		}
	
		// 6e jour dans l'octave - 30 Decembre
		$jour6=mktime(12,0,0,12,30,$m);
		$jj=date("w", $jour6);
		$dd=date("Ymd", $jour6);
		if (($jj!=0)and(!$temporal['intitule'][$dd])) {
			$temporal['temporal'][$dd]="DE DIE VI INFRA OCTAVAM NATIVITATIS";
			$temporal['intitule'][$dd]="DE DIE VI INFRA OCTAVAM NATIVITATIS";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="9";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		}
	
		// 7e jour dans l'octave - 31 Decembre
		$jour7=mktime(12,0,0,12,31,$m);
		$jj=date("w", $jour7);
		$dd=date("Ymd", $jour7);
		if ($jj!=0) {
			$temporal['temporal'][$dd]="DE DIE VII INFRA OCTAVAM NATIVITATIS";
			$temporal['intitule'][$dd]="DE DIE VII INFRA OCTAVAM NATIVITATIS";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="9";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		}
	
		// 1er Janvier
		$stemarie=mktime(12,0,0,1,1,$m);
		$jj=date("w", $stemarie);
		$dd=date("Ymd", $stemarie);
		$temporal['temporal'][$dd]="IN OCTAVA NATIVITATIS DOMINI";
		$temporal['intitule'][$dd]="IN OCTAVA NATIVITATIS DOMINI";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['priorite'][$dd]="3";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		$temporal['1V'][$dd]=1;
	
		// 1er Janvier de l'année suivante
		$stemariesuivant=mktime(12,0,0,1,1,$m+1);
		$jj=date("w", $stemariesuivant);
		$dd=date("Ymd", $stemariesuivant);
		$temporal['temporal'][$dd]="IN OCTAVA NATIVITATIS DOMINI";
		$temporal['intitule'][$dd]="IN OCTAVA NATIVITATIS DOMINI";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['priorite'][$dd]="3";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
		$temporal['1V'][$dd]=1;
	
	
		$infra_oct_nativ=$noel_annee_precedente+7*$jour; // Octave de noel de l'année précédente
		$dd=date("Ymd", $infra_oct_nativ);
		$temporal['hebdomada'][$dd]="";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['hp'][$dd]=1;
	
		$fin_oct_nativitatis=$noel_annee_precedente+8*$jour;
		$dd=date("Ymd", $fin_oct_nativitatis);
		$temporal['hebdomada'][$dd]=" ";
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['hp'][$dd]=1;
	
	
		/*
		 * Epiphanie
		 * Le 2nd dimanche après noel en France
		 */
		$epiphania=$noel_annee_precedente+(14-$jour_noel_precedent)*$jour;
		//$epiphania=mktime(12,0,0,1,6,$m);
		$dd=date("Ymd", $epiphania);
		$temporal['jour'][$dd]="IN EPIPHANIA DOMINI";
		$temporal['intitule'][$dd]="IN EPIPHANIA DOMINI";
		//$temporal['rang'][$dd]="Sollemnitas";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['hebdomada'][$dd]="";
	
	
		/*
		 * Temps de la nativite entre l'octave de Noel et l'Epiphanie
		 *
		 */
	
		// 2 Janvier
		$jour0102=mktime(12,0,0,1,2,$m);
		$jj=date("w", $jour0102);
		$dd=date("Ymd", $jour0102);
		if (($jj!=0)and($jour0102<$epiphania)) {
			$temporal['temporal'][$dd]="DE DIE 2 IANUARII";
			$temporal['intitule'][$dd]="DE DIE 2 IANUARII";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="13";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="";
		}
	
		// 3 Janvier
		$jour0103=mktime(12,0,0,1,3,$m);
		$jj=date("w", $jour0103);
		$dd=date("Ymd", $jour0103);
		if (($jj!=0)and($jour0103<$epiphania)) {
			$temporal['temporal'][$dd]="DE DIE 3 IANUARII";
			$temporal['intitule'][$dd]="DE DIE 3 IANUARII";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="13";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="";
		}
	
		// 4 Janvier
		$jour0104=mktime(12,0,0,1,4,$m);
		$jj=date("w", $jour0104);
		$dd=date("Ymd", $jour0104);
		if (($jj!=0)and($jour0104<$epiphania)) {
			$temporal['temporal'][$dd]="DE DIE 4 IANUARII";
			$temporal['intitule'][$dd]="DE DIE 4 IANUARII";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="13";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="";
		}
	
		// 5 Janvier
		$jour0105=mktime(12,0,0,1,5,$m);
		$jj=date("w", $jour0105);
		$dd=date("Ymd", $jour0105);
		if (($jj!=0)and($jour0105<$epiphania)) {
			$temporal['temporal'][$dd]="DE DIE 5 IANUARII";
			$temporal['intitule'][$dd]="DE DIE 5 IANUARII";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="13";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="";
		}
	
		// 6 Janvier
		$jour0106=mktime(12,0,0,1,6,$m);
		$jj=date("w", $jour0106);
		$dd=date("Ymd", $jour0106);
		if (($jj!=0)and($jour0106<$epiphania)) {
			$temporal['temporal'][$dd]="DE DIE 6 IANUARII";
			$temporal['intitule'][$dd]="DE DIE 6 IANUARII";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="13";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="";
		}
	
		// 7 Janvier
		$jour0107=mktime(12,0,0,1,7,$m);
		$jj=date("w", $jour0107);
		$dd=date("Ymd", $jour0107);
		if (($jj!=0)and($jour0107<$epiphania)) {
			$temporal['temporal'][$dd]="DE DIE 7 IANUARII";
			$temporal['intitule'][$dd]="DE DIE 7 IANUARII";
			$temporal['couleur'][$dd]="Blanc";
			$temporal['priorite'][$dd]="13";
			$temporal['tempus'][$dd]="Tempus Nativitatis";
			$temporal['hebdomada'][$dd]="";
		}
	
		/*
		 * Bapteme du Seigneur
		 * Le dimanche qui suit l'Epiphanie
		 * sauf si l'Epiphanie est le 7 ou 8 janvier, alors c'est le lendemain
		 */
		$jour_epiphanie=date("w", $epiphania);
		$epipha=date("d", $epiphania);
		if ($epipha<7) {
			$infra_oct_epiphanie=$epiphania+$jour;
			$dd=date("Ymd",$infra_oct_epiphanie);
			$temporal['hebdomada'][$dd]="Post Dominicam Epiphani&aelig;";
			$temporal['hp'][$dd]=2;
			$baptisma=$epiphania+(7-$jour_epiphanie)*$jour;
		}
		else $baptisma=$epiphania+$jour;
	
		$dd=date("Ymd", $baptisma);
		$temporal['hebdomada'][$dd]="";
		$temporal['intitule'][$dd]="IN BAPTISMATE DOMINI";
		//$temporal['rang'][$dd]="Festum";
		$temporal['priorite'][$dd]="5";
		$temporal['1V'][$dd]=1;
		$temporal['tempus'][$dd]="Tempus Nativitatis";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['hp'][$dd]=1;
	
		$perannum=$baptisma+$jour; // début de temps ordinaire
		$dd=date("Ymd", $perannum);
		$temporal['tempus'][$dd]="Tempus per annum";
		$temporal['hebdomada'][$dd]="Hebdomada I per annum";
		$temporal['couleur'][$dd]="Vert";
		$temporal['hp'][$dd]=1;
		$temporal['psautier'][$dd]="perannum";
	
	
		/*
		 * cycle de Péques
		 */
	
		// temps de la Passion
		$palmis=$paques-$semaine; // Dim de la Passion
		$dd=date("Ymd", $palmis);
		$temporal['intitule'][$dd]="DOMINICA IN PALMIS DE PASSIONE DOMINI";
		$temporal['temporal'][$dd]="DOMINICA IN PALMIS DE PASSIONE DOMINI";
		$temporal['hp'][$dd]=2;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada Sancta";
		$temporal['tempus'][$dd]="Tempus passionis";
		$temporal['couleur'][$dd]="Rouge";
		$hebviol=$palmis+$jour;
		$dd=date("Ymd", $hebviol);
		$temporal['couleur'][$dd]="Violet-careme";
	
		$in_cena=$palmis+4*$jour; // Jeudi Saint
		$dd=date("Ymd", $in_cena);
		$temporal['intitule'][$dd]="IN CENA DOMINI";
		$temporal['temporal'][$dd]="IN CENA DOMINI";
		$temporal['priorite'][$dd]="1";
		$temporal['hebdomada'][$dd]="Sacrum Triduum Paschale";
		$temporal['tempus'][$dd]="Tempus passionis";
		$temporal['couleur'][$dd]="Blanc";
	
		$in_passione=$in_cena+$jour; // Vendredi Saint
		$dd=date("Ymd", $in_passione);
		$temporal['intitule'][$dd]="IN PASSIONE DOMINI";
		$temporal['temporal'][$dd]="IN PASSIONE DOMINI";
		$temporal['priorite'][$dd]="1";
		$temporal['couleur'][$dd]="Rouge";
	
		$sabbato_sancto=$in_passione+$jour; // Samedi Saint
		$dd=date("Ymd", $sabbato_sancto);
		$temporal['intitule'][$dd]="Sabbato Sancto";
		$temporal['priorite'][$dd]="1";
		$temporal['couleur'][$dd]="Violet-careme";
	
	
		// Temps du caréme
	
		$cinq_quadragesima=$palmis-$semaine; // 5e Dim de Careme
		$dd=date("Ymd", $cinq_quadragesima);
		$temporal['intitule'][$dd]="Dominica V Quadragesimae";
		$temporal['temporal'][$dd]="Dominica V Quadragesimae";
		$temporal['hp'][$dd]=1;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada V Quadragesimae";
		$temporal['tempus'][$dd]="Tempus Quadragesimae";
	
		$quatre_quadragesima=$cinq_quadragesima-$semaine; // 4e Dim de Careme
		$dd=date("Ymd", $quatre_quadragesima);
		$temporal['intitule'][$dd]="Dominica IV Quadragesimae";
		$temporal['temporal'][$dd]="Dominica IV Quadragesimae";
		$temporal['hp'][$dd]=4;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada IV Quadragesimae";
		$temporal['couleur'][$dd]="Rose";
	
		$coul_quadragesima=$quatre_quadragesima+$jour;
		$dd=date("Ymd", $coul_quadragesima);
		$temporal['couleur'][$dd]="Violet-careme";
	
		$trois_quadragesima=$quatre_quadragesima-$semaine; // 3e Dim de Careme
		$dd=date("Ymd", $trois_quadragesima);
		$temporal['intitule'][$dd]="Dominica III Quadragesimae";
		$temporal['temporal'][$dd]="Dominica III Quadragesimae";
		$temporal['hp'][$dd]=3;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada III Quadragesimae";
		$temporal['couleur'][$dd]="Violet-careme";
	
		$deux_quadragesima=$trois_quadragesima-$semaine; // 2e Dim de Careme
		$dd=date("Ymd", $deux_quadragesima);
		$temporal['intitule'][$dd]="Dominica II Quadragesimae";
		$temporal['temporal'][$dd]="Dominica II Quadragesimae";
		//Dominica I Quadragesimae
		$temporal['hp'][$dd]=2;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada II Quadragesimae";
		$temporal['couleur'][$dd]="Violet-careme";
	
		$un_quadragesima=$deux_quadragesima-$semaine; // 1er Dim de Careme
		$dd=date("Ymd", $un_quadragesima);
		$temporal['intitule'][$dd]="Dominica I Quadragesimae";
		$temporal['temporal'][$dd]="Dominica I Quadragesimae";
		$temporal['hp'][$dd]=1;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada I Quadragesimae";
		$temporal['couleur'][$dd]="Violet-careme";
	
		$cinerum=$un_quadragesima-4*$jour; // Mercredi des cendres
		$dd=date("Ymd", $cinerum);
		$temporal['intitule'][$dd]="Feria IV Cinerum";
		$temporal['temporal'][$dd]="Feria IV Cinerum";
		$temporal['priorite'][$dd]="2";
		$temporal['hebdomada'][$dd]="";
		$temporal['tempus'][$dd]="Tempus Quadragesimae";
		$temporal['couleur'][$dd]="Violet-careme";
		$temporal['hp'][$dd]=4;
		$post_cineres=$cinerum+$jour;
		$dd=date("Ymd", $post_cineres);
		$temporal['hebdomada'][$dd]="Dies post Cineres";
		$temporal['couleur'][$dd]="Violet-careme";
	
		// Temps Pascal
		$pa=date("Ymd", $paques); // Jour de Péques
		$dd=$pa;
		$temporal['intitule'][$dd]="DOMINICA RESURRECTIONIS";
		$temporal['temporal'][$dd]="DOMINICA RESURRECTIONIS";
		$temporal['priorite'][$dd]="1";
		$temporal['1V'][$dd]=0;
		$temporal['hebdomada'][$dd]="Infra octavam paschae";
		$temporal['tempus'][$dd]="Tempus Paschale";
		$temporal['couleur'][$dd]="Blanc";
		$temporal['hp'][$dd]=1;
	
		$deux_paques=$paques+$semaine;
		$dd=date("Ymd", $deux_paques);
		$temporal['intitule'][$dd]="Dominica II Paschae";
		$temporal['temporal'][$dd]="Dominica II Paschae";
		$temporal['hp'][$dd]=2;
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
	
		$l_deuxpaques=$deux_paques+60*60*24;
		$dd=date("Ymd", $l_deuxpaques);
		$temporal['hebdomada'][$dd]="Hebdomada II Paschae";
	
		$trois_paques=$paques+2*$semaine;
		$dd=date("Ymd", $trois_paques);
		$temporal['intitule'][$dd]="Dominica III Paschae";
		$temporal['temporal'][$dd]="Dominica III Paschae";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada III Paschae";
		$temporal['hp'][$dd]=3;
	
		$quatre_paques=$paques+3*$semaine;
		$dd=date("Ymd", $quatre_paques);
		$temporal['intitule'][$dd]="Dominica IV Paschae";
		$temporal['temporal'][$dd]="Dominica IV Paschae";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada IV Paschae";
		$temporal['hp'][$dd]=4;
	
		$cinq_paques=$paques+4*$semaine;
		$dd=date("Ymd", $cinq_paques);
		$temporal['intitule'][$dd]="Dominica V Paschae";
		$temporal['temporal'][$dd]="Dominica V Paschae";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada V Paschae";
		$temporal['hp'][$dd]=1;
	
		$six_paques=$paques+5*$semaine;
		$dd=date("Ymd", $six_paques);
		$temporal['intitule'][$dd]="Dominica VI Paschae";
		$temporal['temporal'][$dd]="Dominica VI Paschae";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada VI Paschae";
		$temporal['hp'][$dd]=2;
	
		$ascensione=$six_paques+4*$jour;
		$dd=date("Ymd",$ascensione);
		$temporal['intitule'][$dd]="IN ASCENSIONE DOMINI";
		$temporal['temporal'][$dd]="IN ASCENSIONE DOMINI";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
	
		$sept_paques=$paques+6*$semaine;
		$dd=date("Ymd", $sept_paques);
		$temporal['intitule'][$dd]="Dominica VII Paschae";
		$temporal['temporal'][$dd]="Dominica VII Paschae";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada VII Paschae";
		$temporal['hp'][$dd]=3;
	
		$pentecostes=$paques+7*$semaine; // Pentecostes
		$dd=date("Ymd", $pentecostes);
		$temporal['intitule'][$dd]="Dominica Pentecostes";
		$temporal['temporal'][$dd]="Dominica Pentecostes";
		$temporal['priorite'][$dd]="2";
		$temporal['1V'][$dd]=1;
		$temporal['hp'][$dd]=$hp;
		$temporal['tempus'][$dd]="Tempus Paschale";
		$temporal['hebdomada'][$dd]="";
		$temporal['couleur'][$dd]="Rouge";
	
		$trinitatis=$pentecostes+$semaine; // Ste Trinité
		$trini=date("Ymd", $trinitatis);
		$temporal['couleur'][$trini]="Blanc";
		$temporal['intitule'][$trini]="SANCTISSIMAE TRINITATIS";
		$temporal['temporal'][$trini]="SANCTISSIMAE TRINITATIS";
		$temporal['priorite'][$trini]="3";
		$temporal['1V'][$trini]=1;
		$temporal['rang'][$trini]="Sollemnitas";
		$perannum=$trinitatis+$jour;
		$perann=date("Ymd", $perannum);
		$temporal['couleur'][$perann]="Vert";
	
		$corporis=$trinitatis+4*$jour; // Fete Dieu
		$corpo=date("Ymd", $corporis);
		$temporal['couleur'][$corpo]="Blanc";
		$temporal['intitule'][$corpo]="SS.MI CORPORIS ET SANGUINIS CHRISTI";
		$temporal['temporal'][$corpo]="SS.MI CORPORIS ET SANGUINIS CHRISTI";
		$temporal['rang'][$corpo]="Sollemnitas";
		$temporal['priorite'][$corpo]="3";
		$temporal['1V'][$corpo]=1;
		$perannum=$trinitatis+$jour;
		$perannum=$corporis+$jour;
		$perann=date("Ymd", $perannum);
		$temporal['couleur'][$perann]="Vert";
	
		$sacritissimicordis=$pentecostes+2*$semaine+5*$jour; // Coeur sacré de Jésus
		$sacri=date("Ymd", $sacritissimicordis);
		$temporal['couleur'][$sacri]="Rouge";
		$temporal['intitule'][$sacri]="SACRATISSIMI CORDIS IESU";
		$temporal['temporal'][$sacri]="SACRATISSIMI CORDIS IESU";
		$temporal['priorite'][$sacri]="5";
		$temporal['1V'][$sacri]=1;
		$temporal['rang'][$sacri]="Sollemnitas";
	
		$cordismaria=$sacritissimicordis+$jour; // Coeur immaculé de Marie
		$cordi=date("Ymd", $cordismaria);
		$temporal['intitule'][$cordi]="Immaculati Cordis B. Mariae Virginis";
		$temporal['temporal'][$cordi]="Immaculati Cordis B. Mariae Virginis";
		$temporal['priorite'][$cordi]="10";
		$temporal['rang'][$cordi]="Memoria";
		$temporal['couleur'][$cordi]="Rouge";
	
		$perannum=$cordismaria+$jour;
		$perann=date("Ymd", $perannum);
		$temporal['couleur'][$perann]="Vert";
	
		// Calcul du dimanche de reprise du temps ordinaire aprés le cyle de Péques
		$entre_tempspascal_et_avent=$dnisuchrisitiunivregis-$sept_paques;
		$nbsemaines_perannum=intval($entre_tempspascal_et_avent/$semaine);
		$reprise_perannum=34-$nbsemaines_perannum+1;
		$dim_courant=$reprise_perannum;
	
		// Calcul de la semaine du temps ordinaire de reprise aprés la penteceote
		$entre_tempsnoel_et_careme=$un_quadragesima-$baptisma;
		$nbsemaines_perannum=intval($entre_tempsnoel_et_careme/$semaine)+1;
		$date=$pentecostes;
		$hebdomada_reprise=$pentecostes+$jour;
		$numero = $romains[$dim_courant];
		$hp=(($dim_courant/4)-intval($dim_courant/4))*4;
		if($hp==0) $hp=4;
	
		//Semaine aprés a Pentecéte
		$dd=date("Ymd", $hebdomada_reprise);
		$temporal['hebdomada'][$dd]="Hebdomada $numero per annum";
		$temporal['hp'][$dd]=$hp;
		$perannum=$pentecostes+$jour;
		$perann=date("Ymd", $perannum);
		$temporal['couleur'][$perann]="Vert";
		$temporal['tempus'][$perann]="Tempus per annum";
	
	
		// Temps Ordinaire aprés la pentecote
		while($dim_courant<34) {
			$date=$date+$semaine;
			$dim_courant++;
			$dd=date("Ymd", $date);
			$numero = $romains[$dim_courant];
			$temporal['intitule'][$dd]="Dominica $numero per annum";
			$temporal['priorite'][$dd]="6";
			$temporal['1V'][$dd]=1;
			$temporal['temporal'][$dd]="Dominica $numero per annum";
			$temporal['hebdomada'][$dd]="Hebdomada $numero per annum";
			$hp=(($dim_courant/4)-intval($dim_courant/4))*4;
			if($hp==0) $hp=4;
			$temporal['hp'][$dd]=$hp;
		}
	
		$dnisuchrisitiunivregis=$un_dim_avent-$semaine;
		$dd=date("Ymd", $dnisuchrisitiunivregis);
		$temporal['intitule'][$dd]="D.N. IESU CHRISTI UNIVERSORUM REGIS";
		$temporal['temporal'][$dd]="D.N. IESU CHRISTI UNIVERSORUM REGIS";
		$temporal['priorite'][$dd]="3";
		$temporal['1V'][$dd]=1;
		$temporal['hebdomada'][$dd]="Hebdomada XXXIV per annum";
		$temporal['tempus'][$dd]="Tempus per annum";
		$temporal['couleur'][$dd]="Blanc";
		$perannum=$dnisuchrisitiunivregis+$jour;
		$perann=date("Ymd", $perannum);
		$temporal['couleur'][$perann]="Vert";
	
	
		// Temps Ordinaire aprés l'épiphanie
		$date=$baptisma;
		$heb_courante=1;
		while($heb_courante<$nbsemaines_perannum) {
			$date=$date+$semaine;
			$heb_courante++;
			$dd=date("Ymd", $date);
			$numero = $romains[$heb_courante];
			$temporal['intitule'][$dd]="Dominica $numero per annum";
			$temporal['temporal'][$dd]="Dominica $numero per annum";
			$temporal['priorite'][$dd]="6";
			$temporal['1V'][$dd]=1;
			$temporal['hebdomada'][$dd]="Hebdomada $numero per annum";
			$hp=(($heb_courante/4)-intval($heb_courante/4))*4;
			if($hp==0) $hp=4;
			$temporal['hp'][$dd]=$hp;
		}
	
		/*
		 * Chargement du sanctoral
		 */
		$row = 1;
		$handle = fopen("romain/sanctoral/sanctoral.csv", "r");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$num = count($data);
			$row++;
			if($data[4]!="") { // si l'intitulé n'est pas vide
				$date_sanctoral=@mktime(12,0,0,$data[0],$data[3],$m);
				$dds=date("Ymd", $date_sanctoral);
				$sanctoral['vita'][$dds]=$data[8];
				$sanctoral['intitule'][$dds]=$data[4];
				$sanctoral['rang'][$dds]=$data[5];
				$sanctoral['couleur'][$dds]=$data[6];
				$sanctoral['priorite'][$dds]=$data[7];
	
				if ($data[4]=="S. IOSEPH, SPONSI B. M. V.") {
					if ($m=="2006") {
						$sanctoral['intitule']['20060320']=$data[4];
						$sanctoral['rang']['20060320']=$data[5];
						$sanctoral['couleur']['20060320']=$data[6];
						$sanctoral['priorite']['20060320']=$data[7];
						$sanctoral['vita']['20060320']=$data[8];;
					}
					if ($m=="2008") {
						$sanctoral['intitule']['20080315']=$data[4];
						$sanctoral['rang']['20080315']=$data[5];
						$sanctoral['couleur']['20080315']=$data[6];
						$sanctoral['priorite']['20080315']=$data[7];
						$sanctoral['vita']['20080315']=$data[8];
					}
				}
	
				if (($data[4]=="IN ANNUNTIATIONE DOMINI")) {
					if ($m=="2005") {
						$sanctoral['intitule']['20050404']=$data[4];
						$sanctoral['rang']['20050404']=$data[5];
						$sanctoral['couleur']['20050404']=$data[6];
						$sanctoral['priorite']['20050404']=$data[7];
					}
					if ($m=="2007") {
						$sanctoral['intitule']['20070326']=$data[4];
						$sanctoral['rang']['20070326']=$data[5];
						$sanctoral['couleur']['20070326']=$data[6];
						$sanctoral['priorite']['20070326']=$data[7];
					}
					if ($m=="2008") {
						$sanctoral['intitule']['20080331']=$data[4];
						$sanctoral['rang']['20080331']=$data[5];
						$sanctoral['couleur']['20080331']=$data[6];
						$sanctoral['priorite']['20080331']=$data[7];
					}
					if ($m=="2012") {
						$sanctoral['intitule']['20120326']=$data[4];
						$sanctoral['rang']['20120326']=$data[5];
						$sanctoral['couleur']['20120326']=$data[6];
						$sanctoral['priorite']['20120326']=$data[7];
					}
					if ($m=="2013") {
						$sanctoral['intitule']['20130408']=$data[4];
						$sanctoral['rang']['20130408']=$data[5];
						$sanctoral['couleur']['20130408']=$data[6];
						$sanctoral['priorite']['20130408']=$data[7];
					}
				}
			} // fin du si l'intitulé n'est pas vide
		}// fin du while lisant le fichier sanctoral
	
	
		$m=@date("Y",$day);
		$date_courante=mktime(12,0,0,1,1,$m); // 1er janvier de l'annee $m
		$dernier_jour=mktime(12,0,0,1,1,$m+1); // 1er janvier de l'annee *m+1
		$lit=array("A","b","c","d","e","f","g");
		$i=0;
		//$date_courante=mktime(12,0,0,1,1,$m); // 1er janvier de l'année $m
		//$dernier_jour=mktime(12,0,0,12,31,$m); // 31 décembre de l'année $m
	
		while($date_courante <= $dernier_jour) {
			// Initialisation des propiétés du calendrier
			$vita="";
			$tempo="";
			$pV="";
			$priorite="";
			$couleurs="";
	
			// Manipulation sur la date du jour é mettre dans le calendrier
			$d=date("Ymd", $date_courante);
			$f=date("w", $date_courante);
			$date=date("Ymd", $date_courante);
	
			// initialisation des variables à partir du temporal
			$intitule = $temporal['intitule'][$date];
			if ($temporal['tempus'][$date]!="") $tempus=$temporal['tempus'][$date];
			if ($temporal['hebdomada'][$date]!="") $hebdomada=$temporal['hebdomada'][$date];
			if ($temporal['couleur'][$date]!="") $couleur=$temporal['couleur'][$date];
			if ($temporal['hp'][$date]!="") $hp=$temporal['hp'][$date];
			$rang=$temporal['rang'][$date];
			$priorite=$temporal['priorite'][$date];
			$tempo=$temporal['temporal'][$date];
			$pV=$temporal['1V'][$date];
	
			// s'il y a conflit temporal / sanctoral
			if(($sanctoral['priorite'][$date]!="")&&($temporal['priorite'][$date]!="")) {
				// sanctoral prioritaire sur le temporal
				if ($sanctoral['priorite'][$date]<$temporal['priorite'][$date]) {
					$intitule =$sanctoral['intitule'][$date];
					if($sanctoral['couleur'][$date]!="") $couleurs=$sanctoral['couleur'][$date];
					$rang=$sanctoral['rang'][$date];
					$vita=$sanctoral['vita'][$date];
					$priorite=$sanctoral['priorite'][$date];
					if($priorite<=5) $pV=1;
				}
				// temporal prioritaire sur le sanctoral
				else {
					$intitule =$temporal['intitule'][$date];
					$tempo=$temporal['temporal'][$date];
					$pV=$temporal['1V'][$date];
				}
			}
	
			// S'il y un sanctoral mais pas de temporal
			if(($sanctoral['intitule'][$date]!="")&&($temporal['intitule'][$date]=="")) {
				$intitule = $sanctoral['intitule'][$date];
				if($sanctoral['couleur'][$date]!="") $couleurs=$sanctoral['couleur'][$date];
				$rang=$sanctoral['rang'][$date];
				$vita=$sanctoral['vita'][$date];
				$priorite=$sanctoral['priorite'][$date];
				$propre=date("m",$date_courante).date("d",$date_courante);
			}
	
			if($couleurs) {
				$coul=$hexa[$couleurs];
				$couleur_template[$d]=$couleurs;
			}
			else {
				$coul=$hexa[$couleur];
				$couleur_template[$d]=$couleur;
			}
	
			//////   Ici confection du tableau
			$calendrier['couleur_template'][$d]=$couleur_template[$d];
			$calendrier['littera'][$d]=$lit[$i];
			$calendrier['tempus'][$d]=$tempus;
			$calendrier['hebdomada'][$d]=$hebdomada;
			$calendrier['intitule'][$d]=$intitule;
			$calendrier['rang'][$d]=$rang;
			$calendrier['hebdomada_psalterium'][$d]=$hp;
			$calendrier['vita'][$d]=$vita;
			$calendrier['temporal'][$d]=$tempo;
	
			// priorité, si non défini alors priorité la plus basse = 13
			if(!$priorite) $priorite=13;
			$calendrier['priorite'][$d]=$priorite;
	
			// 1ères Vêpres si la priorité est plus haute que 4 ou si déjà validé
			if(($pV) or ($calendrier['priorite'][$d]<=4)) $pV="1";
			else $pV="";
			$calendrier['1V'][$d]=$pV;
	
			// S'il y a des premières vêpres, donc solennité, et que le temporal n'est pas défini, alors il prends la valeur de l'intitulé
			if (($calendrier['1V'][$d]=="1")&&($calendrier['temporal'][$d]=="")) $calendrier['temporal'][$d]=$calendrier['intitule'][$d];
	
			//Passage au jour suivant, remise à zéro(dimanche) du compteur i après 7(samedi)
			$date_courante=$date_courante+$jour;
			$i++; if ($i==7) $i=0;
		}
	
	
		$day=time();
		$aujourdhui=@date("Ymd",$day);
	
		$datelatin=date_latin($day);
		$reponse="$datelatin, ".$calendrier['tempus'][$aujourdhui].", <a href=\"http://www.scholasaintmaur.net/index.php?date=$aujourdhui\">".$calendrier['hebdomada'][$aujourdhui];
		if($calendrier['intitule'][$aujourdhui]) $reponse.= ", ".$calendrier['intitule'][$aujourdhui];
		if($calendrier['rang'][$aujourdhui]) $reponse.=", ".$calendrier['rang'][$aujourdhui];
		$reponse.=".</a>";
	
		$calendrier['datedaujourdhui']=$reponse;
	
		//return $calendrier;
		$this->calendarium = $calendrier;
	}
	
	/*
	 * méthode d'initialisation des tableaux $sanctoral, $temporal, $ferial en fonction du calendrier liturgique
	 * Cette méthode n'est appelé que par les méthodes internes de la classe
	 * Entrées : $jour = date du jour, au format aaaammjj
	 * Sortie : $sanctoral, $temporal et $ferial sont remplis, $date_l et $date_fr
	 */
	function initialisationSources($jour) {
		
		if (!$jour) {$jour = $_GET['date']; }
		if (!$this->calendarium) { $this->setCalendarium($jour); }
		
		if($this->calendarium['hebdomada'][$jour]=="Infra octavam paschae") {
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
			$jour_l = array("Dominica, ad II ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, ad I ");
			$jour_fr=array("Le Dimanche aux IIes ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche aux I&egrave;res ");
		}
		else {
			$jour_l = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
			$jour_fr=array("Le dimanche,","Le lundi,","Le mardi,","Le mercredi,","Le jeudi,","Le vendredi,","Le samedi,");
		}
		
		$jrdelasemaine=date("w",$day);
		$this->date_fr=$jour_fr[$jrdelasemaine];
		$this->date_l=$jour_l[$jrdelasemaine];
		
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
				$this->setLettre("A");
				break;
			case 1:
				$this->setLettre("B");
				break;
			case 2:
				$this->setLettre("C");
				break;
		}
		//print_r($lettre."<br>");
		
		$jrdelasemaine++; // pour avoir dimanche=1 etc...
		$spsautier=$this->calendarium['hebdomada_psalterium'][$jour];
		
		/*
		 * Chargement du propre au psautier du jour
		 */
		$fichier="romain/commune/psautier_".$spsautier.$jrdelasemaine.".csv";
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
		$tem=$this->calendarium['tempus'][$jour];
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
				if ($this->calendarium['intitule'][$jour]=="Feria IV Cinerum") { $q="quadragesima_0";}
				switch ($this->calendarium['hebdomada'][$jour]) {
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
				switch ($this->calendarium['hebdomada'][$jour]) {
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
				print"<br><i>Cet office n'est pas encore compl&egrave;tement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacterromain/index.php\">Vous pouvez nous aider &agrve; compl&eacute;ter ce travail.</a></i>";
				return;
				break;
		}
		$fichier="romain/temporal/".$psautier."/".$q.$jrdelasemaine.".csv";
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
		if (($this->calendarium['rang'][$jour])or($this->calendarium['priorite'][$jour]==12)) {
			$prop=$mense.$die;
			$fichier="romain/sanctoral/".$prop.".csv";
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
			$fichier="romain/sanctoral/".$prop.".csv";
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
			$fichier="romain/temporal/".$psautier."/".$q.$jrdelasemaine."post1712.csv";
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
		
		if($this->calendarium['temporal'][$jour]) {
			$tempo=$this->calendarium['temporal'][$jour];
			$fichier="romain/temporal/".$tempo.".csv";
			if (!file_exists($fichier)) print_r("<p>temporal : ".$fichier." introuvable !</p>");
			$fp = fopen ($fichier,"r");
			while ($data = fgetcsv ($fp, 1000, ";")) {
				$id=$data[0];
				if ($id=="2magnificat_A") $id="magnificat_A";
				if ($id=="2magnificat_B") $id="magnificat_B";
				if ($id=="2magnificat_C") $id="magnificat_C";
				$this->temporal[$id]['latin']=$data[1];
				$this->temporal[$id]['francais']=$data[2];
				$row++;
			}
			fclose($fp);
			
		
			$this->date_fr=$this->date_l=null;
			if($_GET['office']=='vepres') {
				// Gestion intitule Ieres ou IIndes vepres en latin
				if (($this->calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($this->calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($this->calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($this->calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $this->date_l="<br> ad ";
				elseif ($this->calendarium['1V'][$jour]) $this->date_l="<br> ad II ";
				else $this->date_l = "<br> ad ";
		
				// Gestion intitule Ieres ou IIndes vepres en francais
				if (($this->calendarium['intitule'][$jour]=="FERIA QUARTA CINERUM")or($this->calendarium['intitule'][$jour]=="DOMINICA RESURRECTIONIS")or($this->calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>VENDREDI SAINT")or($this->calendarium['intitule'][$jour]=="TRIDUUM PASCAL<br>JEUDI SAINT")) $this->date_fr="<br> aux ";
				elseif ($this->calendarium['1V'][$jour]) $this->date_fr = "<br> aux IIdes ";
				else $this->date_fr = "<br> aux ";
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
				$this->calendarium['priorite'][$jour]++;
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
		 print_r("<p> 1V demain : ".$this->calendarium['1V'][$demain]."</p>");
		 print_r("<p> priorite jour : ".$this->calendarium['priorite'][$jour]."</p>");
		 print_r("<p> priorite demain : ".$this->calendarium['priorite'][$demain]."</p>");
		print_r("<p> intitule demain : ".$this->calendarium['intitule'][$demain]."</p>");*/
		if (($this->calendarium['1V'][$demain]==1)&&($this->calendarium['priorite'][$jour]>$this->calendarium['priorite'][$demain])&&($_GET['office']=='vepres')) {
			/*print_r("<p> 1V</p>");*/
			$tempo=null;
			$this->temporal=null;
			$tempo=$this->calendarium['temporal'][$demain];
			$fichier="romain/temporal/".$tempo.".csv";
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
			$this->date_l = "ad I ";
			$this->date_fr = "aux I&egrave;res ";
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
			$pmagnificat="pmagnificat_".$this->lettre;
			$magnificat="magnificat_".$this->lettre;
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
	
	/*
	 * Méthode d'inistialisation d'un objet de type Office en vue d'afficher les Laudes
	 * Cette méthode est appelée par le fichier index
	 * Entrée :
	 * 		$office : objet de type Office à initialiser
	 * 		$jour au format aaaammjj du jour de l'office,
	 */
	
	function initialisationOffice($office,$jour) {
		
		if (!$this->calendarium) $this->setCalendarium($jour);
		if (!$this->ferial)$this->initialisationSources($jour);
		
		// Initialisation de l'ordo
		if ($this->sanctoral['jour']['latin']) {
			$pr_lat=$this->sanctoral['jour']['latin'];
			$pr_fr=$this->sanctoral['jour']['francais'];
		}
		if (!$pr_lat) {
			$pr_lat=$this->temporal['jour']['latin'];
			$pr_fr=$this->temporal['jour']['francais'];
		}
		if($pr_lat){
			$office->setOrdo($pr_lat, $pr_fr);
			$office->setOratio($this->sanctoral['oratio']['latin'], $this->sanctoral['oratio']['francais']);
		}
		
		// Initialisation de l'intitule
		if ($this->sanctoral['intitule']['latin']) {
			$intitule_lat=$this->sanctoral['intitule']['latin'];
			$intitule_fr=$this->sanctoral['intitule']['francais'];
		}
		if (!$intitule_lat) {
			$intitule_lat=$this->temporal['intitule']['latin'];
			$intitule_fr=$this->temporal['intitule']['francais'];
		}
		if ($intitule_lat){
			$office->setIntitule($intitule_lat, $intitule_fr);
			$office->setOratio($this->sanctoral['oratio']['latin'], $this->sanctoral['oratio']['francais']);
		}
		
		//Intialisation du rang
		if(!$rang_lat) {
			$rang_lat=$this->sanctoral['rang']['latin'];
			$rang_fr=$this->sanctoral['rang']['francais'];
		}
		if($rang_lat){
			$office->setRangOffice($rang_lat, $rang_fr);
			$office->setOratio($this->sanctoral['oratio']['latin'], $this->sanctoral['oratio']['francais']);
		}
		
		//Initialisation nom de l'office
		if (($pr_lat)or($intitule_lat)or($rang_lat)) {
			switch ($office->typeOffice) {
				case "laudes" :
				case "laudes-invit" :
					$office->setNomOffice("Ad Laudes matutinas", "Aux Laudes du matin");
					break;
				case "tierce" :
					$office->setNomOffice("Ad Tertiam", "A Tierce");
					break;
				case "sexte" :
					$office->setNomOffice("Ad Sextam", "A Sexte");
					break;
				case "none" :
					$office->setNomOffice("Ad Nonam", "A None");
					break;
				case "vepres" :
					$office->setNomOffice("Ad Vesperam", "A Vêpres");
					break;
				case "complies" :
					$office->setNomOffice("Ad Completorium", "Aux Complies");
					break;
			}
			
		}
		else {
			switch ($office->typeOffice) {
				case "laudes" :
				case "laudes-invit" :
					$office->setNomOffice($this->date_l." ad Laudes matutinas", $this->date_fr." aux Laudes du matin");
					break;
				case "tierce" :
					$office->setNomOffice($this->date_l." ad Tertiam", $this->date_fr." à Tierce");
					break;
				case "sexte" :
					$office->setNomOffice($this->date_l." ad Sextam", $this->date_fr." à Sexte");
					break;
				case "none" :
					$office->setNomOffice($this->date_l." ad Nonam", $this->date_fr." à None");
					break;
				case "vepres" :
					$office->setNomOffice($this->date_l." ad Vesperam", $this->date_fr." aux Vêpres");
					break;
				case "complies" :
					$office->setNomOffice($this->date_l." ad Completorium", $this->date_fr." aux Complies");
					break;
			}
		}
		
		
	}
	
	function initialisationLaudes($office,$jour) {

		$this->initialisationOffice($office, $jour);
		
		//Initilisation de l'hymne
		if($this->sanctoral['HYMNUS_laudes']['latin']) $hymne=$this->sanctoral['HYMNUS_laudes']['latin'];
		elseif ($this->temporal['HYMNUS_laudes']['latin']) $hymne=$this->temporal['HYMNUS_laudes']['latin'];
		else $hymne=$this->ferial['HYMNUS_laudes']['latin'];
		$office->setHymne($hymne);
		
		// Intilisation de ANT1
		if($this->sanctoral['ant1']['latin']) {
			$antlat=nl2br($this->sanctoral['ant1']['latin']);
			$antfr=nl2br($this->sanctoral['ant1']['francais']);
		}
		elseif ($this->temporal['ant1']['latin']) {
			$antlat=nl2br($this->temporal['ant1']['latin']);
			$antfr=nl2br($this->temporal['ant1']['francais']);
		}
		else {
			$antlat=$this->ferial['ant1']['latin'];
			$antfr=$this->ferial['ant1']['francais'];
		}
		$office->setAnt1($antlat, $antfr);
					
		// Initialisation de PS1
		if($this->sanctoral['ps1']['latin']) $psaume=$this->sanctoral['ps1']['latin'];
		elseif ($this->temporal['ps1']['latin']) $psaume=$this->temporal['ps1']['latin'];
		else $psaume=$this->ferial['ps1']['latin'];
		$office->setPs1($psaume);
		
		// Initilisation de ANT2
		if($this->sanctoral['ant2']['latin']) {
			$antlat=nl2br($this->sanctoral['ant2']['latin']);
			$antfr=nl2br($this->sanctoral['ant2']['francais']);
		}
		elseif($this->temporal['ant2']['latin']) {
			$antlat=nl2br($this->temporal['ant2']['latin']);
			$antfr=nl2br($this->temporal['ant2']['francais']);
		}
		else {
			$antlat=$this->ferial['ant2']['latin'];
			$antfr=$this->ferial['ant2']['francais'];
		}
		$office->setAnt2($antlat, $antfr);
		
		// Initilisation de PS2
		if($this->sanctoral['ps2']['latin']) $psaume=$this->sanctoral['ps2']['latin'];
		elseif($this->temporal['ps2']['latin']) $psaume=$this->temporal['ps2']['latin'];
		else $psaume=$this->ferial['ps2']['latin'];
		$office->setPs2($psaume);
		
		// initialisation de ANT3
		if($this->sanctoral['ant3']['latin']) {
			$antlat=nl2br($this->sanctoral['ant3']['latin']);
			$antfr=nl2br($this->sanctoral['ant3']['francais']);
		}
		elseif($this->temporal['ant3']['latin']) {
			$antlat=nl2br($this->temporal['ant3']['latin']);
			$antfr=nl2br($this->temporal['ant3']['francais']);
		}
		else {
			$antlat=$this->ferial['ant3']['latin'];
			$antfr=$this->ferial['ant3']['francais'];
		}
		$office->setAnt3($antlat, $antfr);
		
		// Initialisation de PS3
		if($this->sanctoral['ps3']['latin']) $psaume=$this->sanctoral['ps3']['latin'];
		elseif($this->temporal['ps3']['latin']) $psaume=$this->temporal['ps3']['latin'];
		else $psaume=$this->ferial['ps3']['latin'];
		$office->setPs3($psaume);
		
		// Initialisation de LB
		if($this->sanctoral['LB_matin']['latin']) $LB_matin=$this->sanctoral['LB_matin']['latin'];
		elseif ($this->temporal['LB_matin']['latin']) $LB_matin=$this->temporal['LB_matin']['latin'];
		else $LB_matin=$this->ferial['LB_matin']['latin'];
		$office->setLectio($LB_matin);
		
		// Initialisation de RB
		if($this->sanctoral['RB_matin']['latin']) {
			$rblat=nl2br($this->sanctoral['RB_matin']['latin']);
			$rbfr=nl2br($this->sanctoral['RB_matin']['francais']);
		}
		elseif($this->temporal['RB_matin']['latin']) {
			$rblat=nl2br($this->temporal['RB_matin']['latin']);
			$rbfr=nl2br($this->temporal['RB_matin']['francais']);
		}
		else {
			$rblat=nl2br($this->ferial['RB_matin']['latin']);
			$rbfr=nl2br($this->ferial['RB_matin']['francais']);
		}
		$office->setRepons($rblat, $rbfr);
		
		// Initialisation de AntEv
		$benedictus="benedictus_".$this->lettre;
		if($this->sanctoral[$benedictus]['latin']) {
			$benelat=$this->sanctoral[$benedictus]['latin'];
			$benefr=$this->sanctoral[$benedictus]['francais'];
		}
		elseif($this->sanctoral['benedictus']['latin']) {
			$benelat=$this->sanctoral['benedictus']['latin'];
			$benefr=$this->sanctoral['benedictus']['francais'];
		}
		elseif ($this->temporal($benedictus,'latin')) {
			$benelat=$this->temporal[$benedictus]['latin'];
			$benefr=$this->temporal[$benedictus]['francais'];
		}
		elseif ($this->temporal['benedictus']['latin']) {
			$benelat=$this->temporal['benedictus']['latin'];
			$benefr=$this->temporal['benedictus']['francais'];
		}
		else {
			$benelat=$this->ferial['benedictus']['latin'];
			$benefr=$this->ferial['benedictus']['francais'];
		}
		$office->setAntEv($benelat, $benefr);
		
		// Initialisaiton de PRECES
		if($this->sanctoral['preces_matin']['latin']) $preces=$this->sanctoral['preces_matin']['latin'];
		elseif($this->temporal['preces_matin']['latin']) $preces=$this->temporal['preces_matin']['latin'];
		else $preces=$this->ferial['preces_matin']['latin'];
		$office->setPreces($preces);
		
		//Initialisation de ORATIO
		if($this->sanctoral['oratio']['latin']) {
			$oratiolat=$this->sanctoral['oratio']['latin'];
			$oratiofr=$this->sanctoral['oratio']['francais'];
		}
		elseif($this->temporal['oratio']['latin']) {
			$oratiolat=$this->temporal['oratio']['latin'];
			$oratiofr=$this->temporal['oratio']['francais'];
		}
		elseif ($oratiolat=$this->ferial['oratio_laudes']['latin']) {
			$oratiolat=$this->ferial['oratio_laudes']['latin'];
			$oratiofr=$this->ferial['oratio_laudes']['francais'];
		}
		elseif ($oratiolat=$this->ferial['oratio']['latin']) {
			$oratiolat=$this->ferial['oratio']['latin'];
			$oratiofr=$this->ferial['oratio']['francais'];
		}
		$office->setOratio($oratiolat, $oratiofr);
		
		// Fin initialisaiton des Laudes
	} 
	
	function initialisationVepres($office,$jour) {
		$this->initialisationOffice($office, $jour);
		
		//Initilisation de l'hymne
		if($this->sanctoral['HYMNUS_vepres']['latin']) $hymne=$this->sanctoral['HYMNUS_vepres']['latin'];
		elseif ($this->temporal['HYMNUS_vepres']['latin']) $hymne=$this->temporal['HYMNUS_vepres']['latin'];
		else $hymne=$this->ferial['HYMNUS_vesperas']['latin'];
		$office->setHymne($hymne);
		
		// Intilisation de ANT1
		if($this->sanctoral['ant7']['latin']) {
			$antlat=nl2br($this->sanctoral['ant7']['latin']);
			$antfr=nl2br($this->sanctoral['ant7']['francais']);
		}
		elseif ($this->temporal['ant7']['latin']) {
			$antlat=nl2br($this->temporal['ant7']['latin']);
			$antfr=nl2br($this->temporal['ant7']['francais']);
		}
		else {
			$antlat=$this->ferial['ant7']['latin'];
			$antfr=$this->ferial['ant7']['francais'];
		}
		$office->setAnt1($antlat, $antfr);
			
		// Initialisation de PS1
		if($this->sanctoral['ps7']['latin']) $psaume=$this->sanctoral['ps7']['latin'];
		elseif ($this->temporal['ps7']['latin']) $psaume=$this->temporal['ps7']['latin'];
		else $psaume=$this->ferial['ps7']['latin'];
		$office->setPs1($psaume);
		
		// Initilisation de ANT2
		if($this->sanctoral['ant8']['latin']) {
			$antlat=nl2br($this->sanctoral['ant8']['latin']);
			$antfr=nl2br($this->sanctoral['ant8']['francais']);
		}
		elseif($this->temporal['ant8']['latin']) {
			$antlat=nl2br($this->temporal['ant8']['latin']);
			$antfr=nl2br($this->temporal['ant8']['francais']);
		}
		else {
			$antlat=$this->ferial['ant8']['latin'];
			$antfr=$this->ferial['ant8']['francais'];
		}
		$office->setAnt2($antlat, $antfr);
		
		// Initilisation de PS2
		if($this->sanctoral['ps8']['latin']) $psaume=$this->sanctoral['ps8']['latin'];
		elseif($this->temporal['ps8']['latin']) $psaume=$this->temporal['ps8']['latin'];
		else $psaume=$this->ferial['ps8']['latin'];
		$office->setPs2($psaume);
		
		// initialisation de ANT3
		if($this->sanctoral['ant9']['latin']) {
			$antlat=nl2br($this->sanctoral['ant9']['latin']);
			$antfr=nl2br($this->sanctoral['ant9']['francais']);
		}
		elseif($this->temporal['ant9']['latin']) {
			$antlat=nl2br($this->temporal['ant9']['latin']);
			$antfr=nl2br($this->temporal['ant9']['francais']);
		}
		else {
			$antlat=$this->ferial['ant9']['latin'];
			$antfr=$this->ferial['ant9']['francais'];
		}
		$office->setAnt3($antlat, $antfr);
		
		// Initialisation de PS3
		if($this->sanctoral['ps9']['latin']) $psaume=$this->sanctoral['ps9']['latin'];
		elseif($this->temporal['ps9']['latin']) $psaume=$this->temporal['ps9']['latin'];
		else $psaume=$this->ferial['ps9']['latin'];
		$office->setPs3($psaume);
		
		// Initialisation de LB
		if($this->sanctoral['LB_soir']['latin']) $LB_matin=$this->sanctoral['LB_soir']['latin'];
		elseif ($this->temporal['LB_soir']['latin']) $LB_matin=$this->temporal['LB_soir']['latin'];
		else $LB_matin=$this->ferial['LB_soir']['latin'];
		$office->setLectio($LB_matin);
		
		// Initialisation de RB
		if($this->sanctoral['RB_soir']['latin']) {
			$rblat=nl2br($this->sanctoral['RB_soir']['latin']);
			$rbfr=nl2br($this->sanctoral['RB_soir']['francais']);
		}
		elseif($this->temporal['RB_soir']['latin']) {
			$rblat=nl2br($this->temporal['RB_soir']['latin']);
			$rbfr=nl2br($this->temporal['RB_soir']['francais']);
		}
		else {
			$rblat=nl2br($this->ferial['RB_soir']['latin']);
			$rbfr=nl2br($this->ferial['RB_soir']['francais']);
		}
		$office->setRepons($rblat, $rbfr);
		
		// Initialisation de AntEv
		$magnificat="magnificat_".$this->lettre;
		if($this->sanctoral[$magnificat]['latin']) {
			$magnilat=$this->sanctoral[$magnificat]['latin'];
			$magnifr=$this->sanctoral[$magnificat]['francais'];
		}
		elseif($this->sanctoral['magnificat']['latin']) {
			$magnilat=$this->sanctoral['magnificat']['latin'];
			$magnifr=$this->sanctoral['magnificat']['francais'];
		}
		elseif ($this->temporal($magnificat,'latin')) {
			$magnilat=$this->temporal[$magnificat]['latin'];
			$magnifr=$this->temporal[$magnificat]['francais'];
		}
		elseif ($this->temporal['magnificat']['latin']) {
			$magnilat=$this->temporal['magnificat']['latin'];
			$magnifr=$this->temporal['magnificat']['francais'];
		}
		else {
			$magnilat=$this->ferial['magnificat']['latin'];
			$magnifr=$this->ferial['magnificat']['francais'];
		}
		$office->setAntEv($magnilat, $magnifr);
		
		// Initialisaiton de PRECES
		if($this->sanctoral['preces_soir']['latin']) $preces=$this->sanctoral['preces_soir']['latin'];
		elseif($this->temporal['preces_soir']['latin']) $preces=$this->temporal['preces_soir']['latin'];
		else $preces=$this->ferial['preces_soir']['latin'];
		$office->setPreces($preces);
		
		//Initialisation de ORATIO
		if($this->sanctoral['oratio']['latin']) {
			$oratiolat=$this->sanctoral['oratio']['latin'];
			$oratiofr=$this->sanctoral['oratio']['francais'];
		}
		elseif($this->temporal['oratio']['latin']) {
			$oratiolat=$this->temporal['oratio']['latin'];
			$oratiofr=$this->temporal['oratio']['francais'];
		}
		elseif ($oratiolat=$this->ferial['oratio_vesperas']['latin']) {
			$oratiolat=$this->ferial['oratio_vesperas']['latin'];
			$oratiofr=$this->ferial['oratio_vesperas']['francais'];
		}
		elseif ($oratiolat=$this->ferial['oratio']['latin']) {
			$oratiolat=$this->ferial['oratio']['latin'];
			$oratiofr=$this->ferial['oratio']['francais'];
		}
		$office->setOratio($oratiolat, $oratiofr);
		
		// Fin initialisaiton des Vêpres
	}
	
	function initialisationTierce($office,$jour) {
		$this->initialisationOffice($office, $jour);
	
	}
	
	function initialisationSexte($office,$jour) {
		$this->initialisationOffice($office, $jour);
		
	}
	
	function initialisationNone($office,$jour) {
		$this->initialisationOffice($office, $jour);
		
	}
	
	function initialisationComplies($office,$jour) {
		$this->initialisationOffice($office, $jour);
		
	}
}