<?php 
// Chargement automatique des classes
function chargerClasse ($classe) {
	require $classe.'.php';
}
spl_autoload_register('chargerClasse');
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
        			echo "$('.invitatoire').show();";
                    echo "$('.verset-intro').hide();";
                    echo "$('.latin .ordo').addClass('red').show().text('Ad Laudes Matutinas.');";
        			echo "$('.francais .ordo').addClass('red').show().text('Aux Laudes.');";
        			break;
        		case "laudes":
        			echo "$('.invitatoire').hide();";
        			print "
					$('.latin .verset-intro').show()
					$('<p>').appendTo('.latin .verset-intro').text('Deus in adiutorium meum intende');
					var premierP = $('.latin .verset-intro p:first');
					$('<span>').addClass('red').prependTo(premierP).text('R. ');
                	$('<p>').appendTo('.latin .verset-intro').text('Domine, ad adiuvandum me festina');
					var secondP = premierP.next();
					$('<span>').addClass('red').prependTo(secondP).text('V. ');
            		$('<p>').appendTo('.latin .verset-intro').text('Gloria Patri et Filio et Spiritui Sancto,');
					$('<p>').appendTo('.latin .verset-intro').text('Sicut erat in pricipio et nunc et semper,');
					$('<p>').appendTo('.latin .verset-intro').text('Et in s&aelig;cula s&aelig;culorum. Amen.');
					
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
        			
        			print "$('.ant11').show();";
        			print "$('<p>').appendTo('.latin .ant11').text(\"Antiphona 1\");";
        			print "$('<p>').appendTo('.francais .ant11').text(\"Antienne 1\");";
        			print "$('<span>').addClass('red').prependTo('.ant11 p').text('Ant. 1 : ');";
        			print "$('.ant12').show();";
        			print "$('<p>').appendTo('.latin .ant12').text(\"Antiphona 1\");";
        			print "$('<p>').appendTo('.francais .ant12').text(\"Antienne 1\");";
        			print "$('<span>').addClass('red').prependTo('.ant12 p').text('Ant. : ');";
        			break;
        		case "vepres":
        			echo "$('.invitatoire').hide();";
                    print "
					$('.latin .verset-intro').show()
					$('<p>').appendTo('.latin .verset-intro').text('Deus in adiutorium meum intende');
					var premierP = $('.latin .verset-intro p:first');
					$('<span>').addClass('red').prependTo(premierP).text('R. ');
                	$('<p>').appendTo('.latin .verset-intro').text('Domine, ad adiuvandum me festina');
					var secondP = premierP.next();
					$('<span>').addClass('red').prependTo(secondP).text('V. ');
            		$('<p>').appendTo('.latin .verset-intro').text('Gloria Patri et Filio et Spiritui Sancto,');
					$('<p>').appendTo('.latin .verset-intro').text('Sicut erat in pricipio et nunc et semper,');
					$('<p>').appendTo('.latin .verset-intro').text('Et in s&aelig;cula s&aelig;culorum. Amen.');
					
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
                    echo "$('.latin .ordo').addClass('red').show().text('Ad Vesperas.');";
        			echo "$('.francais .ordo').addClass('red').show().text('Aux Vêpres.');";
        			break;
        		case "complies":
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
                default:
                    echo "$('.verset-intro').hide();";
                    echo "$('.invitatoire').hide();";
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
		<li><a href=?office=laudes-invit><div class="item">Laudes (avec invitatoire)</div></a></li>
		<li><a href=?office=laudes><div class="item">Laudes (sans invitatoire)</div></a></li>
		<li><a href=?office=tierce><div class="item">Tierce</div></a></li>
		<li><a href=?office=sexte><div class="item">Sexte</div></a></li>
		<li><a href=?office=none><div class="item">None</div></a></li>
		<li><a href=?office=vepres><div class="item">V&ecirc;pres</div></a></li>
		<li><a href=?office=complies><div class="item">Complies</div></a></li>
	</ul>
</div>

    
    <!-- Affichage de l'office au centre -->
<div class="office">
	<div class="icon-menu">
        <i class="fa fa-bars"></i>
        Menu
    </div>
	
	<div class="latin">
		<div class="ordo"></div>
        <div class="verset-intro"></div>
        <div class="invitatoire"></div>
		<div class="examen-conscience"></div>
		<div class="hymne"></div>
		<div class="ant11"></div>
		<div class="psaume1"></div>
		<div class="gloriapatri1"></div>
		<div class="ant12"></div>
		<div class="ant21"></div>
		<div class="psaume2"></div>
		<div class="gloriapatri2"></div>
		<div class="ant22"></div>
		<div class="ant31"></div>
		<div class="psaume3"></div>
		<div class="gloriapatri3"></div>
		<div class="ant32"></div>
		<div class="lectio"></div>
		<div class="repons"></div>
		<div class="antEv"></div>
		<div class="cantiqueEv"></div>
		<div class="gloriapatriEv"></div>
		<div class="antEv"></div>
		<div class="preces"></div>
		<div class="pater"></div>
		<div class="benedicion"></div>
		<div class="acclamation"></div>
		<div class="antMariale"></div>
	</div>
	<div class="francais">
		<div class="ordo"></div>
        <div class="verset-intro"></div>
        <div class="invitatoire"></div>
		<div class="examen-conscience"></div>
		<div class="hymne"></div>
		<div class="ant11"></div>
		<div class="psaume1"></div>
		<div class="gloriapatri1"></div>
		<div class="ant12"></div>
		<div class="ant21"></div>
		<div class="psaume2"></div>
		<div class="gloriapatri2"></div>
		<div class="ant22"></div>
		<div class="ant31"></div>
		<div class="psaume3"></div>
		<div class="gloriapatri3"></div>
		<div class="ant32"></div>
		<div class="lectio"></div>
		<div class="repons"></div>
		<div class="antEv"></div>
		<div class="cantiqueEv"></div>
		<div class="gloriapatriEv"></div>
		<div class="antEv"></div>
		<div class="preces"></div>
		<div class="pater"></div>
		<div class="benedicion"></div>
		<div class="acclamation"></div>
		<div class="antMariale"></div>
	</div>
</div>

</body>
</html>