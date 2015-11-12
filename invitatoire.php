<?php



//fonction de lecture et de mis en forme du psaume invitatoire

function psaume_invitatoire($ref,$ant_lat,$ant_fr) {

$row = 0;
$fp = fopen ("calendrier/liturgia/$ref.csv","r");
    while ($data = fgetcsv ($fp, 1000, ";")) {
        switch ($row){

            case 0:
                if ($data[0]!="&nbsp;") {
                    $latin="<b><center><font color=red>$data[0]</font></b></center>";
                    $francais="<b><center><font color=red>$data[1]</b></font></center>";
                }

                break;



            case 1:
                if ($data[0]!="&nbsp;") {
                    $latin="<center><font color=red>$data[0]</font></center>";
                    $francais="<center><font color=red>$data[1]</font></center>";
                }

                break;



            case 2:

                if ($data[0]!="&nbsp;") {
                    $latin="<center><i>$data[0]</i></center>";
                    $francais="<center><i>$data[1]</i></center>";
                }

                break;



            case 3:

                if($data[0]=="antiphona"){
                   $latin="V/. ".$ant_lat;
                   $francais="V/. ".$ant_fr;
                }

                break;



            default:

                switch ($data[0]){

                    case "antiphona":
                        $latin="R/. ".$ant_lat;
                        $francais="R/. ".$ant_fr;
                        break;

                    default :
                        $latin=$data[0];
                        $francais=$data[1];
                        break;
                }

                break;

        }

   //$num = count ($data);

   //print "<p> $num fields in line $row: <br>\n";

      $psaume_invitatoire .="
      
    <tr>
    <td id=\"colgauche\">$latin</td>
    <td id=\"coldroite\">$francais</td>
    </tr>";
      $row++;
    }
    //$psaume_invitatoire.="</table>";
    fclose ($fp);
    return $psaume_invitatoire;

}





/// ici le code pour l'invitatoire



function invitatoire($jour,$calendarium,$my) {

/*

if(!$my->email) {
    print"<center><i>Le textes des offices latin/français ne sont disponibles que pour les utilisateurs enregistrés.</i></center>";
    return;
}
*/



$jours_l = array("Dominica, post II Vesperas, ad ", "Feria secunda, ad ","Feria tertia, ad ","Feria quarta, ad ","Feria quinta, ad ","Feria sexta, ad ", "Dominica, post I Vesperas, ad ");
$jours_fr=array("Le Dimanche après les IIes Vêpres, aux  ","Le Lundi aux ","Le Mardi aux ","Le Mercredi aux ","Le Jeudi aux ","Le Vendredi aux ","Le Dimanche, après les Ières Vêpres, aux ");

$anno=substr($jour,0,4);
$mense=substr($jour,4,2);
$die=substr($jour,6,2);
$day=mktime(12,0,0,$mense,$die,$anno);



$jrdelasemaine=date("w",$day);

$date_fr=$jours_fr[$jrdelasemaine];

$date_l=$jours_l[$jrdelasemaine];

$fp = fopen ("calendrier/liturgia/jours.csv","r");

    while ($data = fgetcsv ($fp, 1000, ";")) {

        $id=$data[0];$latin=$data[1];$francais=$data[2];

        $jo[$id]['latin']=$latin;

        $jo[$id]['francais']=$francais;

        $row++;

    }

    fclose($fp);

$jrdelasemaine++; // pour avoir dimanche=1 etc...

$spsautier=$calendarium['hebdomada_psalterium'][$jour];



$tomorow = $day+60*60*24;

$demain=date("Ymd",$tomorow);



$ant_invit_lat=null;

$ant_invit_fr=null;



$var=null;

$tem=$calendarium['tempus'][$jour];

switch ($tem) {

    case "Tempus Adventus" :

        $psautier="adven";

        $q="adven_".$spsautier;

        break;

    case "Tempus Nativitatis" :

        $psautier="noel";

        $q="noel_".$spsautier;

        break;

    case "Tempus per annum" :

        $psautier="perannum";

        $q="perannum_".$spsautier;

        break;

    case "Tempus Quadragesimae" :

        $psautier="quadragesimae";

        $q="quadragesima";

        switch ($calendarium['hebdomada'][$jour]){

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

        switch ($calendarium['hebdomada'][$jour]){

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

        print"<br><i>Cet office n'est pas encore complètement disponible. Merci de bien vouloir patienter. <a href=\"nous_contacter./index.php\">Vous pouvez nous aider à compléter ce travail.</a></i>";

        return;

        break;

}



// lecture du fichier du jour :

$fp = fopen ("calendrier/liturgia/psautier/".$q.$jrdelasemaine.".csv","r");

while ($data = fgetcsv ($fp, 1000, ";")) {

    $id=$data[0];$latin=$data[1];$francais=$data[2];

    $var[$id]['latin']=$latin;

    $var[$id]['francais']=$francais;

    $row++;

}

fclose($fp);



//Lecture du fichier des psaumes

$fp = fopen ("calendrier/liturgia/psautier/psautier_".$spsautier.$jrdelasemaine.".csv","r");

    while ($data = fgetcsv ($fp, 1000, ";")) {

        $id=$data[0];$ref=$data[1];

        $reference[$id]=$ref;

        $row++;

    }

fclose($fp);

if ($reference['ps_invit']) $psaume_invit=$reference['ps_invit'];

else $psaume_invit=ps94_inv;





//Lecture du fichier du propre si le jour a un rang

if($calendarium['rang'][$jour]) {

    $prop=$mense.$die;

    //print"<br>prop = $prop";

    $fp = @fopen ("calendrier/liturgia/psautier/".$prop.".csv","r");

    while ($data = @fgetcsv ($fp, 1000, ";")) {

        $id=$data[0];

        $propre[$id]['latin']=$data[1];

        $propre[$id]['francais']=$data[2];

        $row++;

    }

    @fclose($fp);



    if($propre['ant_invit']['latin']) $ant_invit_lat=$propre['ant_invit']['latin'];

    if($propre['ant_invit']['francais']) $ant_invit_fr=$propre['ant_invit']['francais'];

}



//Lecture du fichier du temporal si le jour a un temporal

if($calendarium['temporal'][$jour]==$calendarium['intitule'][$jour]) {

    $tempo=$calendarium['temporal'][$jour];

    $fp = @fopen ("calendrier/liturgia/psautier/".$tempo.".csv","r");

    //$fp = fopen ("calendrier/liturgia/psautier/".$prop.".csv","r");

    while ($data = @fgetcsv ($fp, 1000, ";")) {

        $id=$data[0];

        $temp[$id]['latin']=$data[1];

        $temp[$id]['francais']=$data[2];

        $row++;

    }

    $ant_invit_lat=$temp['ant_invit']['latin'];

    $ant_invit_fr=$temp['ant_invit']['francais'];

}



$row = 0;

$fp = fopen ("offices_r/invitatoire.csv","r");

while ($data = fgetcsv ($fp, 1000, ";")) {

    $latin=$data[0];$francais=$data[1];

    $comp[$row]['latin']=$latin;

    $comp[$row]['francais']=$francais;

    $row++;

}

$max=$row;



for($row=0;$row<$max;$row++){

    $lat=$comp[$row]['latin'];

    $fr=$comp[$row]['francais'];



    switch ($lat) {

        /*case "#JOUR":

            //$invitatoire.="<tr><td width=49%><center><font color=red><b>$date_l Ad Invitatorium</b></font></center></td>";

            //$invitatoire.="<td width=49%><b><center><font color=red><b>$date_fr à l'Invitatoire</b></font></center></td></tr>";

            //$invitatoire.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";



            $pr_lat=$propre['jour']['latin'];

            if($pr_lat){

                $invitatoire.="<tr><td width=49%><center><b>$pr_lat</b></center></td>";

                $pr_fr=$propre['jour']['francais'];

                $invitatoire.="<td width=49%><center><b>$pr_fr</b></center></td></tr>";

                $intitule_lat=$propre['intitule']['latin'];

                $intitule_fr=$propre['intitule']['francais'];

                $invitatoire.="<tr><td width=49%><center><b> $intitule_lat</b></center></td><td width=49%><center><b>$intitule_fr</b></center></td></tr>";

                $rang_lat=$propre['rang']['latin'];

                $rang_fr=$propre['rang']['francais'];

                $invitatoire.="<tr><td width=49%><center><font color=red> $rang_lat</font></center></td><td width=49%><center><font color=red>$rang_fr</font></center></td></tr>";

                $invitatoire.="<tr><td width=49%><center><font color=red><b>Ad Invitatorium</b></font></center></td>";

                $invitatoire.="<td width=49%><b><center><font color=red><b>A l'Invitatoire</b></font></center></td></tr>";

            }

            else {

                $invitatoire.="<tr><td width=49%><center><font color=red><b>$date_l ad Invitatorium</b></font></center></td>";

                $invitatoire.="<td width=49%><b><center><font color=red><b>$date_fr à l'Invitatoire</b></font></center></td></tr>";

            }

            break; *///fin du case #JOUR



        case "#ANT_INVIT*":

            if (!$ant_invit_lat) {

                $ant_invit_lat=$var['ant_invit']['latin'];

                $ant_invit_fr=$var['ant_invit']['francais'];

            }

            break; //fin case #ANT_INVIT*



        case "#PS_INVIT":

            $invitatoire.=psaume_invitatoire($psaume_invit,$ant_invit_lat,$ant_invit_fr);

            break; //fin case #PS_INVIT



        case "#ANT_INVIT":

            $lat="R/. ".$ant_invit_lat;

            $fr="R/. ".$ant_invit_fr;

             $invitatoire.="

    <tr>

    <td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";

            break; //fin case #ANT_INVIT



        default :

             $invitatoire.="
    <tr>
    <td id=\"colgauche\">$lat</td><td id=\"coldroite\">$fr</td></tr>";
            break; //fin default
    } // fin switch $lat
} // fin boucle for
$invitatoire= rougis_verset ($invitatoire);
return $invitatoire;
}

?>
