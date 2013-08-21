<table class="listing" cellspacing="0">
	<tr style="background-color:#CDCDCD">
		<td><b>Laborat&oacute;rio</b></td>
		<td><?php echo($lab['Laboratory']['name'])?></td>
	</tr>
	<tr>
		<td><b>N&uacute;mero de comuptadores</b></td>
		<td><?php echo($lab['Laboratory']['number_computers'])?></td>
	</tr>
	<tr style="background-color:#CDCDCD">
		<td colspan="2"><b>Softwares</b></td>
	</tr>

	<?php
	$index = 0;
	foreach($softwares as $s){
		echo("<tr class=");
		echo( $index % 2 == 0 ? 'list-line-odd':'list-line-even');
		echo(">");
		echo ("<td>");
		echo ($s['Software']['name']);
		echo ("</td>");
		echo ("<td>");
		echo ($s['Software']['active'] == 1 ? 'Disponível' : 'Indisponível');
		echo ("</td>");
		$index++;
	}

	echo ("</tr>");
?>
</table>
