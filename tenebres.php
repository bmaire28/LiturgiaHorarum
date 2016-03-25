<?php

function tenebres($jour,$date_l,$date_fr,$var,$propre,$temp) {

	/*
	 * Impression directe de l'Office
	 */
	
	$tenebres="<table>";
	
	$intitule_lat=nl2br($temp['intitule']['latin']);
	$intitule_fr=nl2br($temp['intitule']['francais']);
	$tenebres.="<tr><td style=\"width: 49%; text-align: center;\"><h1>Tenebr&aelig;</H1></td>\n";
	$tenebres.="<td style=\"width: 49%; text-align: center;\"><h1>Office des T&eacute;n&egrave;bres</h1></td></tr>\n";
	$tenebres.="<tr><td style=\"width: 49%; text-align: center;\"><h1>$intitule_lat</h1></td>\n";
	$tenebres.="<td style=\"width: 49%; text-align: center;\"><h1>$intitule_fr</h1></td></tr>\n";
	
	/*
	 * Invitatoire
	 */
	$tenebres.="<tr><td><h2>AD INVITATORIUM</h2></td>\n
					<td><h2>INVITATOIRE</h2></td></tr>\n";
	
	$tenebres.="<tr><td>V/. Domine, labia mea aperies.</td>\n
					<td>V/. Seigneur, ouvre mes l&egrave;vres,</td></tr>\n
	    		<tr><td>R/. Et os meum annuntiabit laudem tuam.</td>
	    			<td>R/. et ma bouche publiera ta louange.</td></tr>\n";	
	
	$antlat=nl2br($temp['invitatoire']['latin']);
	$antfr=nl2br($temp['invitatoire']['francais']);
	
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume("ps94_inv");
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	/*
	 * Hymne
	 */
	$tenebres.="<tr><td><h2>AD VIGILIAS</h2></td>\n
					<td><h2>VIGILES</h2></td></tr>\n";
	
	$hymne=$temp['hymne']['latin'];
	$tenebres.= hymne($hymne);
	
	/*
	 * 1er Nocturne
	 */
	
	$tenebres.="<tr><td><h2>IN I NOCTURNO</h2></td>\n
					<td><h2>Ier NOCTURNE</h2></td></tr>\n";
	// PS VIG1-1
	$antlat=nl2br($temp['ant11']['latin']);
	$antfr=nl2br($temp['ant11']['francais']);
	$psaume=$temp['ps11']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
		$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";

	// PS VIG1-2
	$antlat=nl2br($temp['ant12']['latin']);
	$antfr=nl2br($temp['ant12']['francais']);
	$psaume=$temp['ps12']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";

	// PS VIG1-3
	$antlat=nl2br($temp['ant13']['latin']);
	$antfr=nl2br($temp['ant13']['francais']);
	$psaume=$temp['ps13']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG1-4
	$antlat=nl2br($temp['ant14']['latin']);
	$antfr=nl2br($temp['ant14']['francais']);
	$psaume=$temp['ps14']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 4 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 4 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG1-5
	$antlat=nl2br($temp['ant15']['latin']);
	$antfr=nl2br($temp['ant15']['francais']);
	$psaume=$temp['ps15']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 5 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 5 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG1-6
	$antlat=nl2br($temp['ant16']['latin']);
	$antfr=nl2br($temp['ant16']['francais']);
	$psaume=$temp['ps16']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 6 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 6 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// verset 1
	$verslat=nl2br($temp['V_1']['latin']);
	$versfr=nl2br($temp['V_1']['francais']);
	$tenebres.="<tr><td><h2>Versus</h2></td>\n
				<td><h2>Verset</h2></td></tr>\n
	    		<tr><td>$verslat</td><td>$versfr</td></tr>\n
	    		<tr><td><h5>On garde le silence, le temps d'un Notre P&egrave;re.</h5></td>
	    		<td><h5>On garde le silence, le temps d'un Notre P&egrave;re.</h5></td></tr>\n";
	
	
	
	// Lectio 1
	$LB_matin=$temp['LB_1']['latin'];
	$tenebres.=lectiobrevis($LB_matin);
	
	// RB 1
	$rblat=nl2br($temp['RB_1']['latin']);
	$rbfr=nl2br($temp['RB_1']['francais']);
	$tenebres.="<tr><td><h2>Responsorium</h2></td>\n
					<td><h2>R&eacute;pons</h2></td></tr>\n
	    		<tr><td>$rblat</td><td>$rbfr</td></tr>\n";
	
	
	/*
	 * 2e Nocturne
	 */
	
	$tenebres.="<tr><td><h2>IN II NOCTURNO</h2></td>\n
					<td><h2>IIe NOCTURNE</h2></td></tr>\n";
	// PS VIG2-1
	$antlat=nl2br($temp['ant21']['latin']);
	$antfr=nl2br($temp['ant21']['francais']);
	$psaume=$temp['ps21']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG2-2
	$antlat=nl2br($temp['ant22']['latin']);
	$antfr=nl2br($temp['ant22']['francais']);
	$psaume=$temp['ps22']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG2-3
	$antlat=nl2br($temp['ant23']['latin']);
	$antfr=nl2br($temp['ant23']['francais']);
	$psaume=$temp['ps23']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG2-4
	$antlat=nl2br($temp['ant24']['latin']);
	$antfr=nl2br($temp['ant24']['francais']);
	$psaume=$temp['ps24']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 4 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 4 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG2-5
	$antlat=nl2br($temp['ant25']['latin']);
	$antfr=nl2br($temp['ant25']['francais']);
	$psaume=$temp['ps25']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 5 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 5 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS VIG2-6
	$antlat=nl2br($temp['ant26']['latin']);
	$antfr=nl2br($temp['ant26']['francais']);
	$psaume=$temp['ps26']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 6 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 6 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// verset 2
	$verslat=nl2br($temp['V_2']['latin']);
	$versfr=nl2br($temp['V_2']['francais']);
	$tenebres.="<tr><td><h2>Versus</h2></td>\n
				<td><h2>Verset</h2></td></tr>\n
	    		<tr><td>$verslat</td><td>$versfr</td></tr>\n
	    		<tr><td><h5>On garde le silence, le temps d'un Notre P&egrave;re.</h5></td>
	    		<td><h5>On garde le silence, le temps d'un Notre P&egrave;re.</h5></td></tr>\n";
	
	// Lectio 2
	$LB_matin=$temp['LB_2']['latin'];
	$tenebres.=lectiobrevis($LB_matin);
	
	// RB 2
	$rblat=nl2br($temp['RB_2']['latin']);
	$rbfr=nl2br($temp['RB_2']['francais']);
	$tenebres.="<tr><td><h2>Responsorium</h2></td>\n
					<td><h2>R&eacute;pons</h2></td></tr>\n
	    		<tr><td>$rblat</td><td>$rbfr</td></tr>\n";
	
	/*
	 * 3e Nocturne
	 * 3 cantique AT sous 1 antienne unique
	 */
	
	$tenebres.="<tr><td><h2>IN III NOCTURNO</h2></td>\n
					<td><h2>IIIe NOCTURNE</h2></td></tr>\n";
	//
	$antlat=nl2br($temp['ant31']['latin']);
	$antfr=nl2br($temp['ant31']['francais']);
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>\n";
	
	$psaume=$temp['ps31']['latin'];
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	
	$psaume=$temp['ps32']['latin'];
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	
	$psaume=$temp['ps33']['latin'];
	$tenebres.=psaume($psaume);
		$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// verset 3
	$verslat=nl2br($temp['V_3']['latin']);
	$versfr=nl2br($temp['V_3']['francais']);
	$tenebres.="<tr><td><h2>Versus</h2></td>\n
				<td><h2>Verset</h2></td></tr>\n
	    		<tr><td>$verslat</td><td>$versfr</td></tr>\n
	    		<tr><td><h5>On garde le silence, le temps d'un Notre P&egrave;re.</h5></td>
	    		<td><h5>On garde le silence, le temps d'un Notre P&egrave;re.</h5></td></tr>\n";
	
	// Lectio 3
	$LB_matin=$temp['LB_3']['latin'];
	$tenebres.=lectiobrevis($LB_matin);
	
	// RB 3
	$rblat=nl2br($temp['RB_3']['latin']);
	$rbfr=nl2br($temp['RB_3']['francais']);
	$tenebres.="<tr><td><h2>Responsorium</h2></td>\n
					<td><h2>R&eacute;pons</h2></td></tr>\n
	    		<tr><td>$rblat</td><td>$rbfr</td></tr>\n";
		
	/*
	 * Laudes
	 */
	$tenebres.="<tr><td><h2>AD LAUDES MATUTINAS</h2></td>\n
					<td><h2>AUX LAUDES</h2></td></tr>\n";
	
	// PS L-1
	$antlat=nl2br($temp['antl1']['latin']);
	$antfr=nl2br($temp['antl1']['francais']);
	$psaume='ps50';
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 1 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 1 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS L-2
	$antlat=nl2br($temp['antl2']['latin']);
	$antfr=nl2br($temp['antl2']['francais']);
	$psaume=$temp['psl2']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 2 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 2 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS L-3
	$antlat=nl2br($temp['antl3']['latin']);
	$antfr=nl2br($temp['antl3']['francais']);
	$psaume=$temp['psl3']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 3 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 3 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// PS L-4
	$antlat=nl2br($temp['antl4']['latin']);
	$antfr=nl2br($temp['antl4']['francais']);
	$psaume=$temp['psl4']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 4 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 4 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";

	// PS L-5
	$antlat=nl2br($temp['antl5']['latin']);
	$antfr=nl2br($temp['antl5']['francais']);
	$psaume=$temp['psl5']['latin'];
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. 5 </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. 5 </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// Lectio L
	$LB_matin=$temp['LB_matin']['latin'];
	$tenebres.=lectiobrevis($LB_matin);
	
	// RB 3
	$rblat=nl2br($temp['RB_matin']['latin']);
	$rbfr=nl2br($temp['RB_matin']['francais']);
	$tenebres.="<tr><td><h2>Responsorium</h2></td>\n
					<td><h2>R&eacute;pons</h2></td></tr>\n
	    		<tr><td>$rblat</td><td>$rbfr</td></tr>\n";
	
	// Benedictus
	$antlat=nl2br($temp['benedictus']['latin']);
	$antfr=nl2br($temp['benedictus']['francais']);
	$psaume='benedictus';
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	$tenebres.=psaume($psaume);
	$tenebres.="<tr><td>Gloria Patri, et F&iacute;lio, * et Spir&iacute;tui Sancto.</td>\n
					<td>Gloire au P&egrave;re, au Fils et au Saint Esprit.</td></tr>\n
	    		<tr><td>Sicut erat in principio, et nunc et semper * et in s&aelig;cula s&aelig;cul&oacute;rum. Amen.</td>
	    			<td>Comme il &eacute;tait au commencement, maintenant et toujours, et dans les si&egrave;cles des si&egrave;cles. Amen.</td></tr>\n";
	$tenebres.="<tr><td><p><span style=\"color:red\">Ant. </span>$antlat</p></td>\n
						<td><p><span style=\"color:red\">Ant. </span> $antfr</p></td></tr>\n";
	
	// Preces + Pater
	$tenebres.="<tr><td><h2>Acclamtio finalis</h2></td>\n
					<td><h2>Acclamations finales</h2></td></tr>\n";
	$tenebres.="<tr><td>V/. Kyrie eleison R/. Kyrie eleison</td>\n
					<td>V/. Seigneur, ayez piti&eacute; R/. Seigneur, ayez piti&eacute;</td></tr>\n";
	$tenebres.="<tr><td>V/. Christe eleison R/. Christe eleison</td>\n
					<td>V/. &Ocirc; Christ, ayez piti&eacute; R/. &Ocirc; Christ, ayez piti&eacute;</td></tr>\n";
	$tenebres.="<tr><td>V/. Kyrie eleison R/. Kyrie eleison</td>\n
					<td>V/. Seigneur, ayez piti&eacute; R/. Seigneur, ayez piti&eacute;</td></tr>\n";
	
	$tenebres.="<tr><td>V/. Pater noster, qui es in c&aelig;lis,</td><td>V/. Notre P&egravere, qui es aux Cieux,</td></tr>\n
			<tr><td>sanctific&eacute;tur nomen tuum: adv&eacute;niat regnum tuum:</td><td>que ton nom soit sanctifi&eacute;; que ton r&egrave;gne arrive;</td></tr>\n
			<tr><td>fiat vol&uacute;ntas tua, sicut in c&aelig;lo et in terra.</td><td>que ta volont&eacute; soit faite au Ciel comme sur la terre.</td></tr>\n
			<tr><td>Panem nostrum quotidi&aacute;num da nobis h&oacute;die:</td><td>Donne-nous aujourd'hui notre pain quotidien,</td></tr>\n
			 <tr><td>et dim&iacute;tte nobis d&eacute;bita nostra, sicut et nos dim&iacute;ttimus debit&oacute;ribus nostris:</td><td>et remets-nous nos dettes, comme nous les remettons nous-m&ecirc;mes &agrave; nos d&eacute;biteurs ;</td></tr>\n
			 <tr><td>et ne nos ind&uacute;cas in tentati&oacute;nem</td><td>et ne nous abandonne pas dans l'&eacute;preuve, </td></tr>
			<tr><td>R/. sed l&iacute;bera nos a malo.</td><td>R/. mais d&eacute;livre-nous du malin.</td></tr>\n";
	
	
	// Oraison
	$tenebres.="<tr><td><h2>Oratio</h2></td>\n
					<td><h2>Oraison</h2></td></tr>\n";
	$oratiolat=$temp['oratio']['latin'];
	$oratiofr=$temp['oratio']['francais'];
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
	$tenebres.="<tr><td>$oratiolat</td><td>$oratiofr</td></tr>";
	
	$tenebres.="<tr><td>V/. Benedicamus Domino.</td>\n
					<td>V/. B&eacute;nissons le Seigneur.</td></tr>\n
	    		<tr><td>R/. Deo gratias.</td>
	    			<td>R/. Nous rendos gr&acirc;ce &agrave; Dieu.</td></tr>\n";
	
	$tenebres.="</table>";
	$tenebres= rougis_verset ($tenebres);
	return $tenebres;
}

/*
 * Version du vendred saint selon FX Pons
 * 
 * - Ps invitatoire avec ant. Christum, Dei Fílium, qui suo nos redémit sánguine, veníte, adorémus. On la trouve dans Liber Hymarius, 1985.
(A noter ; autrefois, on supprimait aux Ténèbres le Domine labia mea aperies et les Gloria Patri des psaumes et des répons. Je sais que les Dominicains font encore aujourd'hui comme cela. Je ne suis pas certain qu'il faille les sauter dans une forme "ordinaire", puisqu'ils sont écrits notamment dans le lectionarium monasticum)
- Hymne Pange Lingua
- Ant. Astiterunt reges terrae + ps 2
- Ant. Diviserunt sibi + ps 21
- Ant. Inserrexerunt in me + ps 26
Leçon I : Incipit Liber Lamentationum. 1,1-14 + Répons In Monte Oliveti, (sur Gregofacsimil)
Leçon II + répons Tristis est
Leçon III + répons Ecce vidimus.
(A noter que ces leçons étaient autrefois aux Ténèbres du jeudi saint, et on du vendredi saint. En réalité, - et c'est à discuter, on considère aujourd'hui que le Triduum pascal commencçant réellement à la messe in Cena Domini, on ne chante des Ténèbres qu'à compter du vendredi...)
II° nocturne :
Ant Vim faciebant + ps 37
Ant. Confundantur + ps 39
Ant. Alieni + ps 53
Leçon IV : Ex Catechesibus sancti Ioannis Chrysostomi espiscopi. + Répons Tamquam ad latronem.
Leçon V + Tenebrae factae sunt
Leçon VI + Répons Animam meam
III° nocturne :
Ant. Ab insurgentibus + ps 58
Ant. Longe fecisti + ps 87
Ant. Captabunt + ps 93
C'est là qu'on pourrait mettre le début de l'Evangile "et reliqua", si on ne célébrait que les Vigiles. Mais comme on enchaîne avec les laudes, puisque ce sont des Ténèbres, le lectionnaire monastique propose S. Léon Le Grand (le voilà on le retrouve !) la première année et Rupert de Deutz la deuxième année, commentaire de S. Jean. L'ancien ordo mettait ici l'Epître aux Hébreux.
Leçon VII : Ex Sermonibus sancti Leonis Magni, (S40, 1, SC 74, 27-28). + Répons Tradidérunt.
Leçon VIII + répons Iesum tradidit.
Leçon IX + répons Caligaverunt.
Si on s'arrêtait aux Vigiles, on pourrait envisager ici de chanter l'Evangile. C'est vrai que ça pourrait avoir une certaine classe de le dialoguer, comme à l'office de la Passion, avec les trois voix : une basse poiur le Christ, une moyenne pour le narrrateur, une haute pour la "synagogue". Mais on enchaîne ensuite sur les laudes, sans Deus in adiutorium, sans hymne.
Ant. Proprio Filio suo + ps 50 (miserere mei Deus)
Ant. Anxiatus est in me + ps 142.
Ant. Ait latro ad latronem + ps 84
Ant. Dum conturbata fuerit + Cant. d'Habacuc.
Ant. Memento mei + ps 147
Leçon brève : Is 52, 13, 15.
Verset : Collocavit me in obscuris. Sicut mortuos in saeculi.
Ant. Posuerunt super caput eius + Benedictus.
Prières litaniques.
Répons Christus Factus est, à genoux.
Pater, tout bas.
Ps 50 (Miserere Mei).
Oratio : (sans Oremus) : Réspice, quæsumus, Dómine, super hanc famíliam tuam, pro qua Dóminus noster Iesus Christus non dubitávit mánibus tradi nocéntium et crucis subíre torméntum. Qui tecum.
 */
?>
