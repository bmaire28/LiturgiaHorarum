<?php

/// ici le code pour les complies
function complies($jour,$calendarium,$my) {


$var=null;
$tem=$calendarium['tempus'][$jour];
switch ($tem) {
    case "Tempus Adventus" :
        $psautier="adven";
        break;

    case "Tempus Nativitatis" :
        $psautier="noel";
        break;

    case "Tempus per annum" :
        $psautier="perannum";
        break;

    case "Tempus Quadragesimae" :
        $psautier="quadragesimae";
        break;

    case "Tempus passionis" :
        $psautier="hebdomada_sancta";
        break;

    case "Tempus Paschale" :
        $psautier="pascha";
        break;

    default :
        print"<br><i>Cet office n'est pas encore compl&egrave;tement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider &agrave; compl&eacute;ter ce travail.</a></i>";
        return;
        break;

}



$jours_l = array("Dominica, post II Vesperas, ad ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, post I Vesperas, ad ");
$jours_fr=array("Le Dimanche apr&egrave;s les IIes V&ecirc;pres, aux  ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche, apr&egrave;s les I&egrave;res V&ecirc;pres, aux ");



$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);

$jrdelasemaine=date("w",$day);
$date_fr=$jours_fr[$jrdelasemaine];
$date_l=$jours_l[$jrdelasemaine];


$jrdelasemaine++; // pour avoir dimanche=1 etc...
$spsautier=$calendarium['hebdomada_psalterium'][$jour];
$tomorow = $day+60*60*24;
$demain=date("Ymd",$tomorow);

if (($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($jrdelasemaine!=7)) {
    ////////////////////////////////////////
    /// il y a des "1ères Complies"  //////
    //////////////////////////////////////
	$fp = fopen ("propres_r/complies/comp_FVS.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
        $var[$id]['latin']=$data[1];
        $var[$id]['francais']=$data[2];
        $row++;
	}
	$LB_comp=null;
	$RB_comp=null;
	$pr_lat=null;
	$pr_fr=null;
	$intitule_lat=null;
	$intitule_fr=null;
	$rang_lat=null;
	$rang_fr=null;
	$preces=null;
	$ps2=1;
	$tempo=$calendarium['intitule'][$demain];
	$fp = fopen ("propres_r/temporal/".$tempo.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
        $temp[$id]['latin']=$data[1];
        $temp[$id]['francais']=$data[2];
        $row++;
    }
    fclose($fp);
    if($temp['intitule']['latin'])$intitule_lat=$temp['intitule']['latin'];
    if($temp['intitule']['francais'])$intitule_fr=$temp['intitule']['francais'];
    $rang_lat="Sollemnitas";
    $rang_fr="Solennit&eacute;";
    $complies_lat="Post I Vesperas, ad Completorium";
    $complies_fr="Apr&egrave;s les I&egrave;res V&ecirc;pres, aux Complies";
    $date_l = $intitule_lat."<br> Post I Vesperas, ad ";
    $date_fr = $intitule_fr."<br> Apr&egrave;s les I&egrave;res V&ecirc;pres, aux ";
}

if (($calendarium['1V'][$jour]==1)&&($calendarium['priorite'][$jour]<$calendarium['priorite'][$demain])&&($jrdelasemaine!=1)) {
    ////////////////////////////////////////
    /// il y a des "2ndes Complies"  //////
    //////////////////////////////////////
	$fp = fopen ("propres_r/complies/comp_FS.csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
        $var[$id]['latin']=$data[1];
        $var[$id]['francais']=$data[2];
        $row++;
	}
	$LB_comp=null;
	$RB_comp=null;
	$pr_lat=null;
	$pr_fr=null;
	$intitule_lat=null;
	$intitule_fr=null;
	$rang_lat=null;
	$rang_fr=null;
	$preces=null;
	$ps2=1;
	$tempo=$calendarium['intitule'][$jour];
	$fp = fopen ("propres_r/temporal/".$tempo.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];
        $temp[$id]['latin']=$data[1];
        $temp[$id]['francais']=$data[2];
        $row++;
	}
	fclose($fp);
	if($temp['intitule']['latin'])$intitule_lat=$temp['intitule']['latin'];
    if($temp['intitule']['francais'])$intitule_fr=$temp['intitule']['francais'];
    $rang_lat="Sollemnitas";
    $rang_fr="Solennit&eacute;";
    $date_l = $intitule_lat."<br> Post II Vesperas, ad ";
    $date_fr = $intitule_fr."<br> Apr&egrave;s les IIes V&ecirc;pres, aux ";
}


if(!$var){
	$fp = fopen ("propres_r/complies/comp_F".$jrdelasemaine.".csv","r");
	while ($data = fgetcsv ($fp, 1000, ";")) {
		$id=$data[0];$latin=$data[1];$francais=$data[2];
		$var[$id]['latin']=$latin;
		$var[$id]['francais']=$francais;
		$row++;
	}
	fclose($fp);
}

$row = 0;
$fp = fopen ("offices_r/complies.csv","r");
while ($data = fgetcsv ($fp, 1000, ";")) {
	$latin=$data[0];$francais=$data[1];
    $comp[$row]['latin']=$latin;
    $comp[$row]['francais']=$francais;
    $row++;
}

$max=$row;
$complies="<table>";
for($row=0;$row<$max;$row++){
	$lat=$comp[$row]['latin'];
	$fr=$comp[$row]['francais'];

    //Suppression de l'Alléluia en Carême et Semaine Sainte

    if(($tem=="Tempus Quadragesimae")&&($lat=="Allel�ia.")) {
        $lat="";
        $fr="";
    }

    if(($tem=="Tempus passionis")&&($lat=="Allel�ia.")) {
       $lat="";
       $fr="";
    }

    switch ($lat) {
        case "#JOUR":
            $complies.="<tr><td style=\"width: 49%; text-align: center;\"><h2>$date_l Completorium</h2></td>
            		<td style=\"width: 49%; text-align: center;\"><h2>$date_fr Complies</h2></td></tr>";
            if ($rang_lat){
            	$complies.="<tr><td style=\"width: 49%; text-align: center;\"><h3>$rang_lat</h3></td>
            		<td style=\"width: 49%; text-align: center;\"><h3>$rang_fr</h3></td></tr>";
            }            
            break; //fin du case #JOUR

        case "#HYMNUS":
        	switch ($tem) {
                case "Tempus Paschale":
                    $complies.=hymne("hy_Iesu, redémptor");
                    break;
                
                case "Tempus Quadragesimae":
                case "Tempus per annum":
                	switch ($calendarium['hebdomada_psalterium'][$jour]) {
                        case 1:
                        case 3:
                            $complies.=hymne("hy_Te lucis");
                            break;
                        case 2:
                        case 4:
                        	$complies.=hymne("hy_Christe, qui, splendor");
                            break;
                    }
                    break;
                
                case "Tempus Adventus":
                    $seizedec=mktime(12,0,0,12,16,$anno);
                    if($day<=$seizedec) {
                        $complies.=hymne("hy_Te lucis");
                    }
                    else{
                        $complies.=hymne("hy_Christe, qui, splendor");
                    }
                    break;

                case "Tempus Nativitatis":
                    $sixjanv=mktime(12,0,0,1,6,$anno);
                    if($mense=="12"){
                       $annosuivante=$anno+1;
                        $sixjanv=mktime(12,0,0,1,6,$annosuivante);
                    }
                    if($day<=$sixjanv) {
                        $complies.=hymne("hy_Te lucis");
                    }
                    else{
                        $complies.=hymne("hy_Christe, qui, splendor");
                    }
                    break;

            } //fin du switch $tem
            break; //fin du case #HYMNUS

    case "#ANT1*":
        $antlat=$var['ant1']['latin'];
        $antfr=$var['ant1']['francais'];
        if($tem=="Tempus Paschale") {
        	$antlat="Allel&uacute;ia, allel&uacute;ia, allel&uacute;ia.";
            $antfr="All&eacute;luia, all&eacute;luia, all&eacute;luia.";
        }

       $complies.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
        break; //fin du case #ANT1*

    case "#PS1":
        $psaume=$var['ps1']['latin'];
        $complies.=psaume($psaume);
        break; //fin du case #PS1

    case "#ANT1":
        $antlat=$var['ant1']['latin'];
        $antfr=$var['ant1']['francais'];
        if($tem=="Tempus Paschale") {
        	$antlat="Allel&uacute;ia, allel&uacute;ia, allel&uacute;ia.";
            $antfr="All&eacute;luia, all&eacute;luia, all&eacute;luia.";

        }
       $complies.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>";
        break; //fin du case #ANT1

    case "#ANT2*":
        $antlat=$var['ant2']['latin'];
        $antfr=$var['ant2']['francais'];
        if ($antlat=="") {
            $ps2=0;
            $row++;
            $row++;
            $row++;
            $row++;
        }
        else {
            $ps2=1;
            if($tem=="Tempus Paschale") {
                $antlat="Allel&uacute;ia, allel&uacute;ia, allel&uacute;ia.";
            	$antfr="All&eacute;luia, all&eacute;luia, all&eacute;luia.";
            }
       $complies.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
        }
        break; //fin du case #ANT2*
    case  "#PS2":
        $psaume=$var['ps2']['latin'];
        if ($ps2==1) {$complies.=psaume($psaume);}
        break; //fin du case #PS2

    case "#ANT2":
        $antlat=$var['ant2']['latin'];
        $antfr=$var['ant2']['francais'];
        if ($ps2==1) {
            if($tem=="Tempus Paschale") {
                $antlat="Allel&uacute;ia, allel&uacute;ia, allel&uacute;ia.";
            	$antfr="All&eacute;luia, all&eacute;luia, all&eacute;luia.";
            }
       $complies.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>
				<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>";
        }
        break; //fin du case #ANT2

    case "#LB":
       $lectiobrevis=$var['LB_comp']['latin'];
       $complies.=lectiobrevis($lectiobrevis);
        break; //fin du case #LB

    case "#RB":
        if($tem=="Tempus Paschale"){
            $rblat=nl2br($var['RB_comp_TP']['latin']);
            $rbfr=nl2br($var['RB_comp_TP']['francais']);
        }
        else {
        $rblat=nl2br($var['RB_comp']['latin']);
        $rbfr=nl2br($var['RB_comp']['francais']);
        }
        $complies.="<tr><td><h2>Responsorium Breve</h2></td>
        		<td><h2>R&eacute;pons bref</h2></td></tr>
        		<tr><td>$rblat</td><td>$rbfr</td></tr>";
        break; //fin du case #RB

    case "#ANT_NUNCD":
        $magniflat="Salva nos, D&oacute;mine, vigil&aacute;ntes, cust&oacute;di nos dormi&eacute;ntes, ut vigil&eacute;mus cum Christo et requiesc&aacute;mus in pace." ;
        $magniffr="Sauve nous, Seigneur, quand nous veillons, garde nous quand nous dormons, et nous veillerons avec le Messie et nous reposerons en paix.";
        if($tem=="Tempus Paschale") {
            $magniflat.=" allel&uacute;ia." ;
            $magniffr.=" all&eacute;luia." ;
        }
        $complies.="<tr><td><p><span style=\"color:red\">Ant. </span>$magniflat</p></td>
        		<td><p><span style=\"color:red\">Ant. </span> $magniffr</p></td></tr>";
        break; //fin du case #ANT_NUNCD
        
    case "#NUNCDIMITTIS":
        $complies.=psaume("nuncdimittis");
        break; //fin du case #NUNCDIMITTIS
        
    case "#ORATIO":
        if (!$oratiolat) {
            $oratiolat=$var['oratio_vesperas']['latin'];
            $oratiofr=$var['oratio_vesperas']['francais'];
        }

        if ($calendarium['hebdomada'][$jour]=="Infra octavam paschae"){
            $oratiolat="Vox nostra te, D&oacute;mine, hum&iacute;liter deprec&eacute;tur, ut, dom&oacute;nic&aelig; resurrecti&oacute;nis hac die myst&eacute;rio celebr&aacute;to, in pace tua sec&uacute;ri a malis &oacute;mnibus quiesc&aacute;mus, et in tua resurg&aacute;mus laude gaud&eacute;ntes. Per Christum D&oacute;minum nostrum.";
            $oratiofr="Notre voix te supplie humblement, Seigneur. Nous avons c&eacute;l&eacute;br&eacute; aujourd'hui le myst&egrave;re de la r&eacute;surrection du Seigneur : fais-nous reposer dans ta paix &agrave; l'abri de tout mal, et nous relever pour chanter joyeusement ta louange. Par le Christ notre Seigneur.";
            }

        $complies.="<tr><td>$oratiolat</td><td>$oratiofr</td></tr>";
        break; //fin du case #ORATIO

    case "#ANT_MARIALE":
        $ant_marie="";
        switch($tem){
            case "Tempus Paschale":
               $ant_marie="ant_regina caeli";
                
                break;

            case "Tempus Quadragesimae":
                $ant_marie="ant_ave regina";
               
                break;
            case "Tempus passionis":
                $ant_marie="ant_ave regina";
                

                break;
            case "Tempus Nativitatis":
                $ant_marie="ant_alma redemtoris";
                
                break;
            case "Tempus Adventus":
                $ant_marie="ant_alma redemtoris";
               
                break;

            case "Tempus per annum":{
                $deuxfev=mktime(12,0,0,2,2,$anno);
                

                if (($mense=="01") or ($mense=="02") or ($mense=="03")){
                    $ant_marie="ant_ave regina";
                    
                }
                elseif($tempo=="IN ASSUMPTIONE B. MARIAE VIRGINIS") {
                    $ant_marie="ant_ave regina";
                    
                }
                else {
                  $ant_marie="ant_salve regina";
                    
                }
            }
        }

        if(($calendarium['1V'][$demain]==1)&&($calendarium['priorite'][$jour]>$calendarium['priorite'][$demain])&&($jrdelasemaine!=7)){
            $ant_marie="ant_sub tuum";
        }
        $complies.=hymne($ant_marie);
        break; //fin du case #ANT_MARIALE

    default :
         $complies.="<tr><td>$lat</td><td>$fr</td></tr>";
        break; //fin default
    } // fin switch $lat
} // fin boucle for

$complies.="</table>";
$complies= rougis_verset ($complies);

return $complies;
}
?>