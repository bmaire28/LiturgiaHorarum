<?php

function citation() {
$fond = 'pied';
$delais =  3600 *24 *30 ;
$q="SELECT * FROM citation ORDER BY RAND() LIMIT 1";
$r=mysql_query($q);
$cit=mysql_fetch_object($r);

print "<i>Une citation</i> : <br>$cit->texte<br><i>$cit->auteur</i>";	;
}



function couleur($day) {
print"/templates/js_naturale/css/template_$couleur.css";
}



function mod_calendarium($mois_courant,$an) {
//print_r($couleurs);
if($mois_courant=="") $jl=time();
else $jl=mktime(12,12,0,$mois_courant,01,$an);
$an.$mois_courant."01";
//print"<br>jl=$jl";
$datj=date("Ymd",$jl);
$calend=calendarium($datj);
$task=$_GET['task'];
$office=$_GET['office'];
//print"<br>calend=";
//print_r($calend);

$couleurs=$calend[couleur_template];
//print_r($couleurs);
$mois= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
$hodie=time();
if($an=="") $anno=@date("Y",$hodie);
else $anno=$an;
if($mois_courant=="") $mois_courant=@date("m",$hodie);
if($mois_courant=="13") {
	$mois_courant=1;
	$anno++;
}
if($mois_courant=="0") {
	$mois_courant=12;
	$anno--;
}
$mense=$mois[$mois_courant-1];
//$anno=@date("Y",$hodie);
$date_courante=mktime(12,0,0,$mois_courant,1,$anno);
$s=0;$i=1;$sem=array();
while(date("m",$date_courante)==$mois_courant) {
	$jour=date("w",$date_courante);

	$sem[$s][$jour]=$i;
	if ($jour==6) { $jour=0; $s++;}
 	//print"[$s|$jour]=$i";
	$i++;
	$date_courante=$date_courante+60*60*24;

}
$feria=@date("w",$hodie);
$coul['Rouge']="#ff0000";
$coul['Vert']="#1b6f1f";
$coul['Blanc']="#ffeda6";
$coul['Violet']="#C800FE";
$coul['Violet-avent']="#C800FE";
$coul['Violet-careme']="#9200AC";
$coul['Rose']="#FE00F9";
//$coul['Rose']="#d1a8a8";
$coul['Noir']="#000000";

print"<div class=\"moduletable\">
<h3>Calendarium liturgicum $anno</h3>
<table style=\"text-align: center; width: 100px; height: 134px;\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
  <tbody><tr>
  <td><b>Do.</b></td>
  <td>F.2</td>
  <td>F.3</td>
  <td>F.4</td>
  <td>F.5</td>
  <td>F.6</td>
  <td>Sa.</td>
  </tr>";

	for ($u=0;$u<6;$u++) {
    print"<tr>";
    $f=$sem[$u][0];
    $jour_ts=mktime(12,0,0,$mois_courant,$f,$anno);
    $jour=date("Ymd",$jour_ts);
    $iff=$couleurs[$jour];
    $coloris=$coul[$iff];
    $couleur_fonte=$coul['Noir'];
    if (($coloris==$coul['Noir'])OR($coloris==$coul['Violet-avent'])OR($coloris==$coul['Violet-careme'])OR($coloris==$coul['Vert'])) $couleur_fonte="#ffffff";

    $titre=$calend['intitule'][$jour];
      if($f!="")    print"<td style=\"width: 25px; background-color: $coloris; color:$couleur_fonte; text-align: center;  text-decoration: underline;\"><a style=\"color: #000000;\"  href=\"index.php?date=$jour&amp;mois_courant=$mois_courant&amp;an=$anno&amp;task=$task&amp;office=$office\" title=\"$titre\"><font color=$couleur_fonte>$f</font></a></td>";
		else print"<td style=\"width: 25px; color: #000000; text-align: center; text-decoration: underline;\"></td>";
	for($n=1;$n<7;$n++) {
	$f=$sem[$u][$n];
    $jour_ts=mktime(12,0,0,$mois_courant,$f,$anno);
    $jour=date("Ymd",$jour_ts);
    $iff=$couleurs[$jour];
    $coloris=$coul[$iff];
    $couleur_fonte=$coul['Noir'];
    if (($coloris==$coul['Noir'])OR($coloris==$coul['Violet-avent'])OR($coloris==$coul['Violet-careme'])OR($coloris==$coul['Vert'])) $couleur_fonte="#ffffff";

    $titre=$calend['intitule'][$jour];
	  if($f!="") print"<td style=\"width: 25px; background-color: $coloris; text-align: center;\"><a style=\"color: #000000;\" href=\"index.php?date=$jour&amp;mois_courant=$mois_courant&amp;an=$anno&amp;task=$task&amp;office=$office\" title=\"$titre\"><font color=$couleur_fonte>$f</font></a></td>";
        else print"<td style=\"width: 25px; text-align: center;  text-decoration: underline;\"></td>";

	}
}
    print"
    <tr>";
    $mois_moins=$mois_courant-1;
    $mois_plus=$mois_courant+1;
    print"
      <td><a href=\"index.php?mois_courant=$mois_moins&amp;an=$anno\">&lt;&lt;</a></td>
      <td style=\"text-align: center;\" colspan=\"5\" rowspan=\"1\"><a href=\"index.php?mense=$mois_courant\">$mense</a></td>
      <td><a href=\"index.php?mois_courant=$mois_plus&amp;an=$anno\">&gt;&gt;</a></td>
    </tr>
  </tbody>
</table>
";

}





function date_latin($j)
{
	if($j==null) $j=time();
 $mois= array("Ianuarii","Februarii","Martii","Aprilis","Maii","Iunii","Iulii","Augustii","Septembris","Octobris","Novembris","Decembris");
 $jours = array("Dominica,", "Feria secunda,","Feria tertia,","Feria quarta,","Feria quinta,","Feria sexta,", "Sabbato,");
 $date= $jours[@date("w",$j)]." ".@date("j",$j)." ".$mois[@date("n",$j)-1]." ".@date("Y",$j);
 return $date;
}

function calendarium($date) {
//// Forme de la variable date : AAAAMMJJ
    /*

Le math�maticien Gauss avait trouv� un algorithme (une formule) pour calculer
cette date. Un autre math�maticien, T. H. O�Beirne, a trouv� deux erreurs dans
la formule de Gauss. Il a alors formul� un autre algorithme :

Soit m l�ann�e, on fait les calculs suivants :

   1. On soustrait 1900 de m : c�est la valeur de n.
   2. On divise n par 19 : le reste est la valeur de a.
   3. On divise (7a + 1) par 19 : la partie enti�re du quotient est b.
   4. On divise (11a - b + 4) par 29 : le reste est c.
   5. On divise n par 4 : la partie enti�re du quotient est d.
   6. On divise (n - c + d + 31) par 7 : le reste est e.

La date de P�ques est le (25 - c - e) avril si le r�sultat est positif.
S�il est n�gatif, le mois est mars. Le quanti�me est la somme de 31 et
du r�sultat.
Par exemple, si le r�sultat est -7, le quanti�me est 31 + -7 = 24.

*/

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

$anno=substr($date,0,4);
$mense=substr($date,4,2);
$die=substr($date,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);
//$day=mktime(12,0,0,0,$mon,$dat,$year);
//$day=time();
//print"<br>option=$option";
//if ($option!="") $m=$option;
 $m=@date("Y",$day);
//$m="2006";

$n=$m-1900; //print"<br>$n";
$a=$n%19; //print"<br>$a";
$b=intval((7*$a+1)/19); //print"<br>$b";
$c=(11*$a-$b+4)%29; //print"<br>$c";
$d=intval($n/4); //print"<br>$d";
$e=($n-$c+$d+31)%7; //print"<br>$e";

if($e>=0) {
	$p=25-$c-$e;
	$paques=mktime(12, 0, 0, 4, $p, $m);
}
if($e<0) {
	$p=31+$e;
	$paques=mktime(12, 0, 0, 3, $p, $m);
}
setlocale (LC_ALL, 'FR');
$res = date("Ymd", $paques);

//print"<br>PAQUES $res : $paques";
$jour=60*60*24;
$semaine=60*60*24*7;

$noel=mktime(12,0,0,12,25,$m);
$no=date("Ymd", $noel);
$jour_noel=date("w", $noel);

$temporal['intitule'][$no]="IN NATIVITATE DOMINI";
$temporal['couleur'][$no]="Blanc";
$temporal['tempus'][$no]="Tempus Nativitatis";
$temporal['hebdomada'][$no]="Infra octavam Nativitatis";
$temporal['priorite'][$no]="2";
$temporal['1V'][$no]=1;

$sanctae_familiae2=$noel+(7-$jour_noel)*$jour;
$jj=date("w", $sanctae_familiae2);
//if($jj==0) $sanctae_familiae2=mktime(12,0,0,12,30,$m);
$dd=date("Ymd", $sanctae_familiae2);
$temporal['intitule'][$dd]="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
$temporal['tempus'][$dd]="Tempus Nativitatis";
$temporal['couleur'][$dd]="Blanc";
$temporal['priorite'][$dd]="7";
$temporal['1V'][$dd]=1;

$noel_annee_precedente=mktime(12,0,0,12,25,$m-1);
$dd=date("Ymd", $noel_annee_precedente);
$temporal['intitule'][$dd]="IN NATIVITATE DOMINI";
$temporal['couleur'][$dd]="Blanc";
$temporal['priorite'][$dd]="2";
$temporal['tempus'][$dd]="Tempus Nativitatis";
$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
$temporal['1V'][$dd]=1;
$jour_noel_precedent=date("w", $noel_annee_precedente);

$sanctae_familiae=$noel_annee_precedente+(7-$jour_noel_precedent)*$jour;
$jj=date("w", $sanctae_familiae);
//if($jj==0) $sanctae_familiae=mktime(12,0,0,12,30,$m-1);
$dd=date("Ymd", $sanctae_familiae);
$temporal['intitule'][$dd]="SANCTAE FAMILIAE IESU, MARIAE ET IOSEPH";
$temporal['priorite'][$dd]="7";
$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
$temporal['tempus'][$dd]="Tempus Nativitatis";
$temporal['couleur'][$dd]="Blanc";
$temporal['1V'][$dd]=1;

$infra_oct_nativ=$noel_annee_precedente+7*$jour;
$dd=date("Ymd", $infra_oct_nativ);
$temporal['hebdomada'][$dd]="Infra Octavam Nativitatis";
$temporal['tempus'][$dd]="Tempus Nativitatis";
$temporal['couleur'][$dd]="Blanc";

$fin_oct_nativitatis=$noel_annee_precedente+9*$jour;
$dd=date("Ymd", $fin_oct_nativitatis);
$temporal['hebdomada'][$dd]=" ";
$temporal['tempus'][$dd]="Tempus Nativitatis";
$temporal['couleur'][$dd]="Blanc";

$epiphania=mktime(12,0,0,1,6,$m);
$jour_epiphanie=date("w", $epiphania);
$baptisma=$epiphania+(7-$jour_epiphanie)*$jour;
$dd=date("Ymd", $baptisma);
$temporal['intitule'][$dd]="IN BAPTISMATE DOMINI";
$temporal['rang'][$dd]="Festum";
$temporal['priorite'][$dd]="5";
$temporal['1V'][$dd]=1;
//$temporal['hebdomada'][$dd]="Infra octavam Nativitatis";
$temporal['tempus'][$dd]="Tempus Nativitatis";
$temporal['couleur'][$dd]="Blanc";
$perannum=$baptisma+$jour;
$dd=date("Ymd", $perannum);
$temporal['tempus'][$dd]="Tempus per annum";
$temporal['hebdomada'][$dd]="Hebdomada I per annum";
$temporal['couleur'][$dd]="Vert";
$temporal['hp'][$dd]=1;
$temporal['psautier'][$dd]="perannum";

$palmis=$paques-$semaine;
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

$in_cena=$palmis+4*$jour;
$dd=date("Ymd", $in_cena);
$temporal['intitule'][$dd]="IN CENA DOMINI";
$temporal['temporal'][$dd]="IN CENA DOMINI";
$temporal['priorite'][$dd]="1";
$temporal['hebdomada'][$dd]="Sacrum Triduum Paschale";
$temporal['tempus'][$dd]="Tempus passionis";
$temporal['couleur'][$dd]="Blanc";

$in_passione=$in_cena+$jour;
$dd=date("Ymd", $in_passione);
$temporal['intitule'][$dd]="IN PASSIONE DOMINI";
$temporal['temporal'][$dd]="IN PASSIONE DOMINI";
$temporal['priorite'][$dd]="1";
$temporal['couleur'][$dd]="Rouge";

$sabbato_sancto=$in_passione+$jour;
$dd=date("Ymd", $sabbato_sancto);
$temporal['intitule'][$dd]="Sabbato Sancto";
$temporal['priorite'][$dd]="1";
$temporal['couleur'][$dd]="Violet-careme";
/*
$Y= substr($dd, 0, 4); //print"<br>$Y";
$mois= substr($dd, 4, 2);//print"<br>$mois";
$day= substr($dd, 6, 2);//print"<br>$day";
$palmis=mktime(12,0,0,$mois,$day,$Y);
*/
$cinq_quadragesima=$palmis-$semaine;
$dd=date("Ymd", $cinq_quadragesima);
$temporal['intitule'][$dd]="Dominica V Quadragesimae";
$temporal['temporal'][$dd]="Dominica V Quadragesimae";
$temporal['hp'][$dd]=1;
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada V Quadragesimae";
$temporal['tempus'][$dd]="Tempus Quadragesimae";
/*
$Y= substr($dd, 0, 4); //print"<br>$Y";
$mois= substr($dd, 4, 2);//print"<br>$mois";
$day= substr($dd, 6, 2);//print"<br>$day";
$cinq_quadragesima=mktime(12,0,0,$mois,$day,$Y);
*/
$quatre_quadragesima=$cinq_quadragesima-$semaine;
$dd=date("Ymd", $quatre_quadragesima);
$temporal['intitule'][$dd]="Dominica IV Quadragesimae";
$temporal['temporal'][$dd]="Dominica IV Quadragesimae";
$temporal['hp'][$dd]=4;
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada IV Quadragesimae";
$temporal['couleur'][$dd]="Rose";
/*
$Y= substr($dd, 0, 4); //print"<br>$Y";
$mois= substr($dd, 4, 2);//print"<br>$mois";
$day= substr($dd, 6, 2);//print"<br>$day";
$quatre_quadragesima=mktime(12,0,0,$mois,$day,$Y);
*/
$coul_quadragesima=$quatre_quadragesima+$jour;
$dd=date("Ymd", $coul_quadragesima);
$temporal['couleur'][$dd]="Violet-careme";

//$temporal['tempus'][$dd]="Tempus Quadragesimae";

$trois_quadragesima=$quatre_quadragesima-$semaine;
$dd=date("Ymd", $trois_quadragesima);
$temporal['intitule'][$dd]="Dominica III Quadragesimae";
$temporal['temporal'][$dd]="Dominica III Quadragesimae";
$temporal['hp'][$dd]=3;
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada III Quadragesimae";
$temporal['couleur'][$dd]="Violet-careme";
//$temporal['tempus'][$dd]="Tempus Quadragesimae";

$deux_quadragesima=$trois_quadragesima-$semaine;
$dd=date("Ymd", $deux_quadragesima);
$temporal['intitule'][$dd]="Dominica II Quadragesimae";
$temporal['temporal'][$dd]="Dominica II Quadragesimae";
//Dominica I Quadragesimae
$temporal['hp'][$dd]=2;
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada II Quadragesimae";
$temporal['couleur'][$dd]="Violet-careme";
//$temporal['tempus'][$dd]="Tempus Quadragesimae";
$un_quadragesima=$deux_quadragesima-$semaine;
$dd=date("Ymd", $un_quadragesima);
$temporal['intitule'][$dd]="Dominica I Quadragesimae";
$temporal['temporal'][$dd]="Dominica I Quadragesimae";
$temporal['hp'][$dd]=1;
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada I Quadragesimae";
$temporal['couleur'][$dd]="Violet-careme";

$cinerum=$un_quadragesima-4*$jour;
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


$pa=date("Ymd", $paques);
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
//$temporal['rang'][$dd]="Sollemnitas";
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;

$sept_paques=$paques+6*$semaine;
$dd=date("Ymd", $sept_paques);
//$septpa=$dd;
$temporal['intitule'][$dd]="Dominica VII Paschae";
$temporal['temporal'][$dd]="Dominica VII Paschae";
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada VII Paschae";
$temporal['hp'][$dd]=3;

$pentecostes=$paques+7*$semaine;

$sacritissimicordis=$pentecostes+2*$semaine+5*$jour;
$sacri=date("Ymd", $sacritissimicordis);
$temporal['couleur'][$sacri]="Rouge";
$temporal['intitule'][$sacri]="SACRATISSIMI CORDIS IESU";
$temporal['temporal'][$sacri]="SACRATISSIMI CORDIS IESU";
$temporal['priorite'][$sacri]="5";
$temporal['1V'][$sacri]=1;
$temporal['rang'][$sacri]="Sollemnitas";
$cordismaria=$sacritissimicordis+$jour;
$cordi=date("Ymd", $cordismaria);
$temporal['intitule'][$cordi]="�Immaculati Cordis B. Mariae Virginis";
$temporal['temporal'][$cordi]="�Immaculati Cordis B. Mariae Virginis";
$temporal['priorite'][$cordi]="10";
$temporal['rang'][$cordi]="Memoria";

$temporal['couleur'][$cordi]="Rouge";
$perannum=$cordismaria+$jour;
$perann=date("Ymd", $perannum);
$temporal['couleur'][$perann]="Vert";
//$temporal['hebdomada'][$penteco]="Hebdomada VII Paschae";

$noe=date("d-M-Y", $noel);


//print"<br>$noe";
$journoel=date("w",$noel);
if ($journoel==0) $journoel=7;

$quatre_dim_avent=$noel-$journoel*$jour;
$dd=date("Ymd", $quatre_dim_avent);
$temporal['intitule'][$dd]="Dominica IV Adventus";
$temporal['temporal'][$dd]="Dominica IV Adventus";
$temporal['hp'][$dd]=4;
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hebdomada'][$dd]="Hebdomada IV Adventus";
$temporal['couleur'][$dd]="Violet-avent";


$trois_dim_avent=$quatre_dim_avent-$semaine;
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


$deux_dim_avent=$trois_dim_avent-$semaine;
$dd=date("Ymd", $deux_dim_avent);
$temporal['intitule'][$dd]="Dominica II Adventus";
$temporal['temporal'][$dd]="Dominica II Adventus";
$temporal['hp'][$dd]=2;
$temporal['1V'][$dd]=1;
$temporal['priorite'][$dd]="2";
$temporal['hebdomada'][$dd]="Hebdomada II Adventus";

$un_dim_avent=$deux_dim_avent-$semaine;
$dd=date("Ymd", $un_dim_avent);
$temporal['intitule'][$dd]="Dominica I Adventus";
$temporal['temporal'][$dd]="Dominica I Adventus";
$temporal['hp'][$dd]=1;
$temporal['1V'][$dd]=1;
$temporal['priorite'][$dd]="2";
$temporal['hebdomada'][$dd]="Hebdomada I Adventus";
$temporal['tempus'][$dd]="Tempus Adventus";
$temporal['couleur'][$dd]="Violet-avent";
$dnisuchrisitiunivregis=$un_dim_avent-$semaine;

$entre_tempspascal_et_avent=$dnisuchrisitiunivregis-$sept_paques;
$nbsemaines_perannum=intval($entre_tempspascal_et_avent/$semaine);

//print"
//<br>DNICUR : $dnisuchrisitiunivregis
//<br>entre temps pascal et avent : $nbsemaines_perannum";
$reprise_perannum=34-$nbsemaines_perannum+1;

$entre_tempsnoel_et_careme=$un_quadragesima-$baptisma;
$nbsemaines_perannum=intval($entre_tempsnoel_et_careme/$semaine)+1;
//print"<br>per annum jusqu'� : $nbsemaines_perannum";
//print"<br>reprise per annum : $reprise_perannum";

$dim_courant=$reprise_perannum;
$date=$pentecostes;

$hebdomada_reprise=$pentecostes+$jour;
$numero = $romains[$dim_courant];
$hp=(($dim_courant/4)-intval($dim_courant/4))*4;
if($hp==0) $hp=4;

//Pentec�te
$dd=date("Ymd", $pentecostes);
$temporal['intitule'][$dd]="Dominica Pentecostes";
$temporal['temporal'][$dd]="Dominica Pentecostes";
$temporal['priorite'][$dd]="2";
$temporal['1V'][$dd]=1;
$temporal['hp'][$dd]=$hp;
$temporal['tempus'][$dd]="Tempus Paschale";
$temporal['hebdomada'][$dd]="";
$temporal['couleur'][$dd]="Rouge";

//Semaine apr�s a Pentec�te
$dd=date("Ymd", $hebdomada_reprise);
$temporal['hebdomada'][$dd]="Hebdomada $numero per annum";
$temporal['hp'][$dd]=$hp;
$perannum=$pentecostes+$jour;
$perann=date("Ymd", $perannum);
$temporal['couleur'][$perann]="Vert";
$temporal['tempus'][$perann]="Tempus per annum";



//$temporal['hebdomada'][$dd]="";

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
	//if($temporal['hebdomada'][$dd]=="Hebdomada I per annum") $hp=1;

	//print"<br>$dim_courant per annum = psalt heb n�$hp";
	$temporal['hp'][$dd]=$hp;
	//print "<br>temporal[priorite][$dd]=".$temporal['priorite'][$dd];
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
	//print"<br>$heb_courante per annum = psalt heb n�$hp";
	//if ($heb_courante==1) $hp=1;
	$temporal['hp'][$dd]=$hp;
	//print"hp=$hp";
	//print "<br>temporal[priorite][$dd]=".$temporal['priorite'][$dd];
}


$trinitatis=$pentecostes+$semaine;
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

$corporis=$trinitatis+4*$jour;
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

$date_courante=mktime(12,0,0,1,1,$m);
$dernier_jour=mktime(12,0,0,12,31,$m);
$lit=array("A","b","c","d","e","f","g");
$i=0;
//print_r($temporal);


$row = 1;
$handle = fopen("propres_r/sanctoral/sanctoral.csv", "r");
//print"<table>";
while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
//print"<tr>";
    $num = count($data);
    //echo "<p> $num fields in line $row: <br /></p>\n";
    $row++;
    /*
    for ($c=0; $c < $num; $c++) {
    //print"<td>$data[$c] </td>";
    }
    */
//    print"</tr>";

    if($data[4]!="") {
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
    		$sanctoral['priorite']['20050404']=$data[7];;
			}
			if ($m=="2007") {
				$sanctoral['intitule']['20070326']=$data[4];
    		$sanctoral['rang']['20070326']=$data[5];
    		$sanctoral['couleur']['20070326']=$data[6];
    		$sanctoral['priorite']['20070326']=$data[7];;
			}
			if ($m=="2008") {
				$sanctoral['intitule']['20080331']=$data[4];
    		$sanctoral['rang']['20080331']=$data[5];
    		$sanctoral['couleur']['20080331']=$data[6];
    		$sanctoral['priorite']['20080331']=$data[7];;
			}
			if ($m=="2012") {
				$sanctoral['intitule']['20120326']=$data[4];
    		$sanctoral['rang']['20120326']=$data[5];
    		$sanctoral['couleur']['20120326']=$data[6];
    		$sanctoral['priorite']['20120326']=$data[7];;
			}
			if ($m=="2013") {
				$sanctoral['intitule']['20130408']=$data[4];
    		$sanctoral['rang']['20130408']=$data[5];
    		$sanctoral['couleur']['20130408']=$data[6];
    		$sanctoral['priorite']['20130408']=$data[7];;
			}
    	}



    }
}

/*
print"
<table>
<tr>
	<td><b>Date</b></td>
	<td><b>Lit.</b></td>
	<td><b>Feria</b></td>
	<td><b>Tempus</b></td>
	<td><b>Hebdomada</b></td>
	<td><b>Intitule</b></td>
	<td><b>Rang</b></td>
	<td><b>HP</b></td>
 </tr>
";

*/


//print"</table>";

//print "<br>sanctoral[priorite][20060122]=".$sanctoral['priorite'][20060122];
//print "<br>temporal[priorite][20060122]=".$temporal['priorite'][20060122];
//$aujourdhui=mktime();

	$m=@date("Y",$day);
    $date_courante=mktime(12,0,0,1,1,$m);
	$dernier_jour=mktime(12,0,0,12,31,$m);

while($date_courante <= $dernier_jour) {
    $vita="";
    $tempo="";
    $pV="";
    $priorite="";
	//print "boucle infinie ? <br>";
	$couleurs="";
	$d=date("Ymd", $date_courante);
	$f=date("w", $date_courante);
	//$feria=$feriae[$f];
	$date=date("Ymd", $date_courante);
	$intitule = $temporal['intitule'][$date];
	//$tempo=$temporal['temporal'][$date];
	if ($temporal['tempus'][$date]!="") $tempus=$temporal['tempus'][$date];
	if ($temporal['hebdomada'][$date]!="") $hebdomada=$temporal['hebdomada'][$date];
	if ($temporal['couleur'][$date]!="") $couleur=$temporal['couleur'][$date];
	if ($temporal['hp'][$date]!="") $hp=$temporal['hp'][$date];
	$rang=$temporal['rang'][$date];
	$priorite=$temporal['priorite'][$date];
	$tempo=$temporal['temporal'][$date];
	$pV=$temporal['1V'][$date];
	//$temporal['rang'][$dd]="Solemnitas";
	if(($sanctoral['priorite'][$date]!="")&&($temporal['priorite'][$date]!="")) { // conflit temporal / sanctoral
		if ($sanctoral['priorite'][$date]<$temporal['priorite'][$date]) {
			$intitule =$sanctoral['intitule'][$date];
			if($sanctoral['couleur'][$date]!="") $couleurs=$sanctoral['couleur'][$date];
			//else $couleur=$sanctoral['couleur'][$date];
			$rang=$sanctoral['rang'][$date];
			$vita=$sanctoral['vita'][$date];
			$priorite=$sanctoral['priorite'][$date];
			if($priorite<=5) $pV=1;

//echo $blah[0];


		}
		else {
			$intitule =$temporal['intitule'][$date];
			$tempo=$temporal['temporal'][$date];
			$pV=$temporal['1V'][$date];
			//$tempo=$temporal['temporal'][$date];
			//$couleur=$temporal['couleur'][$date];
		}
	}

	if(($sanctoral['intitule'][$date]!="")&&($temporal['intitule'][$date]=="")) {

			$intitule .=$sanctoral['intitule'][$date];
			if($sanctoral['couleur'][$date]!="") $couleurs=$sanctoral['couleur'][$date];
            $rang=$sanctoral['rang'][$date];
            $vita=$sanctoral['vita'][$date];
            $priorite=$sanctoral['priorite'][$date];
            if($priorite<=4) $pV=1;
            $propre=date("m",$date_courante).date("d",$date_courante);
			//print"propre : $propre <br>";
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

	/*
	print"<tr bgcolor='$coul'>
	<td>$d</td>
	<td>$lit[$i]</td>";
	*/
	$calendarium['couleur_template'][$d]=$couleur_template[$d];
	$calendarium['littera'][$d]=$lit[$i];
	//print"<br>$date_courante";
	//$todddd = date("F j, Y, g:i a",$date_courante);
	//print"| $todddd";
	//print"<td>$feria</td>";
	//$fer[$d]=$feria;

	//print"<td>$tempus</td>";
	$calendarium['tempus'][$d]=$tempus;
	//print"<td>$hebdomada</td>";
	$calendarium['hebdomada'][$d]=$hebdomada;
	//print"<td>$intitule</td>";
	$calendarium['intitule'][$d]=$intitule;
	//print"<td>$rang</td>";
	$calendarium['rang'][$d]=$rang;
	//print"<td>$hp</td>";
	$calendarium['hebdomada_psalterium'][$d]=$hp;
	//";
    $calendarium['vita'][$d]=$vita;
    $calendarium['temporal'][$d]=$tempo;
    if(!$priorite) $priorite=13;
    $calendarium['priorite'][$d]=$priorite;
    $calendarium['1V'][$d]=$pV;
    //$calendarium['propre'][$d]=$propre;

	$date_courante=$date_courante+$jour;
	$i++; if ($i==7) $i=0;
}

//$reponse[3]=array($littera,$temp,$hebd,$intit,$ran,$hebdomada_psalterium,$couleur_template);

$day=time();
$aujourdhui=@date("Ymd",$day);

//print"<br><b>$aujourdhui";
//if ($day=="") $day=time();
	$datelatin=date_latin($day);
	//print"$couleur_template[$aujourdhui]|";
$reponse="$datelatin, ".$calendarium['tempus'][$aujourdhui].", <a href=\"http://www.scholasaintmaur.net/index.php?date=$aujourdhui\">".$calendarium['hebdomada'][$aujourdhui];
if($calendarium['intitule'][$aujourdhui]) $reponse.= ", ".$calendarium['intitule'][$aujourdhui];
if($calendarium['rang'][$aujourdhui]) $reponse.=", ".$calendarium['rang'][$aujourdhui];
$reponse.=".</a>";

$calendarium['datedaujourdhui']=$reponse;
//$reponse[0]=$couleur_template;

return $calendarium;
}

?>
