<script>
/**
 * Configura propriedades de visualizacao de filtros
 */
$(function() { 
	$( ".datas" ).datepicker({ dateFormat: 'dd/mm/yy' });
	$( ".datas" ).attr("readonly", true);

});
</script>
<div class="discipline form"><?php echo $form->create('Period',array('action' => 'edit')); ?>

<table class="form">
	<tr>
		<th>
		<h2 class="left">Novo Per&iacute;odo Letivo</h2>
		 <?php echo $form->input('id', array('type' =>'hidden'));?>
		</th>
	</tr>
	<tr>
		<td>
		<table>
		    <tr><td><label for="PeriodBegin">Per&iacute;odo</label><span class="required">*</span></td></tr>
			<tr>
				<td><?php echo $form->input('begin', array('label' => false, 'type'=>'text', 'tabindex' => '2' , 'class' => 'textfield datas', 'style' => 'height: 25px; width: 120px')); ?></td>
				<td style="text-align: center; vertical-align: middle">&nbsp;&nbsp;&nbsp;at&eacute;&nbsp;&nbsp;&nbsp;</td>
				<td><?php echo $form->input('end', array('label' => false, 'type'=>'text', 'tabindex' => '3' , 'class' => 'textfield datas', 'style' => 'height: 25px; width: 120px')); ?></td>
				<td style="text-align: center; vertical-align: middle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
			</tr>
			<tr>
			<td colspan="4"><?php echo( $form->error('period'));?></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td><?php echo $form->submit('Gravar', array( 'id' => 'save', 'class' => 'form button' )); ?></td>
	</tr>
</table>
<br />
<div id="softs"></div>
		<?php echo $form->end(); ?></div>
