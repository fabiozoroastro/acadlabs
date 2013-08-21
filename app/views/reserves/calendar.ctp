<script type="text/javascript">


/**
 * Configura propriedades de visualizacao de filtros
 */
$(function() {

    $("#btnFindFiltersMinus").click(function(){
        //$("#tableFilters").fadeIn('fast');
    	$("#tableFilters").fadeOut('fast');
    	$("#btnFindFiltersMinus").hide();
    	$("#btnFindFiltersPlus").show();
    });

    $("#btnFindFiltersPlus").click(function(){
        //$("#tableFilters").fadeIn('fast');
    	$("#tableFilters").fadeIn('fast');
    	$("#btnFindFiltersPlus").hide();
    	$("#btnFindFiltersMinus").show();
    });
    
	$( ".datas" ).datepicker({ dateFormat: 'dd/mm/yy' });
	$( ".datas" ).attr("readonly", true);

});

/**
 * Troca o laboratorio
 */
function changePeriod(){

	var o = $("#ReservePeriodId option:selected").text();

	var dates = o.split('até');
	
	var begin = dates[0].trim();
	var end = dates[1].trim();
	
	if($("#ReserveBegin").val() == null || $("#ReserveBegin").val() == ''){
		$("#ReserveBegin").val(begin);
	}

	if($("#ReserveEnd").val() == null || $("#ReserveEnd").val() == ''){
		$("#ReserveEnd").val(end);
	}
}

/**
 * Exibe a tela de reserva
 * @author fabio.zoroastro
 */
function showModal(day, time){

	$( "#dialog-form" ).dialog( "open" );
	var txtDay = '<h2>'+day+'</h2>';
	$( "#ReserveReserveDate" ).val(day);
	$( "#ReserveReserveTime" ).val(time);
	$( "#showDay" ).html(txtDay);
	
}

/**
 * Deleta uma reserva
 * @param day Data de removao
 * @param Long idRes - Id da Reserva
 * @param time Horario que deve ser removido
 * @param boolean all(1 para todo e 0 para um) - Remover todos os registros
 * @author fabio.zoroastro
 */
function deleteReserve(day, idRes, time, all){
	var msg = all ? 'Tem certeza que deseja excluir TODAS as reservas até o fim do período informado?': 'Tem certeza que deseja excluir esta reserva?';
	// Para remover todos valor 1, para remover apenas um o valor eh 0
	var deleteAll = all ? 1 : 0;
	
	if( confirm( msg ) ){
		$('#action').val('deleteReserve');
		$('#ReserveEditReserve').val(idRes);
		$('#ReserveDeleteAllReserve').val(deleteAll);
		$( "#ReserveReserveTime" ).val(time);
		$( "#ReserveReserveDate" ).val(day);
		$('#ReserveCalendarForm').submit();
	}
	
}

/**
 * Abre uma popup e exibe os softwares por laboratorio
 */
function relSoftsPerLab(){
	var labId = $( "#ReserveLaboratoryId" ).val();
	
	if( labId == null || labId == ''){
		alert('Selecione um laboratório!');
	}else{
		var url = "<?php echo($this->base);?>/labsofts/rel/" + labId;
		var name = '_blank';
		var specs = 'height=200, width=300';
		window.open(url, name, specs);
	}
	
}

/**
 * Abre uma popup e exibe o relatorio para os filtors informados
 */
function relReserves(){

	var periodId = $( "#ReservePeriodId" ).val();
	var turn = $( "#ReserveTurn" ).val();
	var labId = $( "#ReserveLaboratoryId" ).val();
	var begin = $( "#ReserveBegin" ).val();
	var end = $( "#ReserveEnd" ).val();
	
	if( periodId == null || periodId == '' 
		|| labId == null || labId == '' 
		|| begin == null || begin == '' 
		|| end == null || end == '' ){
		
		alert('Informe todos os filtros de entrada!');
	}else{

		if(turn == null || turn == ''){
			turn = '-1';
		}
	
		var url = "<?php echo($this->base);?>/reserves/rel/" + periodId ;
		url += '/' + turn;
		url += '/' + labId;
		url += '/' + replaceAll(begin, "/", "-");
		url += '/' + replaceAll(end, "/", "-");
		var name = '_blank';
		var specs = 'height=200, width=300, scrollbars = yes';
		window.open(url, name, specs);
	}
	
}

/**
 * Funcao auxiliar para trocar caracteres
 */
function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

</script>
<div class="calendar form">
 <h2 class="left">Reservas</h2>
 <br />
<?php echo $form->create('Reserve', array('action' => 'calendar')); ?>
<!-- Inicio: Campos utilizados na criacao de uma nova reserva --> 
 <?php echo $form->input('editReserve', array('type' =>'hidden'));?>
 <?php echo $form->input('deleteAllReserve', array('type' =>'hidden'));?> 
 <?php echo $form->input('action', array('id'=>'action', 'type' =>'hidden'));?>
 <?php echo $form->input('courseSelected', array('type' =>'hidden'));?>
 <?php echo $form->input('disciplineSelected', array('type' =>'hidden'));?>
 <?php echo $form->input('continuous', array('type' =>'hidden'));?>
 <?php echo $form->input('reserveDate', array('type' =>'hidden'));?>
 <?php echo $form->input('reserveTime', array('type' =>'hidden'));?>
<!--fim: Campos utilizados na criacao de uma nova reserva -->

<fieldset class='find-filters'>
    <legend>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <img id='btnFindFiltersMinus' src='<?php echo($this->base);?>/img/minus.gif' />
    <img id='btnFindFiltersPlus' src='<?php echo($this->base);?>/img/plus.gif' style='display:none' />
    &nbsp;&nbsp;&nbsp;&nbsp; Filtros de Pesquisa &nbsp;&nbsp;
    </legend>

<?php     
if(isset($reservesPreExistis) && count( $reservesPreExistis ) > 0){
	echo("<div class='error-message' style='font-size: 12px'>");
	echo("Já existe(m) reserva(s) para:");
	echo("</div>");
	echo("<div style='padding-left:5px; font-size: 10px'>");
	echo("<ul>");
	foreach($reservesPreExistis as $r){
		echo('<li>');
		echo('O dia ');
		echo(date('d/m/Y', strtotime( $r['Reserve']['date'])));
		echo('. Disciplina ');
		echo($r['Discipline']['name']);
		echo(' do curso ');
		echo($r['Discipline']['name']);
		
		echo('</li>');
	}
	echo("</ul>");
	echo("</div>");
}
?>
<table id='tableFilters' class="form" width="100%">
	<tr>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><label for="PeriodId">Semestre<span class="required">*</span></label></td>
		<td><div class="input text">
			<?php 
			echo("<select id='ReservePeriodId' tabindex='0' name='data[Reserve][period_id]' class='textfield' style='width: 300px' onchange='changePeriod()'>");
			echo("<option value=''></option>");
 			foreach ($halfYears as $period){
 				if(isset($this->data) && $this->data['Reserve']['period_id'] == $period['Period']['id']) {
 					echo ("<option selected='selected' value='".$period['Period']['id']."' >".date('d/m/Y', strtotime($period['Period']['begin']))."   até   ".date('d/m/Y', strtotime($period['Period']['end']))."</option>");
 				}else{
 					echo ("<option value='".$period['Period']['id']."' >".date('d/m/Y', strtotime($period['Period']['begin']))."   até   ".date('d/m/Y', strtotime($period['Period']['end']))."</option>");
 				}
			}
			echo("</select>");
			echo( $form->error('period_id'));
			?>
			</div>
 		</td>
 		<td><h3>Relat&oacute;rios</h3></td>
	</tr>
	<tr>
		<td><label for="TurnId">Turno<span class="required">*</span></label></td>
		<td><?php echo $form->input('turn',array('label' => false, 'tabindex' => '1' , 'options' => array('1' => 'Manhã','2' =>'Tarde','3' => 'Noite'), 'empty' => true,  'class' => 'textfield', 'style' => 'width: 300px', 'onchange' => 'changeLab(this.value)') );?></td>
		<td rowspan="3">
			<ul class="relatorios">
				<li><a href="javascript:relSoftsPerLab()">Softwares por laborat&oacute;rio</a></li>
				<li><a href="javascript:relReserves()">Hor&aacute;rios</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td><label for="LaboratoryId">Laborat&oacute;rio<span class="required">*</span></label></td>
		<td><?php echo $form->input('laboratory_id',array('text' => 'Laboratory.description','tabindex' => '2' , 'label' => false, 'options' => $laboratories, 'empty' => true,  'class' => 'textfield', 'style' => 'width: 300px', 'onchange' => 'changeLab(this.value)') );?></td>
	</tr>
	<tr>
		<td><label for="PeriodoId">Per&iacute;odo<span class="required">*</span></label></td>
		<td nowrap="nowrap">
		<table>
			<tr>
				<td><?php echo $form->input('begin', array('label' => false, 'tabindex' => '2' , 'class' => 'textfield datas', 'style' => 'height: 25px; width: 120px')); ?></td>
				<td style="text-align: center; vertical-align: middle">&nbsp;&nbsp;&nbsp;at&eacute;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $form->input('end', array('label' => false, 'tabindex' => '3' , 'class' => 'textfield datas', 'style' => 'height: 25px; width: 120px')); ?></td>
				<td style="text-align: center; vertical-align: middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $this->Form->submit('Recarregar', array('class' => 'button', 'onclick' => '$(\'#action\').val(\'\');' )); ?><?php echo $form->end(); ?></td> 
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td  class='alert' colspan="3"><?php if(isset($reserves) && $reserves != null) { echo("<p><span class='sabado'>*</span>Horários das aulas de sábado</p>"); } ?></td>
	</tr>
</table>
<br />
</fieldset>
<!-- Secao para listagem das reservas --> <?php 

if(isset($reserves) && $reserves != null){
	echo ("<div class='scroll-pane ui-widget ui-widget-header ui-corner-all'>");
	echo("<div class='acadEvents scroll-content'>");

	echo("<table class='calendar'>");
	$indexDayOfWeek = 0;
	$indexTurn = 0;
	$indexDay = 0;

	//loop nas reservas
	//$keyTurn apenas armazena qual eh sequencial do horario
	foreach($reserves as $time => $days){

		//

		if($indexDayOfWeek == 0 && $indexTurn == 0 ){
			echo ("<tr><td class='ui-widget-header'>Turno</td>");
			//monta o cabecalho
			foreach( $days as $keyDay => $objReserves){
				echo ("<td class='ui-widget-header'>");
				
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
		echo ("<td class='ui-widget-header'>");
		echo ("<p style='font-size:12px'>".$schedule->showTime( $this->data['Reserve']['turn'], $time )."<span></span></p>");
		if( $this->data['Reserve']['turn'] == 1){
		echo ("<p style='color:#888;'>(".$schedule->showTimeSaturday( $this->data['Reserve']['turn'], $time ).")");
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
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("</p>");
				echo ("<p>");
				echo("<img class='create-user' onclick='showModal(\"".date('d/m/Y', $keyDay)."\",".$time.");' src='$this->base/img/add.png' />");
				echo ("</p>");
				echo ("<p>");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo ("</p>");
				echo ("</div>");
				echo ("</td>");
			}else{
				echo("<td class='occupied'>");
				echo ("<div class='cell-action'>");
				echo ("<p class='head-action'>");
				echo ("Ocupado");
				echo ("</p>");
				echo ("<p>");
				echo("<img src='$this->base/img/delete.png' onclick='deleteReserve(\"".date('d/m/Y', $keyDay)."\",".$objReserves['Reserve']['id'].",null, false);' />");
				echo ("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
				echo("<img src='$this->base/img/trash.png' onclick='deleteReserve(\"".date('d/m/Y', $keyDay)."\",".$objReserves['Reserve']['id'].",".$time.", true);' />");
				echo ("</p>");
				echo ("<p>");
				echo($objReserves['Course']['name']);
				echo ("</p>");
				echo ("<p>");
				echo($objReserves['Discipline']['name']);
				echo ("</p>");
				echo ("</div>");
				echo ("</td>");

			}
			$indexDay++;
		}

		echo ("</tr>");
		$indexTurn++;

		$indexDayOfWeek++;

	}
	echo("</table>");
	echo("</div>");//<!-- Div CONTENT -->
	echo("<div class='scroll-bar-wrap ui-widget-content ui-corner-bottom'>");
	echo("<div class='scroll-bar'></div>");
	echo("</div>");

	echo("</div>");//<!-- DIV GERAL DO CALENDARIO -->
}
?></div>
<!--  DIV DA TELA EM GERAL -->

<div id="dialog-form" title="Realizar Reserva">
<div id='showDay'></div>
<p class="validateTips"></p>
<div class="calendar form">
<fieldset>
<label for="Disciplina">Disciplina</label><?php echo $form->input('discipline_id', array('id'=>'Disciplina', 'label' => false, 'options' => $disciplines, 'empty' => true,  'class' => 'textfield ui-widget-content ui-corner-all', 'style' => 'width: 200px;height:30px;') );?>
<label for="Recorrente">Recorrente</label> <input type="checkbox" name="recorrente" id='Recorrente' class="textfield ui-widget-content ui-corner-all" />
</fieldset>
<?php echo $form->end(); ?> 
</div>
</div>