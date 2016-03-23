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

//$divinumOfficium = new GestionOffice();

$laudes = new Office();
$laudes->setTypeOffice('laudes');
$laudes->setInvitatoire(false);
$laudes->setHymne('hymne');
$laudes->setAnt1('Antiphona 1', 'Antienne 1');
$laudes->setPs1('ps1');
$laudes->setAnt2('Antiphona 2', 'Antienne 2');
$laudes->setPs2('ps2');
$laudes->setAnt3('Antiphona 3', 'Antienne 3');
$laudes->setPs3('ps3');
$laudes->setLectio('LB_lectio');
$laudes->setRepons('Responsio Brevis', 'Répons Bref');
$laudes->setAntEv('Antiphona Ev', 'Antienne Ev');
$laudes->setPreces('precesI');
$laudes->setOratio('Oratio', 'Oraison');


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
        	switch ($_GET['office']) {
        		case "laudes-invit" :
        			echo "$('.invitatoire').show();\n";
                    echo "$('.verset-intro').hide();\n";
                    echo "$('.latin .ordo').addClass('red').show().text('Ad Laudes Matutinas.');\n";
        			echo "$('.francais .ordo').addClass('red').show().text('Aux Laudes.');\n";
        			break;
        		case "laudes":
        			echo "$('.invitatoire').hide();\n";
        			$laudes->affiche();
        			break;
        		case "vepres":
        			echo "$('.invitatoire').hide();\n";
                    print "
					$('.latin .verset-intro').show();\n
					$('<p>').appendTo('.latin .verset-intro').text('Deus in adiutorium meum intende');\n
					var premierP = $('.latin .verset-intro p:first');
					$('<span>').addClass('red').prependTo(premierP).text('R. ');\n
                	$('<p>').appendTo('.latin .verset-intro').text('Domine, ad adiuvandum me festina');\n
					var secondP = premierP.next();
					$('<span>').addClass('red').prependTo(secondP).text('V. ');\n
            		$('<p>').appendTo('.latin .verset-intro').text('Gloria Patri et Filio et Spiritui Sancto,');\n
					$('<p>').appendTo('.latin .verset-intro').text('Sicut erat in pricipio et nunc et semper,');\n
					$('<p>').appendTo('.latin .verset-intro').text('Et in s&aelig;cula s&aelig;culorum. Amen.');\n
					
					$('.francais .verset-intro').show();\n
                    $('<p>').appendTo('.francais .verset-intro').text('O Dieu, hâte-toi de me délivrer !');\n
					var premierP = $('.francais .verset-intro p:first');
					$('<span>').addClass('red').prependTo(premierP).text('R. ');\n
                	$('<p>').appendTo('.francais .verset-intro').text('Seigneur, hâte-toi de me secourir !');\n
					var secondP = premierP.next();
					$('<span>').addClass('red').prependTo(secondP).text('V. ');\n
            		$('<p>').appendTo('.francais .verset-intro').text('Gloire au Père et au Fils et au Saint-Esprit,');\n
					$('<p>').appendTo('.francais .verset-intro').text('Comme il était au commencement, maintenant et toujours,');\n
					$('<p>').appendTo('.francais .verset-intro').text('Et dans les siècles des siècles. Amen.');\n
					";
                    echo "$('.latin .ordo').addClass('red').show().text('Ad Vesperas.');\n";
        			echo "$('.francais .ordo').addClass('red').show().text('Aux Vêpres.');\n";
        			break;
        		case "complies":
        			print "
					$('.latin .examen-conscience').show();\n
					$('<h2>').appendTo('.latin .examen-conscience').text('Conscientiæ discussio');\n
					$('<p>').appendTo('.latin .examen-conscience').text('Confíteor Deo omnipoténti et vobis, fratres, quia peccávi nimis cogitatióne, verbo, ópere et omissióne:');\n
					$('<h5>').appendTo('.latin .examen-conscience').text('et, percutientes sibi pectus, dicunt :');\n
					$('<p>').appendTo('.latin .examen-conscience').text('mea culpa, mea culpa, mea máxima culpa.');\n
					$('<h5>').appendTo('.latin .examen-conscience').text('Deinde prosequuntur:');\n
					$('<p>').appendTo('.latin .examen-conscience').text('Ideo precor beátam Maríam semper Vírginem, omnes Angelos et Sanctos, et vos, fratres, oráre pro me ad Dóminum Deum nostrum.');\n
					$('<p>').appendTo('.latin .examen-conscience').text('Misereátur nostri omnípotens Deus et, dimissís peccátis nostris, perdúcat nos ad vitam aetérnam.');\n
					var dernierP = $('.latin .examen-conscience p').last();\n
					$('<span>').addClass('red').prependTo(dernierP).text('V. ');\n
					$('<p>').appendTo('.latin .examen-conscience').text('Amen.');\n
					dernierP = $('.latin .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('R. ');\n
					
					$('.francais .examen-conscience').show();\n
					$('<h2>').appendTo('.francais .examen-conscience').text('Examen de conscience');\n
					$('<p>').appendTo('.francais .examen-conscience').text(\"Je confesse à Dieu tout puissant et à vous, mes frères, car j'ai péché par la pensée, la parole, les actes et par omission :\");\n
					$('<h5>').appendTo('.francais .examen-conscience').text('et, en se frappant la poitrine, on dit :');\n
					$('<p>').appendTo('.francais .examen-conscience').text('je suis coupable, je suis coupable, je suis grandement coupable.');\n
					$('<h5>').appendTo('.francais .examen-conscience').text('ensuite, on continue :');\n
					$('<p>').appendTo('.francais .examen-conscience').text(\"C'est pourquoi je supplie la bienheureuse Marie toujours Vierge, tous les Anges et les Saints, et vous, frères, de prier pour moi le Seigneur notre Dieu.\");\n
					$('<p>').appendTo('.francais .examen-conscience').text('Aie pitié de nous Dieu tout puissant et, nos péchés ayant été renvoyés, conduis-nous à la vie éternelle.');\n
					var dernierP = $('.francais .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('V. ');\n
					$('<p>').appendTo('.francais .examen-conscience').text('Amen.');\n
					dernierP = $('.francais .examen-conscience p').last();
					$('<span>').addClass('red').prependTo(dernierP).text('R. ');\n
						";
                default:
                    echo "$('.verset-intro').hide();\n";
                    echo "$('.invitatoire').hide();\n";
        			break;
        	} 
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