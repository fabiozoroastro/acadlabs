<style>
<!--
body {
	background-color: #fff;
}

table.calendar-rel {
	border: solid 1px #000;
	width: 100%;
}

table.calendar-rel td {
	border: solid 1px #000;
	width: 100%;
}

td.cell-dark {
	background-color: #CCC;
	white-space: nowrap;
	text-align: center;
}
-->
</style>
<table class="listing" cellspacing="0">
	<tr style="background-color:#CDCDCD">
		<td style='white-space: nowrap;' width='20%'><b>Laborat&oacute;rio</b></td>
		<td style='text-align:left; font-weight:bold; color:#CC2222'>&nbsp;&nbsp;<?php echo($lab['Laboratory']['name'])?></td>
	</tr>
	<tr>
		<td style='white-space: nowrap;' width='20%'><b>N&uacute;mero de comuptadores</b></td>
		<td style='text-align:left'>&nbsp;&nbsp;<?php echo($lab['Laboratory']['number_computers'])?></td>
	</tr>
</table>
<!-- Secao para listagem das reservas -->
<?php
if(isset($reserves) && $reserves != null){
	echo("<table class='calendar-rel'>");
	$indexDayOfWeek = 0;
	$indexTurn = 0;
	$indexDay = 0;

	foreach($reserves as $turn => $res){
		//loop nas reservas
		//$keyTurn apenas armazena qual eh sequencial do horario
		foreach($res as $time => $days){
	
			//
	
			if($indexDayOfWeek == 0 && $indexTurn == 0 ){
				echo ("<tr><td class='cell-dark'>Turno</td>");
				//monta o cabecalho
				foreach( $days as $keyDay => $objReserves){
					echo ("<td class='cell-dark'>");
	
					if( (date('N', $keyDay) + 1 ) == 7){
						echo ("<p class='sabado'>");
					}else{
						echo ('<p>');
					}
	
					echo (date('d/m/Y', $keyDay));
					echo ('</p>');
	
					if( (date('N', $keyDay) + 1 ) == 7){
						echo ("<p class='sabado'>");
					}else{
						echo ('<p>');
					}
	
					echo ($daysOfWeek[date('w', $keyDay)]);
					echo ('</p>');
	
					echo ("</td>");
				}
				echo ("</tr>");
			}
			echo ("<td class='cell-dark'>");
			echo ("<p style='font-size:12px'>".$schedule->showTime( $turn, $time )."<span></span></p>");
			if( $turn == 1){
				echo ("<p style='color:#4444BB;'>(".$schedule->showTimeSaturday( $turn, $time ).")");
				echo("<span class='sabado'>*</span>");
				echo ("</p>");
			}
	
			echo ("</td>");
	
			//loop nos dias do periodo informado
			foreach( $days as $keyDay => $objReserves){
				if($objReserves == null ){
					echo ("<td>");
					echo ("<div class='cell-action'>");
					echo ("<p class='head-action'>");
					echo ("&nbsp;");
					echo ("</p>");
					echo ("<p>");
					echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
					echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
					echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
					echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
					echo ("</p>");
					echo ("</div>");
					echo ("</td>");
				}else{
					echo("<td class='occupied' style='text-align:center'>");
					echo ("<div class='cell-action'>");
					echo ("<p>");
					echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
					echo ("</p>");
					echo ("<p>");
					echo($objReserves['Discipline']['name']);
					echo ("</p>");
					echo ("<p>(");
					echo($objReserves['Course']['name']);
					echo (")</p>");
					echo ("</div>");
					echo ("</td>");
	
				}
				$indexDay++;
			}
	
			echo ("</tr>");
			$indexTurn++;
	
			$indexDayOfWeek++;
	
		}
	}
	echo("</table>");
}
?>
<br />
<table class="listing" cellspacing="0">
	<tr style="background-color:#DFDFDF">
		<td><b>Disponibilidade de laborat&oacute;rios</b></td>
	</tr>
	<tr>
		<td>Hor&aacute;rios na cor azul s&atilde;o para os aulas de s&aacute;bado</td>
	</tr>
	
</table>
<table class="listing" cellspacing="0">
	<tr style="background-color:#DFDFDF">
		<td><b>Legenda</b></td>
	</tr>
	<tr>
		<td>Hor&aacute;rios na cor azul s&atilde;o para os aulas de s&aacute;bado</td>
	</tr>
	
</table>
