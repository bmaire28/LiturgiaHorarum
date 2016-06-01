<?php
// PHP permanent URL redirection
$rite=$_GET['rite'];
if ($rite=="") $rite="romain";
if ($rite=="romain") {
	include 'index_r.php';
}

?>