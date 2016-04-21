<?php 
// Chargement automatique des classes
/*
function chargerClasse ($classe) {
	require './romain'.$classe.'.php';
}
spl_autoload_register('chargerClasse');
*/

require './romain/Office.php';
require './romain/GestionOffice.php';

// Récupération de la date demandée ou utilisation de la date courante 
if ($_GET['date']) { $date = $_GET['date']; }
else {
	$tfc=time();
	$date=date("Ymd",$tfc);
}

// Création de l'objet de gestion des offices et initialisation des tableaux
$divinumOfficium = new GestionOffice();
$divinumOfficium->setCalendarium($date);
$divinumOfficium->initialisationSources($date);

$officeCourant = new Office();
$officeCourant->setTypeOffice($_GET['office']);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Insert title here</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400;300' rel='stylesheet' type='text/css'>
	<link type="text/css" rel="stylesheet" href="CSS/stylesheet.css" />
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script>
	var main = function() {
		$('.icon-menu').click(function(){
            $('.menu').animate({
                left : "0px"
            },200);
            $('body').animate({
                left : "285px"
            },200);
        });
        $('.icon-close').click(function(){
            $('.menu').animate({
                left : "-285px"
            },200);
            $('body').animate({
                left : "0px"
            },200);
        });

        <?php
        	switch ($officeCourant->typeOffice) {
        		case "laudes-invit" :
        			$officeCourant->setInvitatoire(true);
        			echo "$('.invitatoire').show();\n";
                    echo "$('.verset-intro').hide();\n";
                    echo "$('.ordo .latin ').addClass('red').show().text('Ad Invitatorium.');\n";
        			echo "$('.ordo .francais').addClass('red').show().text('Invitatoire.');\n";
        			break;
        		case "laudes":
        			echo "$('.invitatoire').hide();\n";
        			//echo "$('.ordo .latin ').addClass('red').show().text('Ad Laudes Matutinas.');\n";
        			//echo "$('.ordo .francais').addClass('red').show().text('Aux Laudes.');\n";
        			$divinumOfficium->initialisationLaudes($officeCourant, $date);
        			$officeCourant->affiche();
        			break;
        		case "vepres":
        			echo "$('.invitatoire').hide();\n";
        			echo "$('.ordo .latin ').addClass('red').show().text('Ad Vesperas.');\n";
        			echo "$('.ordo .francais').addClass('red').show().text('Aux V&ecirc;pres.');\n";
        			break;
        		case "complies":
        			echo "$('.invitatoire').hide();\n";
        			echo "$('.ordo .latin ').addClass('red').show().text('Ad Completorim.');\n";
        			echo "$('.ordo .francais').addClass('red').show().text('Aux Complies.');\n";
        			break;
                default:
                    echo "$('.verset-intro').hide();\n";
                    echo "$('.invitatoire').hide();\n";
        			echo "$('.ordo .latin ').addClass('red').show().text('Ad Media Hora.');\n";
        			echo "$('.ordo .francais').addClass('red').show().text('Au Milieu du Jour.');\n";
                    break;
        	}
        	echo "$('.ordo').show();\n";
        ?>
	};
	$(document).ready(main);
	</script>
</head>
<body>

    <!-- Menu sur le cote -->
<div class="menu">
	<div class="icon-close">
        <!-- <img src="http://s3.amazonaws.com/codecademy-content/courses/ltp2/img/uber/close.png"> -->
        Fermer
      </div>
	<ul>
		<li><a href=?office=laudes-invit><span class="item">Laudes (avec invitatoire)</span></a></li>
		<li><a href=?office=laudes><span class="item">Laudes (sans invitatoire)</span></a></li>
		<li><a href=?office=tierce><span class="item">Tierce</span></a></li>
		<li><a href=?office=sexte><span class="item">Sexte</span></a></li>
		<li><a href=?office=none><span class="item">None</span></a></li>
		<li><a href=?office=vepres><span class="item">V&ecirc;pres</span></a></li>
		<li><a href=?office=complies><span class="item">Complies</span></a></li>
	</ul>
</div>

    
    <!-- Affichage de l'office au centre -->
<div class="office">
	<div class="icon-menu">
        <i class="fa fa-bars"></i>
        Menu
    </div>
    
    <div class = "erreurs"></div>
	
	<div class="affichage">
		<div class="ordo"><div class="latin"></div><div class="francais"></div></div>
        <div class="verset-intro"><div class="latin"></div><div class="francais"></div></div>
        <div class="invitatoire"><div class="latin"></div><div class="francais"></div></div>
		<div class="examen-conscience"><div class="latin"></div><div class="francais"></div></div>
		<div class="hymne"><div class="latin"></div><div class="francais"></div></div>
		<div class="ant11"><div class="latin"></div><div class="francais"></div></div>
		<div class="psaume1"><div class="latin"></div><div class="francais"></div></div>
		<div class="gloriapatri1"><div class="latin"></div><div class="francais"></div></div>
		<div class="ant12"><div class="latin"></div><div class="francais"></div></div>
		<div class="ant21"><div class="latin"></div><div class="francais"></div></div>
		<div class="psaume2"><div class="latin"></div><div class="francais"></div></div>
		<div class="gloriapatri2"><div class="latin"></div><div class="francais"></div></div>
		<div class="ant22"><div class="latin"></div><div class="francais"></div></div>
		<div class="ant31"><div class="latin"></div><div class="francais"></div></div>
		<div class="psaume3"><div class="latin"></div><div class="francais"></div></div>
		<div class="gloriapatri3"><div class="latin"></div><div class="francais"></div></div>
		<div class="ant32"><div class="latin"></div><div class="francais"></div></div>
		<div class="lectio"><div class="latin"></div><div class="francais"></div></div>
		<div class="repons"><div class="latin"></div><div class="francais"></div></div>
		<div class="antEv"><div class="latin"></div><div class="francais"></div></div>
		<div class="cantiqueEv"><div class="latin"></div><div class="francais"></div></div>
		<div class="gloriapatriEv"><div class="latin"></div><div class="francais"></div></div>
		<div class="antEv"><div class="latin"></div><div class="francais"></div></div>
		<div class="preces"><div class="latin"></div><div class="francais"></div></div>
		<div class="pater"><div class="latin"></div><div class="francais"></div></div>
		<div class="oratio"><div class="latin"></div><div class="francais"></div></div>
		<div class="benediction"><div class="latin"></div><div class="francais"></div></div>
		<div class="acclamation"><div class="latin"></div><div class="francais"></div></div>
		<div class="antMariale"><div class="latin"></div><div class="francais"></div></div>
	</div>
</div>

</body>
</html>