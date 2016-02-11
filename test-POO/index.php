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
        			echo "$('.verset-intro').show();";
                    echo "$('.invitatoire').hide();";
        			break;
        		case "vepres":
        			echo "$('.verset-intro').show();";
                    echo "$('.invitatoire').hide();";
                    echo "$('.latin .ordo').addClass('red').show().text('Ad Vesperas.');";
        			echo "$('.francais .ordo').addClass('red').show().text('Aux Vêpres.');";
        			break;
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
        <div class="verset-intro">
            <p><span class="red">R.</span> Deus in adiutorium meum intende</p>
            <p><span class="red">V.</span> Domine, ad adiuvandum me festina</p>
            <p>Gloria Patri et Filio et Spiritui Sancto,</p>
            <p>Sicut erat in pricipio et nunc et semper,</p>
            <p>Et in s&aelig;cula s&aelig;culorum. Amen.</p>
        </div>
        <div class="invitatoire">
            <p><span class="red">R.</span> Domine, labia mea aperies,</p>
            <p><span class="red">V.</span> et os meum annuntiabit laudem tuam.</p>
        </div>
		<div class="examen-conscience"></div>
		<div class="hymne"></div>
		<div class="ant1"></div>
		<div class="psaume1"></div>
		<div class="gloriapatri1"></div>
		<div class="ant1"></div>
		<div class="ant2"></div>
		<div class="psaume2"></div>
		<div class="gloriapatri2"></div>
		<div class="ant2"></div>
		<div class="ant3"></div>
		<div class="psaume3"></div>
		<div class="gloriapatri3"></div>
		<div class="ant3"></div>
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
        <div class="verset-intro">
            <p><span class="red">R.</span> O Dieu, h&acirc;te-toi de me d&eacute;livrer !</p>
            <p><span class="red">V.</span> Seigneur, h&acirc;te-toi de me secourir !</p>
            <p>Gloire au P&egrave;re et au Fils et au Saint-Esprit,</p>
            <p>Comme il &eacute;tait au commencement, maintenant et toujours,</p>
            <p>Et dans les si&egrave;cles des si&egrave;cles. Amen.</p>
        </div>
        <div class="invitatoire">
            <p><span class="red">R.</span> Seigneur, ouvre mes l&egrave;vres,</p>
            <p><span class="red">V.</span> et ma bouche publiera ta louange.</p>
        </div>
		<div class="examen-conscience"></div>
		<div class="hymne"></div>
		<div class="ant1"></div>
		<div class="psaume1"></div>
		<div class="gloriapatri1"></div>
		<div class="ant1"></div>
		<div class="ant2"></div>
		<div class="psaume2"></div>
		<div class="gloriapatri2"></div>
		<div class="ant2"></div>
		<div class="ant3"></div>
		<div class="psaume3"></div>
		<div class="gloriapatri3"></div>
		<div class="ant3"></div>
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