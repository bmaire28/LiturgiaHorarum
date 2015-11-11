<?

print"
<SCRIPT language=\"javascript\">
    function popup(page,nom,option) {
       w=window.open(page,nom,option);
    }
    function Fermer() {
       if (w.document) { w.close(); }
    }
  </SCRIPT>

";

$act=$_GET['act'];
$item=$_GET['item'];
$roww=$_GET['row'];
$mod=$_POST['mod'];

if(!$item) $item="ps39.csv";
//print"item = $item";
$fp = fopen("$item","r") or die("<br><b> ECHEC !</b>");
$row=0;
while ($data = fgetcsv ($fp, 1000, ";")) {
	//print"<br>$row $data[0]";
	    $tab[$item][$row]['latin']=$data[0];
	    $tab[$item][$row]['francais']=$data[1];
	    $row++;
}
fclose($fp);

if($act=="maj") {
	//print"mod =".$mod;
	$tab[$item][$roww]['francais']=stripslashes ( $mod );

	$row=0;
	while($tab[$item][$row]) {
		$content.="\"".$tab[$item][$row]['latin']."\"".";"."\"".$tab[$item][$row]['francais']."\""."\r\n";
		$row++;
	}
	$fp = fopen("$item","w") or die("<br><b> ECHEC !</b>");
	//print $content;
	fwrite($fp, $content, strlen($content));
	fclose($fp);

}

if($act=="edition") {
	$cont=$tab[$item][$roww]['francais'];
	print"<br>CONT[$item][$roww]['francais'] : ";
	print"<form action=\"?act=maj&item=$item&row=$roww\" method=post><TEXTAREA name=\"mod\" rows=4 cols=30>$cont</TEXTAREA>";
 	print"<br><input type=submit name=\"OK\" onClick='window.close()'>";
 	//
	exit();
}

$row=0;
print"<table>";
while($tab[$item][$row]) {
    //print"<br>$row";
	print"<tr><td>".$tab[$item][$row]['latin']."</td><td>".$tab[$item][$row]['francais']."</td>
	<td><a href=\"javascript:popup('?act=edition&item=$item&row=$row', '', 'resizable=yes, location=no, width=300, height=200, menubar=no, status=no, scrollbars=no, menubar=no')\" >ref.</a></td></tr>";
// javascript:popup('?act=edition&item=$item&row=$row', '', 'resizable=yes, location=no, width=300, height=200, menubar=no, status=no, scrollbars=no, menubar=no')
	$row++;
}


//    open(\"\",'popup','width=500,height=100,toolbar=no,scrollbars=auto,resizable=no')

print"</table>";
//fwrite($fp, $string, strlen($string));

?>
