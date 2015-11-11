<?php
print"
<SCRIPT language=\"javascript\">
    function popup(page,nom,option) {
       window.open(page,nom,option);
    }
  </SCRIPT>

";


print"<tr><td>Machin</td><td>Bidule</td>
	<td><a href=\"javascript:popup('basique.php', '', 'resizable=no, location=no, width=200, height=100, menubar=no, status=no, scrollbars=no, menubar=no')\">ref.</a></td></tr>";
?>
